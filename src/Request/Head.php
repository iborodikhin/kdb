<?php
namespace Kdb\Request;

use Kdb\Request;
use \React\Http\Response as ReactResponse;

/**
 * Request of HEAD type.
 */
class Head extends Request
{
    /**
     * {@inheritdoc}
     *
     * @param  \React\Http\Response $response
     * @throws \Exception
     */
    public function handle(ReactResponse $response)
    {
        $requestUri = $this->request->getPath();

        if ($this->glue->exists($requestUri)) {
            $response->writeHead(200);
        } else {
            $response->writeHead(404);
        }

        $response->end();
    }
}