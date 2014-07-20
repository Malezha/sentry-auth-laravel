<?php

require_once 'BaseTest.php';

use Carbon\Carbon;

class SentryTest extends BaseTest {

	public function setUp() 
	{
		parent::setUp();
		
		$this->populateDatabase();

	}

	public function testSentry()
	{
		$credentials = $this->getData()['user'];

		$user = \Sentry::authenticate($credentials, false);
		$this->assertInstanceOf('Cartalyst\Sentry\Users\Eloquent\User', $user);
	}

}