<?php

declare(strict_types=1);

namespace App\Identity\User\Domain\Model;

use App\Identity\User\Domain\ValueObject\UserEmail;
use App\Identity\User\Domain\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '"user"')]
class User
{
    #[ORM\Embedded(columnPrefix: false)]
    public readonly UserId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        public UserEmail $email,
    ) {
        $this->id = new UserId();
    }
}
