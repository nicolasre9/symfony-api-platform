<?php

namespace App\Exception\Password;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordException extends BadRequestHttpException
{

    public static function invalidLength(): sekf
    {
        throw new self('Password must be at 6 character');
    }
}

?>