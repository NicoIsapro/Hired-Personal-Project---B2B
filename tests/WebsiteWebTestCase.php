<?php

use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class WebsiteWebTestCase extends WebTestCase
{
    const URL_MARKETPLACE = 'localhost:8000';
    const URL_PRIVATE = 'localhost:8000';
    const IP_DEFAULT = '127.0.0.1';
    const IP_BANNED = '42.42.42.42';

    const DOMAIN_DEFAULT = 'gmail.com';
    const DOMAIN_BANNED = 'yopmail.com';

    const LOCALES = [
        'fr',
        'en',
    ];

    /* Definition of accounts */
    const ACCOUNTS = [
        'admin' => [
            'email' => 'jean.onche',
            'password' => 'michel',
            'description' => 'Admin of the marketplace',
        ],
        'buyer' => [
            'email' => 'michel.dubois',
            'password' => 'test',
            'description' => 'Buyer of the marketplace', /* Employee of company Google Inc */
        ],
    ];

    const CLIENT_OPTIONS = [
        'environment' => 'webtest',
    ];

    const WEB_ROUTES = [
        'marketplace' => [
            'index' => '/',
            'login' => '/login',
            'register' => '/signup',
            'logout' => '/logout',
            'shop' => [
                'index' => '/shop/Developer',
            ],
            'admin' => [
                'dashboard' => '/admin',
                ],
            'buyer' => [
                'dashboard' => '/clients',
              ],
          ],
    ];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var Generator
     */
    protected $fakerGenerator;

    /**
     * @var int
     */
    protected $fakerSeed;

    /**
     * @var string
     */
    protected $connectedUser;

    public static function getClient($private = false, $banned = false)
    {
        return static::createClient(
            self::CLIENT_OPTIONS,
            [
                'HTTP_HOST' => $private ? self::URL_PRIVATE : self::URL_MARKETPLACE,
                'REMOTE_ADDR' => $banned ? self::IP_BANNED : self::IP_DEFAULT,
            ]
        );
    }

    /**
     * Initialize the globale with a random element of self::LOCALES.
     */
    protected function initializeLocale()
    {
        if (!isset($this->locale)) {
            $this->locale = self::LOCALES[mt_rand(0, count(self::LOCALES) - 1)];
        }
    }

    /**
     * Initialize the client with given host and ip.
     *
     * @param string|null $host
     * @param string|null $ip
     * @param string|null $locale
     */
    protected function initializeClient(string $host = null, string $ip = null, string $locale = null)
    {
        $this->client = static::createClient(
            self::CLIENT_OPTIONS,
            [
                'HTTP_HOST' => (null !== $host ? $host : self::URL_MARKETPLACE),
                'REMOTE_ADDR' => (null !== $ip ? $ip : self::IP_DEFAULT),
            ]
        );

        if (null === $locale) {
            $this->initializeLocale();
        } else {
            $this->locale = $locale;
        }
    }

    /**
     * Initialize the faker generator.
     */
    protected function initializeFaker()
    {
        $this->fakerGenerator = Factory::create('fr_FR');

        if (false === getenv('FAKER_SEED')) {
            $this->fakerSeed = rand(1, 9999);
        } else {
            $this->fakerSeed = intval(getenv('FAKER_SEED'));
        }

        $this->fakerGenerator->seed($this->fakerSeed);
    }

    /**
     * Get dump of all the 'random' variables
     * This could help reproduce a complex bug.
     *
     * @return array
     */
    protected function getTestEnvironmentVariablesDump()
    {
        $dump = [];
        $dump['global'] = [];

        if (isset($this->locale)) {
            $dump['global']['locale'] = $this->locale;
        }
        if (isset($this->fakerGenerator)) {
            $dump['global']['fakerSeed'] = $this->fakerSeed;
        }

        if (isset($this->connectedUser)) {
            $dump['connectedUser'] = ['identifier' => $this->connectedUser];

            foreach (self::ACCOUNTS[$this->connectedUser] as $key => $value) {
                $dump['connectedUser']['key'] = $value;
            }
        }

        return $dump;
    }

    /**
     * Pretty error message with variable dump to help reproduce the problem.
     *
     * @param string $message
     * @param array  $variables
     *
     * @return string
     */
    protected function getDumpedErrorMessage(string $message, array $variables = [])
    {
        $dump = array_merge(
            $this->getTestEnvironmentVariablesDump(),
            $variables
        );
        ksort($dump);

        return $message."\n".json_encode($dump, JSON_PRETTY_PRINT);
    }

    /**
     * Fake data generation.
     */

    /**
     * @param int|null $minLen
     * @param int|null $maxLen
     *
     * @return string
     */
    protected function getCompanyName(int $minLen = null, int $maxLen = null)
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        if (null !== $minLen || null !== $maxLen) {
            $minLen = null !== $minLen ? $minLen : (null !== $maxLen ? $maxLen + 1 : 1);
            $maxLen = null !== $maxLen ? $maxLen : $minLen + 1;

            return $this->fakerGenerator->regexify('[A-Z][a-z]{'.($minLen - 1).','.($maxLen - 1).'}');
        }

        return $this->fakerGenerator->company;
    }

    /**
     * @return string
     */
    protected function getEmail()
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->userName.'@'.self::DOMAIN_DEFAULT;
    }

    /**
     * @param int|null $minLen
     * @param int|null $maxLen
     *
     * @return string
     */
    protected function getPassword(int $minLen = null, int $maxLen = null)
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        if (null !== $minLen || null !== $maxLen) {
            $minLen = null !== $minLen ? $minLen : (null !== $maxLen ? $maxLen + 1 : 1);
            $maxLen = null !== $maxLen ? $maxLen : $minLen + 1;

            return $this->fakerGenerator->regexify('[A-Za-z0-9]{'.($minLen).','.($maxLen).'}');
        }

        return $this->fakerGenerator->password;
    }

    /**
     * @param int $size
     *
     * @return string
     */
    protected function getSiret(int $size = 14)
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->regexify('[0-9]{'.$size.'}');
    }

    /**
     * @return int
     */
    protected function getCountryId()
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->numberBetween(0, 255);
    }

    /**
     * @return string
     */
    protected function getUsername()
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->userName;
    }

    /**
     * @return string
     */
    protected function getPhone()
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->phoneNumber;
    }

    /**
     * @param int $size
     *
     * @return string
     */
    protected function getRandomName(int $size = 24)
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->regexify('[A-Za-z]{'.$size.'}');
    }

    /**
     * @return string
     */
    protected function getSmallText()
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->paragraph(3);
    }

    /**
     * @param int $size
     *
     * @return string
     */
    protected function getProductReference(int $size = 8)
    {
        if (!isset($this->fakerGenerator)) {
            $this->initializeFaker();
        }

        return $this->fakerGenerator->regexify('[0-9A-Z]{'.$size.'}');
    }
}
