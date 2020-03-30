<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {

    public function testHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Quand l'utilisateur est connecté
     */
    public function testHomepageUserLink()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW' => 'test'
        ]);
        $crawler = $client->request('GET', '/');

        $this->assertSelectorExists('a[href="/login"]', 'Connexion');
        //$this->assertSelectorNotExists('a[href="/register"]', 'Sign up');
        // $this->assertSelectorExists('a[href="/logout"]');
        
        // $client->clickLink('Déconnexion');
        // $this->assertResponseRedirects('http://localhost/');
    }
}