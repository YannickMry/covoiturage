<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrajetControllerTest extends WebTestCase {

    // Redirige vers /login si on veut acceder a new trajet (Si on est pas connecté)
    public function testForbiddenToUser(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/trajet/new');

        $this->assertNotEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('/login');
    }

    public function testAllowedToUser(){

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW' => 'test'
        ]);
        
        $crawler = $client->request('GET', '/trajet/new');

        $this->assertNotEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('/login');
    }
}