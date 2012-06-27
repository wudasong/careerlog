<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_DISABLED_USER=3;
	
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::getUser($this->username);
		
		if(!isset($user))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($user->status == 0)
			$this->errorCode=self::ERROR_DISABLED_USER;
		else if($user->password !== md5($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->username = $user->username;
			// records last login datetime
			$user->last_login_date = date("Y-m-d H:i:s");
			$user->save();
			
			$this->_id = $user->id;
			$this->errorCode=self::ERROR_NONE;
		}
		
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}