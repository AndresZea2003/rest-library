<?php

namespace Zea\RestLibrary\Exceptions;

use Throwable;

class PlacetoPayServiceException extends PlacetoPayException
{
    public static function fromServiceException(Throwable $e)
    {
        return new self('Error handling operation', 100, $e);
    }
}
