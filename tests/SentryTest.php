<?php

use Orchestra\Testbench\TestCase;
use Carbon\Carbon;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class SentryTest extends TestCase {

	public function setUp() 
	{
		parent::setUp();

		$artisan = $this->app->make('artisan');

		$artisan->call('migrate', [
			'--database' => 'testbench',
			'--path' => '../vendor/cartalyst/sentry/src/migrations',
		]);

		$artisan->call('migrate', [
			'--database' => 'testbench',
			'--path' => '../src/migrations',
		]);

		$user = $this->getData()['user'];

		$now = Carbon::now();
		\DB::table('users')->insert(array(
			'email' => $user['email'],
			'password' => Hash::make($user['password']),
            'activated' => 1,
			'created_at' => $now,
			'updated_at' => $now,
		));
	}

	/**
	* Define environment setup.
	*
	* @param Illuminate\Foundation\Application $app
	* @return void
	*/
	protected function getEnvironmentSetUp($app)
	{
		// reset base path to point to our package's src directory
		$app['path.base'] = __DIR__ . '/../src';

		$app['config']->set('database.default', 'testbench');
		$app['config']->set('database.connections.testbench', array(
			'driver' => 'sqlite',
			'database' => ':memory:',
			'prefix' => '',
		));

		$app['config']->set('auth.model', '\Malezha\Sentry\Auth\SentryUser');

        $app['config']->set('auth.packages.cartalyst.sentry.config.users.model', '\Malezha\Sentry\Auth\SentryUser');
	}

	protected function getPackageProviders()
	{
		return array(
			'\Cartalyst\Sentry\SentryServiceProvider',
			'\Malezha\Sentry\Auth\SentryAuthServiceProvider',
			'\Malezha\Sentry\Hashing\SentryHashServiceProvider',
		);
	}

	protected function getPackageAliases()
	{
		return array(
			'Sentry' => '\Cartalyst\Sentry\Facades\Laravel\Sentry',
			'SentryUser' => '\Malezha\Sentry\Auth\SentryUser'
		);
	}

	public function testSentry()
	{
		$credentials = $this->getData()['user'];

		$user = Sentry::authenticate($credentials, false);
		$this->assertInstanceOf('Cartalyst\Sentry\Users\Eloquent\User', $user);
	}

	/**
	* Define input data.
	*
	* @return array
	*/
	protected function getData() 
	{
		return array(
			'user' => [
				'email' => 'example',
				'password' => 'pasword',
			],
		);
	}

}