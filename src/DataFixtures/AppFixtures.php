<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $plainPassword = 'test';

        $user = new User();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setNom('nom')
            ->setPrenom('prenom')
            ->setUsername('nomp')
            ->setEmail('nom.prenom@gmail.com')
            ->setPassword($encoded);

        $manager->persist($user);

        for ($i=0; $i < 10; $i++) { 
            $lieu = new Lieu();
            $lieu->setNom("Lieu $i")
                ->setLatitude(40.2179+$i)
                ->setLongitude(1.2329+$i);
            $manager->persist($lieu);
        }

        $manager->flush();
    }
}
