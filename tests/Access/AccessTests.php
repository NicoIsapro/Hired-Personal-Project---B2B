<?php

require_once(__ROOT__.'/WebsiteWebTestCase.php');
require_once(__ROOT__.'/TestUtils/Account.php');

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessAuthTest extends WebsiteWebTestCase
{
  use Account;

  public function setUp()
  {
      parent::setUp();

      $this->initializeClient();
  }
  public function testAccessAdminWithBuyer()
  {
      self::autoLogin($this->client, 'buyer', 'fr');

      self::followAllRedirects($this->client);
      self::crawlTo($this->client, 'marketplace.admin.dashboard', 'en');

      $this->assertContains(
          'Access denied',
          $this->client->getResponse()->getContent()
      );
  }
  public function testAccessBuyerWithAdmin()
  {
      self::autoLogin($this->client, 'admin', 'fr');

      self::followAllRedirects($this->client);
      self::crawlTo($this->client, 'marketplace.buyer.dashboard', 'en');

      $this->assertContains(
          'Access denied',
          $this->client->getResponse()->getContent()
      );
  }
}
