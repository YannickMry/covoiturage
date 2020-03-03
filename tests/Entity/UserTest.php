<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\User;


class UserTest extends TestCase {

    protected $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testNewUser() 
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserNom()
    {   
        $this->user->setNom('Martin');
        $this->assertEquals('Martin', $this->user->getNom());
    }

    public function testUserPrenom()
    {
        $this->user->setPrenom('Philippe');
        $this->assertEquals('Philippe', $this->user->getPrenom());
    }

    public function testUserEmail()
    {
        $this->user->setEmail('martin.philippe@iut2.fr');
        $this->assertEquals('martin.philippe@iut2.fr', $this->user->getEmail());
    }

    public function testUserUsername()
    {
        $this->user->setUsername('martinp');
        $this->assertEquals('martinp', $this->user->getUsername());
    }

    public function testUserPassword()
    {
        $this->user->setPassword('test');
        $this->assertEquals('test', $this->user->getPassword());
    }
}