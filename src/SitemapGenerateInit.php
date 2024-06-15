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

$pages = [
    [
        'loc' => 'https://example.com/home',
        'lastmod' => '2024-06-10',
        'changefreq' => 'daily',
        'priority' => '1.0'
    ],
    [
        'loc' => 'https://example.com/about-us',
        'lastmod' => '2024-06-09',
        'changefreq' => 'monthly',
        'priority' => '0.8'
    ],
    [
        'loc' => 'https://example.com/contact',
        'lastmod' => '2024-06-08',
        'changefreq' => 'yearly',
        'priority' => '0.5'
    ],
    [
        'loc' => 'https://example.com/services',
        'lastmod' => '2024-06-07',
        'changefreq' => 'weekly',
        'priority' => '0.9'
    ],
    [
        'loc' => 'https://example.com/products',
        'lastmod' => '2024-06-06',
        'changefreq' => 'daily',
        'priority' => '0.7'
    ],
    [
        'loc' => 'https://example.com/blog',
        'lastmod' => '2024-06-05',
        'changefreq' => 'weekly',
        'priority' => '0.6'
    ],
    [
        'loc' => 'https://example.com/blog/post-1',
        'lastmod' => '2024-06-04',
        'changefreq' => 'monthly',
        'priority' => '0.7'
    ],
    [
        'loc' => 'https://example.com/blog/post-2',
        'lastmod' => '2024-06-03',
        'changefreq' => 'monthly',
        'priority' => '0.6'
    ],
    [
        'loc' => 'https://example.com/blog/post-3',
        'lastmod' => '2024-06-02',
        'changefreq' => 'daily',
        'priority' => '0.8'
    ],
    [
        'loc' => 'https://example.com/privacy-policy',
        'lastmod' => '2024-06-01',
        'changefreq' => 'yearly',
        'priority' => '0.4'
    ]
];
$fileType = 'xml';
$pathToFile = '/generates/sitemap.docx';

$main = new SitemapGenerateInit($pages, $fileType, $pathToFile);
print_r($main->initSitemapGenerate());