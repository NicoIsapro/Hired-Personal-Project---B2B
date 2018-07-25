<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/WebsiteWebTestCase.php');
require_once(__ROOT__.'/TestUtils/Account.php');

class LoginTest extends WebsiteWebTestCase
{
    use Account;

    public function setUp()
    {
        parent::setUp();

        $this->initializeClient();
    }
    public function testLoginBuyer()
    {
        self::autoLogin($this->client, 'buyer', 'fr');

        self::followAllRedirects($this->client);

        $this->assertSame(
            self::getRoute('marketplace.buyer.dashboard', $this->locale),
            $this->client->getRequest()->getRequestUri(),
            $this->getDumpedErrorMessage('When a validated seller connect he should be redirected to the buyer panel')
        );
    }
    public function testLoginAdmin()
    {
      self::autoLogin($this->client, 'admin', 'fr');

      self::followAllRedirects($this->client);

      $this->assertSame(
          self::getRoute('marketplace.admin.dashboard', 'fr'),
          $this->client->getRequest()->getRequestUri(),
          $this->getDumpedErrorMessage('Connected admin should be redirected to admin dashboard')
      );
    }
    public function testPageAdmin()
    {
      self::autoLogin($this->client, 'admin', 'fr');

      self::followAllRedirects($this->client);

      $this->assertContains('Admin Dashboard', $this->client->getResponse()->getContent());
      $this->getDumpedErrorMessage('Admin page is not loading correctly');
    }
    public function testPageBuyer()
    {
      self::autoLogin($this->client, 'buyer', 'fr');

      self::followAllRedirects($this->client);

      $this->assertContains('Pro Dashboard', $this->client->getResponse()->getContent());
      $this->getDumpedErrorMessage('Buyer page is not loading correctly');
    }
}
