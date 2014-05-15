<?php

namespace nuvalis\Auth;
 
class AuthTest extends \PHPUnit_Framework_TestCase {

	function SetUp() 
	{
		$this->auth = new Auth();
		
	}

	public function testPermission()
	{

	}

	public function testLogin() 
	{
		$_POST["username"] = "test";
		$_POST["password"] = "test";
		$this->assertEquals(true, $this->auth->login());


	}

	public function testLogout() 
	{

		$this->assertEquals(true, $this->auth->logout());
		$this->assertEquals(false, isset($_SESSION));

	}
	

}