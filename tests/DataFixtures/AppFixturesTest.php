<?php

namespace App\Tests\DataFixtures;

use App\Repository\LieuRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppFixturesTest extends KernelTestCase {

    public function testUser()
    {
        self::bootKernel();
        $users = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(2, $users);
    }

    public function testLieu()
    {
        self::bootKernel();
        $lieux = self::$container->get(LieuRepository::class)->count([]);
        $this->assertEquals(11, $lieux);
    }
}