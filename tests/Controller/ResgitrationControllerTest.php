<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase {

    public function testRoute()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $this->assertSelectorTextContains('h1', "Inscription");
        $this->assertSelectorTextContains('button', "S'inscrire");

        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testInscriptionInvalidEmail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'registration_form[nom]'            => 'Nom',
            'registration_form[prenom]'         => 'Prenom',
            'registration_form[email]'          => 'nom.prenom',
            'registration_form[username]'       => 'nomp2',
            'registration_form[plainPassword]'  => 'test123',
        ]);

        $client->submit($form);
        $this->assertSelectorTextContains('.form-error-message', 'This value is not a valid email address.');
    }

    public function testInscriptionInvalidPassword()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'registration_form[nom]'            => 'Nom',
            'registration_form[prenom]'         => 'Prenom',
            'registration_form[email]'          => 'nom.prenom@test.fr',
            'registration_form[username]'       => 'nomp2',
            'registration_form[plainPassword]'  => 'test',
        ]);

        $client->submit($form);
        $this->assertSelectorTextContains('.form-error-message', 'Your password should be at least 6 characters');
    }

    public function testInscriptionValid()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $client->enableProfiler();

        $form = $crawler->selectButton("S'inscrire")->form([
            'registration_form[nom]'            => 'Nom',
            'registration_form[prenom]'         => 'Prenom',
            'registration_form[email]'          => 'nom.prenom@test.fr',
            'registration_form[username]'       => 'nomp2',
            'registration_form[plainPassword]'  => 'test123',
        ]);

        $client->submit($form);
        $this->assertSelectorNotExists('.form-error-message');
        $this->assertResponseRedirects();
    }
}