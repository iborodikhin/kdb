<?php
namespace Kdb;

use \React\Http\Request as ReactRequest;
use \React\Http\Response as ReactResponse;

/**
 * Request base class.
 */
abstract class Request
{
    /**
     * React request object.
     *
     * @var \React\Http\Request
     */
    protected $request;

    /**
     * Application object.
     *
     * @var \Kdb\Application
     */
    protected $app;

    /**
     * Glue storage object.
     *
     * @var \Glue\Glue
     */
    protected $glue;

    /**
     * Returns instance of Kdb\Request.
     *
     * @param  \React\Http\Request $request
     * @param  \Kdb\Application    $app
     * @return \Kdb\Request
     */
    public static function factory(ReactRequest $request, Application $app)
    {
        $className = sprintf('\\Kdb\\Request\\%s', ucfirst(strtolower($request->getMethod())));

        if (!class_exists($className)) {
            $className = '\\Kdb\\Request\\Unknown';
        }

        return new $className($request, $app);
    }

    /**
     * Constructor.
     *
     * @param \React\Http\Request $request
     * @param \Kdb\Application    $app
     */
    public function __construct(ReactRequest $request, Application $app)
    {
        $this->request = $request;
        $this->app     = $app;
        $this->glue    = new \Glue\Glue(
            implode(DIRECTORY_SEPARATOR, [ROOT_DIR, $this->app->getOption('dataDir', 'var/lib/data')]),
            $this->app->getOption('dataLevels', 1)
        );
    }

    /**
     * @param  \React\Http\Response $response
     * @return mixed
     */
    public abstract function handle(ReactResponse $response);
}