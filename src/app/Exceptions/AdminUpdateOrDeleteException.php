<?php

namespace App\Exceptions;

class AdminUpdateOrDeleteException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}