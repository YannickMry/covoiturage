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

}