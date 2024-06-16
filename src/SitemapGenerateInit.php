<?php

namespace SitemapGenerator\Src;

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

    /*  Константа - решение на скорую руку по определению корня проекта.
    *   Учитывается, что либа может быть установлена не обязательно на веб-сервере, возможно и локально
    *   В таком случае $_SERVER['DOCUMENT_ROOT'] может сработать некорректно
    *
    *   Считаем, что либа установлена через composer.
    *   Поэтому в данном случае чтобы выйти в корень проекта нужно подняться 4 раза по дереву директорий
    */
    private const DIR_ROOT = __DIR__ . '/../../../../';

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
                $json = new JsonSitemapGenerator($this->pages, realpath(self::DIR_ROOT) . $this->pathToFile, $this->fileFormat);
                $json->generate();

                break;
            case FileTypesEnumeration::CSV_FORMAT:
                $csv = new CsvSitemapGenerator($this->pages, realpath(self::DIR_ROOT) . $this->pathToFile, $this->fileFormat);
                $csv->generate();

                break;
            case FileTypesEnumeration::XML_FORMAT:
                $xml = new XmlSitemapGenerator($this->pages, realpath(self::DIR_ROOT) . $this->pathToFile, $this->fileFormat);
                $xml->generate();

                break;
            default:
                throw new UnsupportedFormatException($this->fileFormat);
        }

        return true;
    }
}