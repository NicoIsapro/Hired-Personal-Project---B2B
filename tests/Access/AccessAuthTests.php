<?php

namespace WebBundle\Tests\Access;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessTest extends WebTestCase
{
    public function testAccessAdminAnon()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');
        $client->followRedirect();

        $this->assertContains('Login', $client->getResponse()->getContent());
    }
    public function testAccessClientAnon()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/clients');
        $client->followRedirect();

        $this->assertContains('Login', $client->getResponse()->getContent());
    }
}
