<?php namespace Fire015\JsonRoutes;

use Illuminate\Support\ServiceProvider;

class JsonRoutesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events
	 *
	 * @return void
	 */
	public function boot() {
		$this->package('fire015/json-routes', null, __DIR__);
		$this->addFilter();
	}

	/**
	 * Add a before filter to the Laravel router
	 *
	 * @return void
	 */
	private function addFilter() {
		$app = $this->app;

		$app->before(function($request) use ($app) {
			$app['json-routes.router']->register($request);
		});
	}

	/**
	 * Register the service provider
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind('json-routes.router', function($app) {
			return new Router($app['router'], $app['config']['json-routes::config']);
		});
	}
}