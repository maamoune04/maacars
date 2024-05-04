<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    public function testUserValid(): void
    {
       self::bootKernel();

        $user = $this->_getDefaultUser();

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(0, $errors);
    }


    public function testUserRole(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();

        $this->assertContains('ROLE_USER', $user->getRoles());
    }

    public function testUserPasswordContainsUpperCase(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setPassword('passw0rd');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserPasswordContainsLowerCase(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setPassword('PASSW0RD');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserPasswordContainsNumber(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setPassword('Password');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserPasswordLength(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setPassword('Pass0');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserEmail(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setEmail('maamoune');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserFirstnameBlank(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setFirstname(' ');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(1, $errors);
    }

    public function testUserLastnameBlank(): void
    {
        self::bootKernel();

        $user = $this->_getDefaultUser();
        $user->setLastname('');

        $errors = self::getContainer()->get('validator')->validate($user);

        $this->assertCount(2, $errors);
    }


    private function _getDefaultUser(): User
    {
        $user = new User();
        $user->setEmail('maamoune@mail.com')
            ->setPassword('Passw0rd')
            ->setFirstname('Maamoune')
            ->setLastname('Hassane')
            ;

        return $user;
    }
}
