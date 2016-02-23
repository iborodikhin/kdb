<?php
namespace Kdb\Request;

use Kdb\Request;
use \React\Http\Response as ReactResponse;

/**
 * Request of unknown type.
 */
class Unknown extends Request
{
    /**
     * {@inheritdoc}
     *
     * @param  \React\Http\Response $response
     * @throws \Exception
     */
    public function handle(ReactResponse $response)
    {
        $response->writeHead(405);
        $response->end();
    }
}