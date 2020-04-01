<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrajetControllerTest extends WebTestCase {

    // Redirige vers /login si on veut acceder a new trajet (Si on est pas connecté)
    public function testForbiddenToUser(){
        $client = static::createClient();
        $client->request('GET', '/trajet/new');

        // Il trouve la page mais il se fait rediriger vers /login
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND); 
        $this->assertResponseRedirects('/login');
    }

    public function testAllowedToUser(){

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW' => 'test'
        ]);
        
        $client->request('GET', '/trajet/new');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}