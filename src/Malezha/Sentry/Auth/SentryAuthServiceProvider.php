<?php namespace Malezha\Sentry\Auth;

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
		$this->app['auth']->extend('sentry', function($app)
		{
			$provider = new EloquentUserProvider($app['sentry-hash'], $app['config']->get('auth.model'));

			return new Guard($provider, $app['session.store']);
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


}
