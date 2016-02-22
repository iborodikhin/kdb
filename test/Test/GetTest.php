<?php
namespace Kdb\Test;

use Kdb\Test;

class GetTest extends Test
{
    /**
     * @covers \Kdb\Request\Get::handle
     */
    public function testGet()
    {
        $result = $this->client->get($this->testData['url'], ['exceptions' => false]);

        $this->assertEquals(
            200,
            $result->getStatusCode()
        );
        $this->assertEquals($this->testData['size'], $result->getBody()->getSize());
        $this->assertEquals(file_get_contents(__DIR__ . '/../Test.php'), $result->getBody()->getContents());

        $this->assertEquals(
            404,
            $this->client->get($this->testData['url'] . $this->faker->uuid, ['exceptions' => false])->getStatusCode()
        );
    }
}