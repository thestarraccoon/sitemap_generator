<?php

namespace SitemapGenerator\Src\Formats;

use SitemapGenerator\Src\ASitemapGenerator;
use SitemapGenerator\Src\Exceptions\SerializationException;
use SitemapGenerator\Src\Exceptions\WriteToFileException;

class CsvSitemapGenerator extends ASitemapGenerator
{
    private const DELIMITER = ';';
    private const ENCLOSURE = "\"";
    public function generate(): int
    {
        $this->pathToSaveFile = $this->checkFiletypeAndFileExtensionInPath($this->fileFormat, $this->pathToSaveFile);

        return $this->writeToFile($this->pages, $this->pathToSaveFile);
    }

    /**
     * @param array|string $pages       Array with pages of site. String - if its XML.
     * @param string $pathToSaveFile    Path to file in filesystem
     * @return int
     * @throws SerializationException | WriteToFileException
     */
    protected function writeToFile($pages, $pathToSaveFile): int
    {
        $fp = fopen($pathToSaveFile, 'w');

        if ($fp === false) {
            throw new WriteToFileException("Не удалось открыть файл на запись: $pathToSaveFile");
        }

        $isArrayKeysWrittenToFile = false;
        foreach ($pages as $page) {
            if ($isArrayKeysWrittenToFile === false) {
                $writeArrayKeysResult = fputcsv($fp, array_keys($page), self::DELIMITER, self::ENCLOSURE);

                if ($writeArrayKeysResult !== false) {
                    $isArrayKeysWrittenToFile = true;
                } else {
                    throw new SerializationException(strtoupper($this->fileFormat));
                }
            };

            $writeResult = fputcsv($fp, $page, self::DELIMITER, self::ENCLOSURE);

            if ($writeResult === false) {
                throw new SerializationException(strtoupper($this->fileFormat));
            }
        }

        $closeFile = fclose($fp);

        if ($closeFile === false) {
            throw new WriteToFileException("Не удалось сохранить открытый для записи файл: $pathToSaveFile");
        }

        return true;
    }
}