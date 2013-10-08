Sentry Auth Driver for Laravel
==============================

Allows you to use built-in Laravel Auth routines with Cartalyst Sentry.

Laravel's built-in Auth routines allow you to configure an authentication driver for your application, which includes functionality such
as sending out password reset emails.

While Cartalyst's Sentry provides the same functionality, it does so in a different and non-compatible manner, so you need to rewrite all
Auth routines to use Sentry's API - you can't just change the Auth driver in Laravel.

This package allows you to do exactly that - install Sentry, install this driver and you can then configure the built-in Auth driver to use
"sentry" for authentication. You'll still need to extend the functionality to implement Sentry's advanced features such as groups, permissions,
 login throttling and such - but at least you don't need to completely rewrite your default Auth provider.

 Ideally, Cartalyst would provide this wrapper functionality as part of their own Sentry package, but until then, hopefully this package will
 be useful to some people.

By [Simon Hampel](http://hampelgroup.com/).

Installation
------------

The recommended way of installing is through [Composer](http://getcomposer.org):

Require the package via Composer in your `composer.json`

	:::json
    {
        "require": {
        	"cartalyst/sentry": "2.0.*",
            "hampel/sentry-auth-laravel": "1.0.*"
        }
    }

Run Composer to update the new requirement.

	:::bash
    $ composer update

Open your Laravel config file `app/config/app.php` and add the two service providers to the providers array:

	:::php
    'providers' => array(

        ...

		'Cartalyst\Sentry\SentryServiceProvider',
		'Hampel\Sentry\Auth\SentryAuthServiceProvider',
		'Hampel\Sentry\Hashing\SentryHashServiceProvider',

    ),

The SentryAuthServiceProvider is where the Auth service is extended with a new "sentry" user provider.

The SentryHashServiceProvider provides a new service "sentry-hash" which provides a simple wrapper for the Sentry hashing routines.

The package also supplies an Eloquent-based User model called SentryUser, which extends the default Eloquent user model provided by Sentry and
 implements several required interfaces which are missing from the default Sentry model.

Make sure you've added the Sentry class alias to `app/config/app.php`:

	:::php
	'aliases' => array(

		...

		'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
	),

If you haven't already done so, publish your Sentry config files:

	:::bash
	$ php artisan config:publish cartalyst/sentry

... you should find the config files in `app/config/packages/cartalyst/sentry`

Open your Laravel config file `app/config/auth.php` and set the driver to `sentry`:

	:::php
	'driver' => 'sentry',

Also in the file `app/config/auth.php`, set the model to `Hampel\Sentry\Auth\SentryUser`:

	:::php
	'model' => 'Hampel\Sentry\Auth\SentryUser',

In your Sentry config file `app/config/packages/cartalyst/sentry/config.php`, leave the driver as `eloquent`:

	:::php
	'driver' => 'eloquent',

It doesn't matter which hasher you choose to use fro Sentry, our driver will simply use the same hasher in place of the built in hasher from
Laravel.

Still in the Sentry config file, change the users model to `Hampel\Sentry\Auth\SentryUser`:

	:::php
	'users' => array(
		'model' => 'Hampel\Sentry\Auth\SentryUser',
	),

Important - if you choose to extend the user model with your own additional functionality, or to change default connection names or table names,
ensure you extend `Hampel\Sentry\Auth\SentryUser` rather than `Cartalyst\Sentry\Users\Eloquent\User`. Our SentryUser model extends Sentry's
 User model, but also implements some of the additional interfaces required by the Laravel Auth libraries.

 If you have extended our SentryUser model, you should specify the name of your own model in both the Laravel `auth.php` config file and in the
 Sentry `config.php` file.

For example, create a new model in `app/models/MyUser.php`:

	:::php
	use Hampel\Sentry\Auth\SentryUser;

	class MyUser extends SentryUser
	{

		// add custom functions, change default database connection, etc

	}

You would then change `app/config/auth.php`, set the model to `MyUser`:

	:::php
	'model' => 'MyUser',

Also change `app/config/packages/cartalyst/sentry/config.php` to also set the user model to `MyUser`:

	:::php
	'users' => array(
		'model' => 'MyUser',
	),

Usage
-----

Implement user authentication for your Laravel application as normal, following the instructions in [http://laravel.com/docs/security](http://laravel.com/docs/security).

Either use the `Hampel\Sentry\Auth\SentryUser` model provided to replace the user model provided by Sentry, or implement your own model
extending the model we have supplied.

Given that the field used as the username in Sentry can be configured, when sending user data to `Auth::attempt`, you should use the
configured value rather than hard-coding the value in your code. There are two ways of retrieving this value:

	:::php
	$loginfield = \Hampel\Sentry\Auth\SentryUser::getLoginAttributeName();

Or you can just check the config value directly (just make sure you're not changing the login attribute name yourself dynamically at runtime!):

	:::php
	$loginfield = Config::get('cartalyst/sentry::users.login_attribute');


You can then use this in your controller (or elsewhere) for validation and authentication:

	:::php
	$loginfield = \Hampel\Sentry\Auth\SentryUser::getLoginAttributeName();
	$passwordfield = 'password';

	$credentials = array(
		$loginfield => Input::get('email'),
		$passwordfield => Input::get('password')
	);

	if (Auth::attempt($credentials))
	{
		// successfully logged in
	}
	else
	{
		// authentication failed
	}

Todo
----

* Could do with some unit tests