<?php
require_once(__ROOT__.'/WebsiteWebTestCase.php');

use Symfony\Component\DomCrawler\Link;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;

trait Crawling
{
    /**
     * Return an uri from a route name and set all the parameters
     * The routes are listed in WEB_ROUTES const of the class
     * Different route levels should be point separated
     * (Example: 'marketplace.login').
     *
     * @param string $route
     * @param string $locale
     * @param array  $parameters
     *
     * @return string|null
     */
    protected static function getRoute(string $route, string $locale = 'en', array $parameters = [])
    {
        if (
            empty($route)
            || empty($subRoutes = explode('.', $route))
            || !isset(WebsiteWebTestCase::WEB_ROUTES[$subRoutes[0]])
        ) {
            return null;
        }

        $currentRoute = null;
        foreach ($subRoutes as $key => $subRoute) {
            if (null == $currentRoute) {
                $currentRoute = WebsiteWebTestCase::WEB_ROUTES[$subRoute];
            } else {
                if (!isset($currentRoute[$subRoute])) {
                    return null;
                }
                $currentRoute = $currentRoute[$subRoute];
            }
        }

        $currentRoute = str_replace('{_locale}', $locale, $currentRoute);

        foreach ($parameters as $key => $parameter) {
            $currentRoute = str_replace('{'.$key.'}', $parameter, $currentRoute);
        }

        return $currentRoute;
    }

    /**
     * Return a crawler to the desired route.
     *
     * @param Client $client
     * @param string $route
     * @param string $locale
     * @param array  $parameters
     * @param string $method
     *
     * @return Crawler
     */
    protected static function crawlTo(Client $client, string $route, string $locale = 'en', array $parameters = [], string $method = 'GET')
    {
        return $client->request($method, self::getRoute($route, $locale, $parameters));
    }

    /**
     * Find a link in the page from a crawler and the text of the link.
     *
     * @param Crawler $crawler
     * @param string  $linkText
     *
     * @return Link
     */
    protected static function findLinkFromCrawler(Crawler $crawler, string $linkText)
    {
        return $crawler->filter('a:contains("'.$linkText.'")')->link();
    }

    /**
     * Follow all redirects until the http code is different from 301 or 302.
     *
     * @param Client $client
     *
     * @return null|Crawler
     *
     * @throws \Exception
     */
    protected static function followAllRedirects(Client $client)
    {
        $crawler = null;

        $redirectCount = 0;
        while ($client->getResponse()->isRedirect()) {
            ++$redirectCount;
            if ($redirectCount > 10) {
                throw new \Exception('Too many redirects');
            }
            $crawler = $client->followRedirect();
        }

        return $crawler;
    }

    /**
     * Search a string in the response content and return true if it was found.
     *
     * @param Client $client
     * @param string $needle
     *
     * @return bool
     */
    protected static function isOnPage(Client $client, string $needle)
    {
        return false !== strstr($client->getResponse()->getContent(), $needle);
    }
}
