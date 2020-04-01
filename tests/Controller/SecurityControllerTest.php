<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase {

    public function testLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request('GET', '/logout');


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoginWithBadCredantials() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            'username' => 'nomp',
            'password' => 'fakepassword',
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/login');
        $client->followRedirect();

        $this->assertSelectorExists('.alert.alert-danger');
    }
}