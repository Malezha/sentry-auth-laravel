<?php

require_once 'BaseTest.php';

class AuthTest extends BaseTest {

	public function setUp() 
	{
		parent::setUp();

		$this->populateDatabase();
	}

	public function testAttempt()
	{
		$user = $this->getData()['user'];

		$this->assertTrue(\Auth::attempt($user));
	}

	public function testLogout()
	{
		$user = $this->getData()['user'];

		\Auth::attempt($user);
		\Auth::logout();
	}

	public function testGetUser()
	{
		$user = $this->getData()['user'];

		$this->assertTrue(\Auth::attempt($user));
		$this->assertNotNull(\Auth::user());
	}

}
