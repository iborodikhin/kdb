<?php
namespace Kdb\Request;

use Kdb\Request;
use \React\Http\Response as ReactResponse;

/**
 * Request of DELETE type.
 */
class Delete extends Request
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

        if ($this->glue->delete($requestUri)) {
            $response->writeHead(200);
        } else {
            $response->writeHead(404);
        }

        $response->end();
    }
}