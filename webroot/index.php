<?php

	require __DIR__.'/config_with_app.php';
	require __DIR__.'/custom.php'; // Custom Config
	 
	$app->router->add('', function() use ($app) {
	 
		$app->theme->setTitle("Me");
	 
		$app->views->add('me/me', [
			'content' => "Shitty Content",
			'side' => "Shitty Content",
			'byline' => "Shitty Content",
		]);

	});

	$app->router->add('formtest', function() use ($app) {

		$form = $app->form;

		$form = $form->create([], [
			'name' => [
				'type'        => 'text',
				'label'       => 'Name of contact person:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'email' => [
				'type'        => 'text',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
			],
			'phone' => [
				'type'        => 'text',
				'required'    => true,
				'validation'  => ['not_empty', 'numeric'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {
					$form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
					$form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
					$form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
					$form->AddOutput("<p><b>Phone: " . $form->Value('phone') . "</b></p>");
					$form->saveInSession = true;
					return true;
				}
			],
			'submit-fail' => [
				'type'      => 'submit',
				'callback'  => function($form) {
					$form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
					return false;
				}
			],
		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {

			// What to do if the form was submitted?
			$form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}


		$app->theme->setTitle("A CForm Test Page");
		$app->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
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
	
		$now = date(DATE_RFC2822);
	
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

		$app->db->dropTableIfExists('comment')->execute();
	 
		$app->db->createTable(
			'comment',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'username' => ['varchar(30)', 'not null'],
				'email' => ['varchar(80)'],
				'name' => ['varchar(80)'],
				'web' => ['varchar(128)'],
				'content' => ['text'],
				'page' => ['varchar(80)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
				'active' => ['datetime'],
			]
		)->execute();

		$app->db->insert(
			'comment',
			['username', 'email', 'name', 'web', 'content', 'page', 'created', 'active']
		);
	
		$now = date(DATE_RFC2822);
	
		$app->db->execute([
			'admin',
			'admin@dbwebb.se',
			'Administrator',
			'test.com',
			'Text',
			'all',
			$now,
			$now
		]);
	
		$app->db->execute([
			'doe',
			'doe@dbwebb.se',
			'John/Jane Doe',
			'test.com',
			'Text',
			'all',
			$now,
			$now
		]);

		$app->db->execute([
			'doe',
			'doe@dbwebb.se',
			'John/Jane Doe',
			'test.com',
			'Text',
			'me',
			$now,
			$now
		]);

		$app->flashy->success("Setup is Done");


	    $url = $app->url->create('users/list');
	    $app->response->redirect($url);
		
	});

	 
	$app->router->handle();
	$app->theme->render();