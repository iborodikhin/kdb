<?php
namespace Kdb\Request;

use Kdb\Request;
use \React\Http\Response as ReactResponse;

/**
 * Request of POST type.
 */
class Post extends Request
{
    /**
     * {@inheritdoc}
     *
     * @param  \React\Http\Response $response
     * @throws \Exception
     */
    public function handle(ReactResponse $response)
    {
        $requestHeaders = $this->request->getHeaders();
        $contentLength  = (int) $requestHeaders['Content-Length'];
        $requestUri     = $this->request->getPath();
        $requestData    = '';

        if (array_key_exists('Expect', $requestHeaders)) {
            $response->writeContinue();
        }

        $this->request->on('data', function ($data) use (&$response, &$requestData, $contentLength, $requestUri) {
            $requestData .= $data;

            if ($contentLength === strlen($requestData)) {
                if (false !== $this->glue->save($requestUri, $requestData)) {
                    $response->writeHead(200);
                    $response->end();
                } else {
                    $response->writeHead(500);
                    $response->end();
                }
            }
        });
    }
}