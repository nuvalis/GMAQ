<?php

namespace nuvalis\Auth;
 
class Auth {

	use \Anax\DI\TInjectable;
	
	public function __construct() 
	{

	}

	public function getPermission()
	{

	}

	public function isLoggedIn() 
	{

		if(isset($_SESSION["auth"]["username"]) 
		&& isset($_SESSION["auth"]["userid"])) 
		{
			return true;
		} else {
			$this->redirect("users/login");
		}

	}

	public function username() 
	{

		if(!isset($_SESSION["auth"]["username"])) {
			return false;
		} else {
			return $_SESSION["auth"]["username"];
		}

	}

	public function userId() 
	{

		if(!isset($_SESSION["auth"]["userid"])) {
			return false;
		} else {
			return $_SESSION["auth"]["userid"];
		}

	}
	
}