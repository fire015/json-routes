<?php namespace Fire015\JsonRoutes;

use Illuminate\Http\Request;
use Illuminate\Routing\Router as IlluminateRouter;

class Router {

	/**
	 * Illuminate request object
	 *
	 * @var Request
	 */
	protected $request;

	/**
	 * Illuminate router object
	 *
	 * @var IlluminateRouter
	 */
	protected $router;

	/**
	 * Package config
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * All of the verbs supported by the router
	 *
	 * @var array
	 */
	protected $verbs;

	/**
	 * Constructor
	 *
	 * @param IlluminateRouter $router
	 * @param array $config
	 */
	public function __construct(IlluminateRouter $router, array $config) {
		$this->router = $router;
		$this->config = $config;
		$routerName = get_class($router);
		$this->verbs = $routerName::$verbs;
	}

	/**
	 * Register route matches
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function register(Request $request) {
		if (!is_dir($this->config['path'])) {
			return;
		}

		$path = rtrim($this->config['path'], '/\\');

		if (is_file($path . '/routes.json')) {
			$this->loadFile($path . '/routes.json');
		}

		$segments = $request->segments();

		foreach ($segments as $segment) {
			if (is_file($path . '/' . $segment . '.json')) {
				$this->loadFile($path . '/' . $segment . '.json');
			}

			if (is_file($path . '/' . $segment . '/routes.json')) {
				$this->loadFile($path . '/' . $segment . '/routes.json');
			}

			$path .= '/' . $segment;
		}
	}

	/**
	 * Load a JSON file and register the routes
	 *
	 * @param string $file
	 *
	 * @return void
	 */
	protected function loadFile($file) {
		$data = file_get_contents($file);

		if ($data !== false) {
			$data = json_decode($data, true);

			if (is_array($data)) {
				$this->registerRoutes($data);
			}
			elseif (json_last_error() !== JSON_ERROR_NONE) {
				throw new \InvalidArgumentException('Unable to parse JSON data in ' . $file);
			}
		}
	}

	/**
	 * Register routes from an array
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	protected function registerRoutes(array $data) {
		foreach ($data as $method => $routes) {
			if (in_array($method, $this->verbs)) {
				foreach ($routes as $uri => $action) {
					$this->router->match(array($method), $uri, $action);
				}
			}
		}
	}
}