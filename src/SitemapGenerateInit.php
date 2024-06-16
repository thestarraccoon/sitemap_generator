<?php

namespace SitemapGenerator\Src;

require __DIR__ . '/../vendor/autoload.php';

use SitemapGenerator\Src\Enum\FileTypesEnumeration;
use SitemapGenerator\Src\Exceptions\InvalidDataFormatException;
use SitemapGenerator\Src\Exceptions\UnsupportedFormatException;
use SitemapGenerator\Src\Formats\CsvSitemapGenerator;
use SitemapGenerator\Src\Formats\JsonSitemapGenerator;
use SitemapGenerator\Src\Formats\XmlSitemapGenerator;

class SitemapGenerateInit
{
    public array $pages;
    public string $pathToFile;
    public string $fileFormat;
    public function __construct($pages, $fileFormat, $pathToFile)
    {
        $this->pages = $pages;
        $this->fileFormat = $fileFormat;
        $this->pathToFile = $pathToFile;
    }

    public function initSitemapGenerate():bool
    {
        if (empty($this->fileFormat)) {
            throw new UnsupportedFormatException($this->fileFormat);
        }

        if (empty($this->pages)) {
            throw new InvalidDataFormatException();
        }

        if (empty($this->pathToFile)) {
            throw new InvalidDataFormatException();
        }

        switch ($this->fileFormat) {
            case FileTypesEnumeration::JSON_FORMAT:
                $json = new JsonSitemapGenerator($this->pages, __DIR__ . $this->pathToFile, $this->fileFormat);
                $json->generate();

                break;
            case FileTypesEnumeration::CSV_FORMAT:
                $csv = new CsvSitemapGenerator($this->pages, __DIR__ . $this->pathToFile, $this->fileFormat);
                $csv->generate();

                break;
            case FileTypesEnumeration::XML_FORMAT:
                $xml = new XmlSitemapGenerator($this->pages, __DIR__ . $this->pathToFile, $this->fileFormat);
                $xml->generate();

                break;
            default:
                throw new UnsupportedFormatException($this->fileFormat);
        }

        return true;
    }
}