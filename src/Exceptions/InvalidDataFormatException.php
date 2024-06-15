<?php

namespace SitemapGenerator\Src\Exceptions;

use Exception;

class InvalidDataFormatException extends Exception {
    public function __construct() {
        $message = "Отсутствуют данные для генерации или не указан путь до файла";
        parent::__construct($message);
    }
}