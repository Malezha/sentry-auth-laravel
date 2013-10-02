<?php namespace Hampel\Sentry\Auth;

use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Guard;
use Illuminate\Auth\EloquentUserProvider;

class SentryAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('hampel/sentry-auth-laravel', 'sentry-auth-laravel', __DIR__ . '/../../..');

		$app = $this->app;

		\Auth::extend('sentry', function() use ($app)
		{
			$provider = new EloquentUserProvider($app['sentry-hash'], Config::get('auth.model'));

			return new Guard($provider, $app['session']);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}