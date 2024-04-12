<?php
declare(strict_types=1);

namespace App\Tournament\Exceptions;

use Exception;
use Throwable;

class MatchCountEvenException extends Exception
{
    public function __construct($message = "The number of matches must be even.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}