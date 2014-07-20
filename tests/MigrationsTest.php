<?php

require_once 'BaseTest.php';

class MigrationsTest extends BaseTest {

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

	public function testMigrate()
	{
		$result = $this->artisan->call('migrate', [
			'--database' => 'testbench',
			'--path' => '../src/migrations',
		]);
		$this->assertTrue(0 == $result);

		$result = $this->artisan->call('migrate:rollback');
		$this->assertTrue(0 == $result);
	}

}