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

    public function testLieuNom()
    {
        $this->lieu->setNom('Grenoble');
        $this->assertEquals('Grenoble', $this->lieu->getNom());
    }

    public function testLieuLongitude()
    {
        $this->lieu->setLongitude(45.188258);
        $this->assertEquals(45.188258, $this->lieu->getLongitude());
    }
    
    public function testLieuLatitude()
    {
        $this->lieu->setLatitude(5.725154);
        $this->assertEquals(5.725154, $this->lieu->getLatitude());
    }
}