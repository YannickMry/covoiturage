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
    public function testHomepageUserLinks()
    {
        $client = static::createClient([], []);
        $crawler = $client->request('GET', '/', [], [], []);

        $this->assertSelectorExists('a[href="/login"]', 'Connexion');
        $this->assertSelectorNotExists('a[href="/logout"]', 'Deconnexion');
        $this->assertSelectorExists('a[href="/register"]', 'Sign up');
    }
}