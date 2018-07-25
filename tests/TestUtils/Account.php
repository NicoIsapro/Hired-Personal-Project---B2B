<?php
require_once(__ROOT__.'/WebsiteWebTestCase.php');
require_once(__ROOT__.'/TestUtils/Crawling.php');
require_once(__ROOT__.'/TestUtils/Form.php');

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;

trait Account
{
    use Crawling, Form;

    /**
     * @param Client $client
     * @param string $locale
     * @param string $email
     * @param string $password
     * @param bool   $private
     * @param string $admin
     *
     * @return Crawler
     */
    protected static function login(Client $client, string $locale = 'en', string $email, string $password, bool $private = false, $admin = null)
    {
        $crawler = self::crawlTo(
            $client,
            null !== $admin ?
                $admin :
                ($private ?
                    'private.login' :
                    'marketplace.login'
                ),
            $locale
        );
        $crawler = self::followAllRedirects($client) ?? $crawler;
        return $client->submit(self::getFilledForm(
            $crawler,
            'form-login',
            [
                '_username' => $email,
                '_password' => $password,
            ]
        ));
    }

    /**
     * Easier login function using credentials defines in WebsiteWebTestCase const ACCOUNTS.
     *
     * @param Client $client
     * @param string $account
     * @param string $locale
     * @param bool   $private
     *
     * @return Crawler
     */
    protected static function autoLogin(Client $client, string $account, string $locale, bool $private = false)
    {
        return self::login(
            $client,
            $locale,
            WebsiteWebTestCase::ACCOUNTS[$account]['email'],
            WebsiteWebTestCase::ACCOUNTS[$account]['password'],
            false,
            'marketplace.login'
        );
    }

    /**
     * @param Client $client
     * @param string $locale
     * @param bool   $private
     *
     * @return Crawler
     */
    protected static function logout(Client $client, $locale = 'en', bool $private = false)
    {
        return self::crawlTo($client, 'marketplace.logout', $locale);
    }

    /**
     * @param Client $client
     * @param string $account
     * @param string $locale
     *
     * @return Crawler
     */
    protected static function register(Client $client, $locale = 'en')
    {
        $crawler = self::crawlTo($client, 'marketplace.register', $locale);
        $crawler = self::followAllRedirects($client) ?? $crawler;
        $web = new WebsiteWebTestCase;
        $form = self::getFilledForm(
            $crawler,
            'user_registration_form',
            [
              'user_registration_form' => [
                'company'  => $web->getCompanyName(4, 12),
                'email'    => $web->getEmail(),
                'password' => $web->getPassword(5, 10),
                'username' => $web->getUsername(),
                'surname'  => $web->getRandomName(6),
                'name'     => $web->getRandomName(6),
              ],
            ]
        );
        //self::tickCheckboxes($form, ['fos_user_registration_form[accepte]']);

        return $client->submit($form);
    }
}
