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

	$app->router->add('setup', function() use ($app) {
	 
		$app->db->setVerbose();

		$app->theme->setTitle("Setup");
	 
		$app->db->dropTableIfExists('user')->execute();
	 
		$app->db->createTable(
			'user',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'username' => ['varchar(30)', 'unique', 'not null'],
				'email' => ['varchar(80)'],
				'name' => ['varchar(80)'],
				'password' => ['varchar(255)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
				'active' => ['datetime'],
			]
		)->execute();

		$app->db->insert(
			'user',
			['username', 'email', 'name', 'password', 'created', 'active']
		);
	
		$now = $app->mzHelpers->now();
	
		$app->db->execute([
			'admin',
			'admin@test.se',
			'Administrator',
			password_hash('admin', PASSWORD_DEFAULT),
			$now,
			$now
		]);
	
		$app->db->execute([
			'doe',
			'doe@test.se',
			'John/Jane Doe',
			password_hash('doe', PASSWORD_DEFAULT),
			$now,
			$now
		]);

		$app->db->execute([
			'test',
			'test@test.se',
			'Test Testsson',
			password_hash('test', PASSWORD_DEFAULT),
			$now,
			$now
		]);

		$app->flashy->success("Setup is Done");
	    $app->redirectTo('users/list');
		
	});

	 
	$app->router->handle();
	$app->theme->render();