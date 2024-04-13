<?php
declare(strict_types=1);

namespace App\Tournament\Rules\Exceptions;

use Exception;
use Throwable;

class TournamentMeetingNotUniqueException extends Exception
{
    public function __construct($message = "The match is not unique", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}