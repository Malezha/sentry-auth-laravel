<?php namespace Malezha\Sentry\Auth;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User;

class SentryUser extends User implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'users';
	
	/**
	* The attributes excluded from the model's JSON form.
	*
	* @var array
	*/
	protected $hidden = array('password', 'remember_token');

}