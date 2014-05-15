<?php

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

	$di->setShared('auth', function() {
	    $auth = new nuvalis\Auth\Auth();
	    return $auth;
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

	$di->set('VotesController', function() use ($di) {
	    $controller = new \Anax\Votes\VotesController();
	    $controller->setDI($di);
	    return $controller;
	});

	$di->set('UsersController', function() use ($di) {
    	$controller = new \Anax\Users\UsersController();
    	$controller->setDI($di);
    	return $controller;
	});

	$app = new \Anax\Kernel\CAnax($di);

	$app->theme->configure(ANAX_APP_PATH . 'config/theme.php');
	$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
	$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
	$app->session; // Start Session