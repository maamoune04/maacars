<?php

namespace App\Story;

use App\Entity\User;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Story;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserStory extends Story
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher){}

    public function build(): void
    {
        UserFactory::new()->create([
            'email' => 'maamoune@mail.com',
            'password' => $this->passwordHasher->hashPassword(new User(), 'Passw0rd'),
            'roles' => ['ROLE_ADMIN'],
            'firstName' => 'Maamoune',
            'lastName' => 'Hassane',
            ]);

        UserFactory::createMany(23);

    }
}
