<?php

namespace WebBundle\Tests\Redirections;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RootRedirectionTest extends WebTestCase
{
    public function testRedirectionRoot()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('/shop/Developer', $client->getResponse()->getContent());
    }
    public function testRedirectionAdminNotAuth()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');

        $this->assertContains('/login', $client->getResponse()->getContent());
    }
    public function testRedirectionClientNotAuth()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/clients');

        $this->assertContains('/login', $client->getResponse()->getContent());
    }
}
