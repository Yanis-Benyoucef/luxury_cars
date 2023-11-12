<?php

require_once __DIR__ . '/../EmailError.php';

class EmptyEmailException extends InvalidArgumentException
{
    public function __construct()
    {
        $this->code = EmailError::EMPTY;
    }
}