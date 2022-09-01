<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FIle\XML;
use App\Services\DataHandler;

class StoreOffers extends Command
{
    /**
     * @var string
     */
    protected $signature = 'offer:store {fileName?}';

    /**
     * @var string
     */
    protected $description = 'Stores offers from XML file to database';

    public function handle()
    {
        $xml = new XML($this->argument('fileName'));
        $autoCatalog = $xml->getAutoCatalog();
        DataHandler::saveOrUpdateGenerationsFromAutoCatalog($autoCatalog);
        DataHandler::saveOrUpdateAutosFromAutoCatalog($autoCatalog);
        DataHandler::deleteUnchangedAutos();
        DataHandler::deleteUnchangedGenerations();
    }
}
