<?php
namespace Kdb\Test;

use Kdb\Test;

class PostTest extends Test
{
    /**
     * @covers \Kdb\Request\Post::handle
     */
    public function testPost()
    {
        $this->assertEquals(
            200,
            $this->client->post(
                $this->testData['url'] . $this->faker->uuid,
                ['exceptions' => false, 'body' => fopen(__FILE__, 'r')]
            )->getStatusCode()
        );
    }
}