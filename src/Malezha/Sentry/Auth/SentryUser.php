<?php namespace Malezha\Sentry\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cartalyst\Sentry\Users\Eloquent\User;

class SentryUser extends User implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

}
