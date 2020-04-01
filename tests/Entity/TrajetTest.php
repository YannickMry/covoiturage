<?php

namespace App\Tests\Entity;

use App\Entity\Lieu;
use App\Entity\Trajet;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TrajetTest extends KernelTestCase {

    protected $trajet;

    public function setUp()
    {
        $this->trajet = new Trajet();
    }

    public function testNewTrajet() 
    {
        $trajet = new Trajet();
        $this->assertInstanceOf(Trajet::class, $trajet);
    }

    public function testTrajetLieuDepart()
    {
        $lieu = new Lieu();
        $this->trajet->setLieuDepart($lieu);
        $this->assertInstanceOf(Lieu::class, $this->trajet->getLieuDepart());
    }

    public function testTrajetLieuArrivee()
    {
        $lieu = new Lieu();
        $this->trajet->setLieuArrivee($lieu);
        $this->assertInstanceOf(Lieu::class, $this->trajet->getLieuArrivee());
    }

    public function testTrajetDateDepart()
    {
        $date = new \DateTime();
        $this->trajet->setDateDepart($date);
        $this->assertInstanceOf(\DateTime::class, $this->trajet->getDateDepart());
    }

    public function testTrajetPlaces()
    {
        $this->trajet->setPlaces(6);
        $this->assertEquals(6, $this->trajet->getPlaces());
    }

    public function testTrajetConducteur()
    {
        $conducteur = new User();
        $this->trajet->setConducteur($conducteur);
        $this->assertInstanceOf(User::class, $this->trajet->getConducteur());
    }

    public function testTrajetPassagers()
    {
        $passager = new User();
        $passager->setNom('passager1');

        $passager2 = new User();
        $passager2->setNom('passager2');

        $this->trajet->addPassager($passager);
        $this->trajet->addPassager($passager2);

        $this->assertInstanceOf(ArrayCollection::class, $this->trajet->getPassagers());
        foreach ($this->trajet->getPassagers() as $passager) {
            $this->assertInstanceOf(User::class, $passager);
        }
    }

    public function testTrajetUniquePassagers()
    {
        $user = new User();

        $this->trajet->addPassager($user);
        $this->trajet->addPassager($user);

        $this->assertNotEquals([$user, $user], $this->trajet->getPassagers()->toArray());
    }

    public function testTrajetConducteurNotPassager()
    {
        $conducteur = new User();
        $conducteur->setNom('conducteur 1');

        $passager = new User();
        $passager->setNom('passager 1');

        $this->trajet->setConducteur($conducteur);
        $this->trajet->addPassager($passager);

        $this->assertFalse(in_array($this->trajet->getConducteur(), $this->trajet->getPassagers()->toArray()));
    }

    public function testValidTrajet()
    {
        $lieuDepart = (new Lieu())
            ->setNom("Depart")
            ->setLongitude(45.555)
            ->setLatitude(5.555);

        $lieuArrivee = (new Lieu())
            ->setNom("Arrivee")
            ->setLongitude(45.555)
            ->setLatitude(5.555);

        $trajet = (new Trajet())
            ->setLieuDepart($lieuDepart)
            ->setLieuArrivee($lieuArrivee)
            ->setDateDepart(new \DateTime())
            ->setPlaces(3)
            ->setConducteur((new User())->setNom('Conducteur'))
            ->addPassager((new User())->setNom('Passager1'))
            ->addPassager((new User())->setNom('Passager2'))
            ->addPassager((new User())->setNom('Passager3'));
        
        self::bootKernel();
        $error = self::$container->get('validator')->validate($trajet);

        $this->assertCount(0, $error);
    }

    public function testInvalidTrajet()
    {
        $trajet = (new Trajet())
            // ->setLieuDepart($lieuDepart)
            // ->setLieuArrivee($lieuArrivee)
            ->setDateDepart((new \DateTime())->modify('-1 day')) // error 1 : greater than today
            ->setPlaces(0) // error 2 : should be more than 0
            // ->setConducteur((new User())->setNom('Conducteur'))
            ;
        
        self::bootKernel();
        $error = self::$container->get('validator')->validate($trajet);

        $this->assertCount(5, $error);
    }
}