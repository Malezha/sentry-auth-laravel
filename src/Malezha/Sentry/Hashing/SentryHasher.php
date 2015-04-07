<?php namespace Malezha\Sentry\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Cartalyst\Sentry\Hashing\HasherInterface as SentryHasherInterface;

class SentryHasher implements HasherContract {

	protected $hasher;

	public function __construct(SentryHasherInterface $hasher)
	{
		$this->hasher = $hasher;
	}

	/**
	 * Hash the given value.
	 *
	 * @param  string  $value
	 * @param  array   $options
	 * @return string
	 */
	public function make($value, array $options = array())
	{
		return $this->hasher->hash($value);
	}

	/**
	 * Check the given plain value against a hash.
	 *
	 * @param  string  $value
	 * @param  string  $hashedValue
	 * @param  array   $options
	 * @return bool
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		return $this->hasher->checkhash($value, $hashedValue);
	}

	/**
	 * Check if the given hash has been hashed using the given options.
	 *
	 * @param  string  $hashedValue
	 * @param  array   $options
	 * @return bool
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}

}
