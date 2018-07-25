<?php

require_once(__ROOT__.'/WebsiteWebTestCase.php');
require_once(__ROOT__.'/TestUtils/Account.php');
require_once(__ROOT__.'/TestUtils/Crawling.php');

class LogoutTest extends WebsiteWebTestCase
{
    use Account;

    public function setUp()
    {
        parent::setUp();

        $this->initializeClient();
    }
    public function testLogoutBuyer()
    {
        self::autoLogin($this->client, 'buyer', 'en');
        self::crawlTo($this->client, 'marketplace.logout', 'en');
        self::followAllRedirects($this->client);

        $this->assertSame(
            self::getRoute('marketplace.shop.index', $this->locale),
            $this->client->getRequest()->getRequestUri(),
            $this->getDumpedErrorMessage('When a user logout he sould be redirected to the shop')
        );
    }
}