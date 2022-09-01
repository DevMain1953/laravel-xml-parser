<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Auto;
use App\Models\Generation;
use Carbon\Carbon;

class DataHandler
{
    /**
     * @param array
     */
    public static function saveOrUpdateGenerationsFromAutoCatalog(?array $autoCatalog) {
        if ($autoCatalog === null) {
            echo 'Auto catalog is empty.';
            return;
        } else {
            $generations = [];
            foreach ($autoCatalog['offers']['offer'] as $offer) {
                if (!empty($offer['generation_id']) && !empty($offer['generation'])) {
                    $generations[] = [
                        'id'   => $offer['generation_id'],
                        'name' => $offer['generation'],
                    ];
                }
            }
            Generation::upsert(array_unique($generations, SORT_REGULAR), ['name']);
        }
    }

    /**
     * @param array
     */
    public static function saveOrUpdateAutosFromAutoCatalog(?array $autoCatalog) {
        if ($autoCatalog === null) {
            echo 'Auto catalog is empty.';
            return;
        } else {
            $autos = [];
            foreach ($autoCatalog['offers']['offer'] as $offer) {
                $color = !empty($offer['color']) ? $offer['color'] : null;
                $generation_id = !empty($offer['generation_id']) ? $offer['generation_id'] : null;
                $autos[] = [
                    'id'            => $offer['id'],
                    'mark'          => $offer['mark'],
                    'model'         => $offer['model'],
                    'year'          => $offer['year'],
                    'run'           => $offer['run'],
                    'color'         => $color,
                    'body-type'     => $offer['body-type'],
                    'engine-type'   => $offer['engine-type'],
                    'transmission'  => $offer['transmission'],
                    'gear-type'     => $offer['gear-type'],
                    'generation_id' => $generation_id,
                ];
            }
            Auto::upsert(array_unique($autos, SORT_REGULAR), ['mark', 'model',
                'year', 'run', 'color', 'body-type', 'engine-type', 'transmission',
                'gear-type', 'generation_id']);
        }
    }

    public static function deleteUnchangedAutos() {
        $lastUpdatedAuto = Auto::orderByDesc('updated_at')->first();
        Auto::where('updated_at', '<', $lastUpdatedAuto->updated_at)->delete();
    }

    public static function deleteUnchangedGenerations() {
        $lastUpdatedGeneration = Generation::orderByDesc('updated_at')->first();
        Generation::where('updated_at', '<', $lastUpdatedGeneration->updated_at)->delete();
    }
}
