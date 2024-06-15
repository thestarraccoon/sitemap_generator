<?php

namespace SitemapGenerator\Src\Exceptions;

use Exception;
class UnsupportedFormatException extends Exception {
    public function __construct($fileFormat) {
        if (!empty($fileFormat)) {
            $message = "Указанный формат '$fileFormat' не поддерживается для конвертации";
        } else {
            $message = "Формат выходного файла не указан";
        }

        parent::__construct($message);
    }
}