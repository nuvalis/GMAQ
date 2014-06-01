<?php

	require __DIR__.'/config_with_app.php';
	require __DIR__.'/custom.php'; // Custom Config
	 
	$app->router->add('', function() use ($app) {
	 
		$app->theme->setTitle("Index");

		$app->dispatcher->forward([
	        'controller' => 'questions',
	        'action'     => 'list',
	    ]);
	 
	});

	$app->router->add('about', function() use ($app) {
	 
		$app->theme->setTitle("About");

	    $content = $app->fileContent->get('about.md');
	    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

		$app->views->add('about/about',[
	        'content' => $content,
	    ]);
	 
	});
	 
	$app->router->handle();
	$app->theme->render();