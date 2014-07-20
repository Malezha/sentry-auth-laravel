<?php namespace Malezha\Sentry\Hashing;

use Illuminate\Support\ServiceProvider;

class SentryHashServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['sentry-hash'] = $this->app->share(function($app)
		{
			return new SentryHasher($app['sentry.hasher']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sentry-hash');
	}

}