<?php namespace Malezha\Sentry\Auth;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User;

class SentryUser extends User implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

}