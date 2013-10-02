<?php

class ServiceProviderTest extends Orchestra\Testbench\TestCase {

	protected function getPackageProviders()
	{
		return array(
			'Cartalyst\Sentry\SentryServiceProvider',
			'Hampel\Sentry\Hashing\SentryHashServiceProvider',
		);
	}

	public function testMakeServices()
	{
		$this->assertInstanceOf('Hampel\Sentry\Hashing\SentryHasher', App::make('sentry-hash'));
	}
}