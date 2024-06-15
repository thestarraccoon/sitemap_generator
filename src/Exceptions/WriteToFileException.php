<?php

namespace SitemapGenerator\Src\Exceptions;

use Exception;

class WriteToFileException extends Exception
{
    public function __construct($message) {
        parent::__construct($message);
    }
}