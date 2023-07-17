<?php

use PHPUnit\Event\Code\Throwable;

class UserDoesNotExistException extends \Exception
{
    public function __construct($message = 'User does not exist', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
