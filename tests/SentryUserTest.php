<?php

require_once 'BaseTest.php';

class SentryUserTest extends BaseTest {

	public function setUp() 
	{
		parent::setUp();

		$this->populateDatabase();
	}

	public function testSentryUser()
	{
        $this->assertInstanceOf('Malezha\Sentry\Auth\SentryUser', SentryUser::find(1));;
	}

}