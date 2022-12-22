<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedUserException extends HttpException
{
    public static function forRoles( $roles): self
    {
        return new static(403, 'User does not have the right roles.', null, []);
    }

    public static function forPermissions( $permissions): self
    {
        return new static(403, 'User does not have the right permissions.', null, []);
    }

    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }


    public static function isBlocked(): self
    {
        return new static(403, 'Your account was blocked .', null, []);
    }
}
