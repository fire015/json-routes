<?php namespace Fire015\JsonRoutesTests;

use Fire015\JsonRoutes\Router;
use Illuminate\Http\Request;
use Illuminate\Routing\Router as IlluminateRouter;
use Illuminate\Events\Dispatcher;

class JsonRoutesTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test the router add's correct matches
	 *
	 * @return void
	 */
	public function testRouter() {
		$router = $this->getRouter();
		$router->get('foo/bar', function() { return 'hello'; });
		$this->assertEquals('hello', $router->dispatch(Request::create('foo/bar', 'GET'))->getContent());
		$this->assertEquals('testing', $router->dispatch(Request::create('/', 'GET'))->getContent());
		$this->assertEquals('testing', $router->dispatch(Request::create('abc/def', 'GET'))->getContent());
		$this->assertEquals('testing', $router->dispatch(Request::create('/', 'POST'))->getContent());
		$this->assertEquals('testing', $router->dispatch(Request::create('about', 'GET'))->getContent());
		$this->assertEquals('123', $router->dispatch(Request::create('user/123', 'GET'))->getContent());
		$this->assertEquals('456', $router->dispatch(Request::create('user/edit/456', 'GET'))->getContent());
	}

	/**
	 * Test invalid JSON
	 *
	 * @expectedException \InvalidArgumentException
	 *
	 * @return void
	 */
	public function testInvalid() {
		$router = $this->getRouter();
		$router->dispatch(Request::create('invalid', 'GET'));
	}

	/**
	 * Get the router
	 *
	 * @return IlluminateRouter
	 */
	protected function getRouter() {
		$router = new IlluminateRouter(new Dispatcher);
		$config = $this->getConfig();

		$router->before(function($request) use ($router, $config) {
			$customRouter = new Router($router, $config);
			$customRouter->register($request);
		});

		return $router;
	}

	/**
	 * Get the test config
	 *
	 * @return array
	 */
	protected function getConfig() {
		return array('path' => __DIR__ . '/routes');
	}
}