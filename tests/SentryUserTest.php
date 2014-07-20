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
		$this->assertTrue(\Auth::attempt($this->getData()['user']));
        $this->assertInstanceOf('Malezha\Sentry\Auth\SentryUser', \Auth::user());;
	}

}