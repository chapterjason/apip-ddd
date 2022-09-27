<?php

declare(strict_types=1);

namespace App\Tests\User\DummyFactory;

use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\UserEmail;

final class DummyUserFactory
{
    private function __construct()
    {
    }

    public static function createUser(
        string $email = null,
    ): User {
        if (null === $email) {
            $email = self::randomEmail();
        }

        return new User(
            new UserEmail($email),
        );
    }

    private static function randomString(): string
    {
        $length = random_int(5, 10);
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private static function randomEmail()
    {
        return self::randomString().'@'.self::randomString().'.com';
    }
}
