<?php

namespace SitemapGenerator\Src\Exceptions;

use Exception;

class SerializationException extends Exception
{
    public function __construct($fileFormat) {
        $message = "Не удалось сериализовать данные в $fileFormat формат";
        parent::__construct($message);
    }
}