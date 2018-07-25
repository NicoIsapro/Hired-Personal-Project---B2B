<?php

require_once(__ROOT__.'/WebsiteWebTestCase.php');
require_once(__ROOT__.'/TestUtils/Account.php');

class SignupTest extends WebsiteWebTestCase
{
  use Account;

  public function setUp()
  {
      parent::setUp();

      $this->initializeClient();
  }
  public function testRegisterBuyer()
  {
      self::register($this->client, 'en');

      self::followAllRedirects($this->client);

      $this->assertSame(
          self::getRoute('marketplace.login', 'en'),
          $this->client->getRequest()->getRequestUri(),
          $this->getDumpedErrorMessage('When a user sign up he should be redirected to login page')
      );
  }
}