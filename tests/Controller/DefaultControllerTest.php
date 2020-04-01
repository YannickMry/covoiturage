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

        $this->assertSelectorExists('a[href="/login"]');
        $this->assertSelectorExists('a[href="/register"]');
        $this->assertSelectorNotExists('a[href="/logout"]'); 
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

        $this->assertSelectorExists('a[href="/logout"]');
        $this->assertSelectorExists('a[href="/trajet/"]');
        $this->assertSelectorExists('a[href="/trajet/new"]');
        $this->assertSelectorTextContains('button', 'Rechercher un trajet');
        $this->assertSelectorTextNotContains('a', 'Sign up');
        $this->assertSelectorTextNotContains('a', 'Connexion');
    }
}