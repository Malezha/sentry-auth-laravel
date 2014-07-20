<?php

require_once 'BaseTest.php';

use Carbon\Carbon;

class SentryTest extends BaseTest {

	public function setUp() 
	{
		parent::setUp();

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

	public function testSentry()
	{
		$credentials = $this->getData()['user'];

		$user = \Sentry::authenticate($credentials, false);
		$this->assertInstanceOf('Cartalyst\Sentry\Users\Eloquent\User', $user);
	}

}