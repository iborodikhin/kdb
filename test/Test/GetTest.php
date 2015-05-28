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
        $this->assertEquals(
            200,
            $this->client->get($this->testData['url'], ['exceptions' => false])->getStatusCode()
        );

        $this->assertEquals(
            404,
            $this->client->get($this->testData['url'] . $this->faker->uuid, ['exceptions' => false])->getStatusCode()
        );
    }
}