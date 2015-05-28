<?php
namespace Kdb;

use Faker\Factory as FakerFactory;
use Faker\Provider;

/**
 * Test base class.
 */
abstract class Test extends \PHPUnit_Framework_TestCase
{
    /**
     * HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var array
     */
    protected $testData = [];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = new \GuzzleHttp\Client();

        $this->faker = FakerFactory::create();
        $this->faker->addProvider(new Provider\Internet($this->faker));
        $this->faker->addProvider(new Provider\DateTime($this->faker));

        $this->testData = [
            'url'  => sprintf('http://localhost:1337/%s', $this->faker->uuid),
            'size' => filesize(__FILE__),
        ];

        $this->client->post($this->testData['url'], ['exceptions' => false, 'body' => fopen(__FILE__, 'r')]);
    }
}