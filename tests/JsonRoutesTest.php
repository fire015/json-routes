<?php namespace Fire015\JsonRoutes;

class JsonRoutesTest extends \Orchestra\Testbench\TestCase {

	/**
	 * Get package providers
	 *
	 * @return array
	 */
	protected function getPackageProviders() {
		return array(
			'Fire015\JsonRoutes\JsonRoutesServiceProvider'
		);
	}

	public function setUp() {
		parent::setUp();
	}

	protected function getEnvironmentSetUp($app) {

	}

	public function testRouter() {
		$this->app['config']->set('json-routes::path', __DIR__ . '/routes');

		$crawler = $this->call('GET', '/');
		$this->assertResponseOk();
	}
}