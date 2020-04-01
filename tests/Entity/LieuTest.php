<?php

namespace App\Tests\Entity;

use App\Entity\Lieu;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LieuTest extends KernelTestCase {

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

    public function testValidLieu()
    {
        $lieu = (new Lieu())
            ->setNom("Test")
            ->setLatitude(45.18998)
            ->setLongitude(5.633585);
        
        self::bootKernel();

        $error = self::$container->get('validator')->validate($lieu);
        $this->assertCount(0, $error);
    }

    public function testInvalidLieuNom()
    {
        $lieu = (new Lieu())
            ->setNom("")
            ->setLatitude(45.18998)
            ->setLongitude(5.633585);
        
        self::bootKernel();

        $error = self::$container->get('validator')->validate($lieu);
        $this->assertCount(1, $error);
    }

    public function testInvalidLieuLatitudeLongitude()
    {
        $lieu = (new Lieu())
            ->setNom("Test");
        
        self::bootKernel();

        $error = self::$container->get('validator')->validate($lieu);
        $this->assertCount(2, $error);
    }
}