<?php
namespace Kdb\Test;

use Kdb\Test;

class DeleteTest extends Test
{
    /**
     * @covers \Kdb\Request\Delete::handle
     */
    public function testDelete()
    {
        $this->assertEquals(
            200,
            $this->client->delete($this->testData['url'], ['exceptions' => false])->getStatusCode()
        );

        $this->assertEquals(
            404,
            $this->client->delete(
                $this->testData['url'] . $this->faker->uuid,
                ['exceptions' => false]
            )->getStatusCode()
        );
    }
}