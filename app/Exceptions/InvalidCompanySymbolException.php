<?php

namespace App\Exceptions;

use Exception;

class InvalidCompanySymbolException extends Exception
{
    protected $message = 'Invalid Company Symbol';
}
