<?php

namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class UserTest extends \PHPUnit_Framework_TestCase
{

	public function SetUp()
	{

		$di = new \Anax\DI\CDIFactoryDefault();

		$di->setShared('db', function() {
		    $db = new \Mos\Database\CDatabaseBasic();
		    $db->setOptions(require ANAX_APP_PATH . 'config/config_sqlite.php');
		    $db->connect();
		    return $db;
		});

		$di->setShared('form', function() {
		    $form = new Mos\HTMLForm\CForm();
		    return $form;
		});

		$di->setShared('flashy', function() {
		    $flash = new nuvalis\Flash\Message();
		    return $flash;
		});

		$di->set('PostsController', function() use ($di) {
		    $controller = new \Anax\Posts\PostsController();
		    $controller->setDI($di);
		    return $controller;
		});

		$di->set('UsersController', function() use ($di) {
	    	$controller = new \Anax\Users\UsersController();
	    	$controller->setDI($di);
	    	return $controller;
		});

		$app = new \Anax\Kernel\CAnax($di);

	}

	public function testfindById()
	{
		$this->user = new User();

		var_dump($this->user->findById("1"));
	}
 
}