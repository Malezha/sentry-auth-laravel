<?php

require_once 'BaseTest.php';

class SentryTest extends BaseTest {

	public function setUp() 
	{
		parent::setUp();
	}

	public function testSentryPackage()
	{
		$credentials = $this->getData()['user'];

		\Sentry::register($credentials, true);

		$user = \Sentry::authenticate($credentials, false);
		$this->assertInstanceOf('Cartalyst\Sentry\Users\Eloquent\User', $user);
	}

}