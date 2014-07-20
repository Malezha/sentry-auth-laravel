<?php

use Orchestra\Testbench\TestCase;

class MigrationsTest extends TestCase {

	protected $artisan;

	public function setUp() 
	{
		parent::setUp();

		$artisan = $this->app->make('artisan');
		$this->artisan = $artisan;

		$artisan->call('migrate', [
			'--database' => 'testbench',
			'--path' => '../vendor/cartalyst/sentry/src/migrations',
		]);
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
	}

	public function testMigrate()
	{
		$result = $this->artisan->call('migrate', [
			'--database' => 'testbench',
			'--path' => '../src/migrations',
		]);

		$this->assertTrue(0 == $result);
	}

}