<?php

namespace App\Services\File;

use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;

class XML
{
    /**
     * @var string
     */
    private $_fileName = null;

    /**
     * @var string
     */
    private $_defaultFileName = 'data_default.xml';

    public function __construct(?string $fileName) {
        $this->_fileName = $fileName;
    }

    /**
     * @return array
     */
    public function getAutoCatalog(): ?array {
        if ($this->_fileName !== null) {
            return Storage::disk('local')->exists($this->_fileName)
                ? XmlToArray::convert(Storage::disk('local')->get($this->_fileName))
                : null;
        } else {
            echo 'Default file is used.';
            return XmlToArray::convert(Storage::disk('local')->get($this->_defaultFileName));
        }
    }
}
