<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Lieu;


class LieuTest extends TestCase {

    protected $lieu;

    public function setUp()
    {
        $this->lieu = new Lieu();
    }

    public function testNewUser() 
    {
        $lieu = new Lieu();
        $this->assertInstanceOf(Lieu::class, $lieu);
    }

}