<?php

require_once __DIR__ . '/../EmailError.php';

class InvalidEmailException extends InvalidArgumentException
{
    public function __construct()
    {
        $this->code = EmailError::INVALID;
    }
}