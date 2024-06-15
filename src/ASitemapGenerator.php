<?php

namespace SitemapGenerator\Src;

use SitemapGenerator\Src\Exceptions\WriteToFileException;

abstract class ASitemapGenerator
{
    protected array $pages;
    protected string $pathToSaveFile;
    protected string $fileFormat;

    public function __construct(array $pages, string $pathToSaveFile, string $fileFormat)
    {
        $this->pages = $pages;
        $this->pathToSaveFile = $pathToSaveFile;
        $this->fileFormat = $fileFormat;
    }

    abstract protected function generate(): int;
    abstract protected function writeToFile($pages, $pathToSaveFile): int;

    /**
     * The function is used to create directories and then write the output file
     * if such directories do not exist in the file system.
     *
     * @param string $pathToFile    Path to file in filesystem
     * @param array $pages          Array with pages of site
     * @return bool
     * @throws WriteToFileException
     */
    protected function fileForcePutContents($pathToFile, $pages): bool
    {
        $pathToFile = str_replace('\\', '/', $pathToFile);
        $dirs = explode('/', $pathToFile);
        array_pop($dirs);
        $dir = implode('/', $dirs);

        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new WriteToFileException("Не удалось создать директорию: $dir");
            }
        }

        $writeResult = file_put_contents($pathToFile, $pages);

        if ($writeResult === false) {
            throw new WriteToFileException("Не удалось записать в файл: $pathToFile");
        }

        return $writeResult;
    }

    /**
     * The function is used to identify discrepancies in the extension of the output file,
     * when one extension is specified when passing the file extension parameter,
     * and another is specified in the path to save the file.
     *
     * For example: 'json', 'var/www/site/files/sitemap.xml '.
     * In case of such a discrepancy, the file extension in the path
     * will be replaced with the one that was passed in the parameter for the file extension
     *
     * @param string $fileFormat    Output file format
     * @param string $pathToFile    Path to file in filesystem
     * @return string
     */
    protected function checkFiletypeAndFileExtensionInPath($fileFormat, $pathToFile): string
    {
        $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);

        if ($fileFormat !== $extension) {
            $pathToFile = preg_replace('/\.[^.]+$/', '.' . $fileFormat, $pathToFile);
        }

        return $pathToFile;
    }
}