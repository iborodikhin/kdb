<?php
namespace Kdb\Test;

use Kdb\Test;

class HeadTest extends Test
{
    /**
     * @covers \Kdb\Request\Head::handle
     */
    public function testHead()
    {
        $this->assertEquals(
            200,
            $this->client->head($this->testData['url'], ['exceptions' => false])->getStatusCode()
        );

        $this->assertEquals(
            404,
            $this->client->head($this->testData['url'] . $this->faker->uuid, ['exceptions' => false])->getStatusCode()
        );
    }
}