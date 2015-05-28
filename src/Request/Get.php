<?php
namespace Kdb\Request;

use Kdb\Request;
use \React\Http\Response as ReactResponse;

/**
 * Request of GET type.
 */
class Get extends Request
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
        $data       = $this->glue->read($requestUri);

        if (false === $data) {
            $response->writeHead(404);
            $response->end();
        } else {
            $headers = [];

            if (isset($data['meta']) && isset($data['meta']['mime-type'])) {
                $headers['Content-Type'] = $data['meta']['mime-type'];
            }

            if (isset($data['data'])) {
                $headers['Content-Length'] = strlen($data['data']);

                $response->writeHead(200, $headers);
                $response->end($data['data']);
            } else {
                $response->writeHead(404);
                $response->end();
            }
        }
    }
}