<?php

namespace Uiibevy\Friends\Exceptions;

use Exception;

class ServiceNotFound extends Exception
{
    public function __construct($service)
    {
        parent::__construct("$service service not found.");
    }
}
