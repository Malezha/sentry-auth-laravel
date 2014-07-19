<?php

use Orchestra\Testbench\TestCase;
use Malezha\Sentry\Auth\SentryUser;
use Malezha\Sentry\Hashing\SentryHasher;

class AuthTest extends TestCase {

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
			'--path' => 'migrations',
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

        $app['config']->set('auth.model', 'Malezha\Sentry\Auth\SentryUser');
    }
	
	protected function getPackageProviders()
    {
        return array(
			'Cartalyst\Sentry\SentryServiceProvider',
			'Malezha\Sentry\Auth\SentryAuthServiceProvider',
			'Malezha\Sentry\Hashing\SentryHashServiceProvider',
        );
    }
	
	protected function getPackageAliases()
	{
		return array(
			'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
			'SentryUser' => 'Malezha\Sentry\Auth\SentryUser'
		);
	}
	
	public function testAttempt()
	{
        $user = array(
            'email'     => 'test@example.com',
            'password'  => 'password',
        );

		\Sentry::createUser($user);
		
		$this->assertTrue(\Auth::attempt($user));

        $this->setExpectedException('\Cartalyst\Sentry\Users\UserNotActivatedException');
        Sentry::authenticate($user, false);
	}

}
