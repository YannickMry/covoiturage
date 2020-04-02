<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LieuControllerTest extends WebTestCase {

    // Redirige vers /login si on veut acceder a new trajet (Si on est pas connecté)
    public function testForbiddenToUser(){
        $client = static::createClient();
        $client->request('GET', '/lieu/new');

        // Il trouve la page mais il se fait rediriger vers /login
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND); 
        $this->assertResponseRedirects('/login');
    }

    public function testAllowedToUser(){

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW' => 'test'
        ]);
        
        $client->request('GET', '/lieu/new');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLieuValid()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW' => 'test'
        ]);
        $crawler = $client->request('GET', '/lieu/new');
        $client->enableProfiler();

        $form = $crawler->selectButton("Save")->form([
            'lieu[nom]'            => 'Toulouse',
            'lieu[longitude]'         => 35.68945,
            'lieu[latitude]'          => 5.86789,
        ]);

        $client->submit($form);
        $this->assertSelectorNotExists('.form-error-message');
        $this->assertResponseRedirects();
    }
    
    public function testLieuInvalidName()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW' => 'test'
        ]);
        $crawler = $client->request('GET', '/lieu/new');
        $client->enableProfiler();

        $form = $crawler->selectButton("Save")->form([
            'lieu[nom]'            => 'Toulouse',
            'lieu[longitude]'         => 45.6666,
            'lieu[latitude]'          => 5.22222,
        ]);

        $client->submit($form);
        $this->assertSelectorExists('.form-error-message');
    }
}