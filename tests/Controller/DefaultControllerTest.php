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
     * Quand l'utilisateur est déconnecté
     */
    public function testHomepageUserDisconnectedLinks()
    {
        $client = static::createClient([], []);
        $crawler = $client->request('GET', '/', [], [], []);

        $this->assertSelectorExists('a[href="/login"]', 'Connexion');
        $this->assertSelectorExists('a[href="/register"]', 'Sign up');
        $this->assertSelectorNotExists('a[href="/logout"]', 'Deconnexion'); 
    }

    /**
     * Quand l'utilisateur est connecté
     */
    public function testHomepageUserConnectedLinks()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'nomp',
            'PHP_AUTH_PW'   => 'test',
        ]);
        $client->request('GET', '/');

        $this->assertSelectorNotExists('a[href="/login"]', 'Connexion');
        $this->assertSelectorNotExists('a[href="/register"]', 'Sign up');
        $this->assertSelectorExists('a[href="/logout"]', 'Deconnexion');
    }
}