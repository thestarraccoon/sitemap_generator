<?php

namespace SitemapGenerator\Src\Formats;

use SitemapGenerator\Src\ASitemapGenerator;
use SitemapGenerator\Src\Exceptions\SerializationException;

class JsonSitemapGenerator extends ASitemapGenerator
{
    public function generate(): int
    {
        $this->pathToSaveFile = $this->checkFiletypeAndFileExtensionInPath($this->fileFormat, $this->pathToSaveFile);

        $encodedData = json_encode($this->pages,JSON_PRETTY_PRINT);

        if (empty($encodedData)) {
            throw new SerializationException(strtoupper($this->fileFormat));
        }

        return $this->writeToFile($encodedData, $this->pathToSaveFile);
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