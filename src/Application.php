<?php
namespace Kdb;

use Kdb\Request;
use \React\EventLoop\Factory;
use \React\Socket\Server;
use \React\Http;

/**
 * Application base class.
 */
class Application
{
    /**
     * Configuration options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Logger object.
     *
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Runs application.
     *
     * @throws \React\Socket\ConnectionException
     */
    public function run()
    {
        $loop   = Factory::create();
        $socket = new Server($loop);
        $http   = new Http\Server($socket);

        $http->on('request', function (Http\Request $request, Http\Response $response) {
            Request::factory($request, $this)->handle($response);
            $this->logRequest($request);
        });
        $socket->listen($this->getOption('port', 1337));
        $loop->run();
    }

    /**
     * Returns configuration option by key.
     *
     * @param  string     $key
     * @param  mixed      $default
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    /**
     * Initializes and returns logger.
     *
     * @return \Monolog\Logger
     */
    public function getLogger()
    {
        if (null === $this->logger) {
            $this->logger = new \Monolog\Logger('kdb');
            $this->logger->pushHandler(new \Monolog\Handler\RotatingFileHandler(
                implode(DIRECTORY_SEPARATOR, [ROOT_DIR, $this->getOption('logDir', 'var/log'), 'kdb.log']),
                $this->getOption('logRotate', 7)
            ));
        }

        return $this->logger;
    }

    /**
     * Logs request.
     *
     * @param \React\Http\Request $request
     */
    protected function logRequest(Http\Request $request)
    {
        $this->getLogger()->addInfo(sprintf(
            "%s\tHTTP/%s\t%s\t%s%s",
            $request->remoteAddress,
            $request->getHttpVersion(),
            $request->getMethod(),
            $request->getPath(),
            count($request->getQuery()) > 0 ? '?' . http_build_query($request->getQuery()) : ''
        ));
    }
}