<?php

namespace SitemapGenerator\Src\Formats;

use DOMDocument;
use SitemapGenerator\Src\ASitemapGenerator;
use SitemapGenerator\Src\Exceptions\SerializationException;
use SitemapGenerator\Src\Exceptions\WriteToFileException;

class XmlSitemapGenerator extends ASitemapGenerator
{
    private const XMLNS = 'http://www.sitemaps.org/schemas/sitemap/0.9';
    private const XMLNS_XSI = 'http://www.w3.org/2001/XMLSchema-instance';
    private const XSI_SCHEMA_LOCATION = 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd';

    /**
     * Exception`ов в этом классе нет, потому что каждый из используемых методов
     * DOMDocument выбросит свою ошибку из которой и так понятно что не так
     *
     * @return int
     * @throws \DOMException
     */
    public function generate(): int
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', self::XMLNS);
        $urlset->setAttribute('xmlns:xsi', self::XMLNS_XSI);
        $urlset->setAttribute('xsi:schemaLocation', self::XSI_SCHEMA_LOCATION);

        $dom->appendChild($urlset);

        foreach ($this->pages as $page) {

            $url = $dom->createElement('url');

            foreach ($page as $key => $value) {
                $element = $dom->createElement($key, htmlspecialchars($value));
                $url->appendChild($element);
            }

            $urlset->appendChild($url);
        }

        $xml_generated = $dom->saveXML();

        $this->pathToSaveFile = $this->checkFiletypeAndFileExtensionInPath($this->fileFormat, $this->pathToSaveFile);

        return $this->writeToFile($xml_generated, $this->pathToSaveFile);
    }

    /**
     * @param array|string $pages       Array with pages of site. String - if its XML.
     * @param string $pathToSaveFile    Path to file in filesystem
     * @return int
     * @throws
     */
    protected function writeToFile($pages, $pathToSaveFile): int
    {
        return $this->fileForcePutContents($pathToSaveFile, $pages);
    }
}