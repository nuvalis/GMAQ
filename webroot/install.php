<?php

	require __DIR__.'/config_with_app.php';
	require __DIR__.'/custom.php'; // Custom Config

$app->router->add('install', function() use ($app) {
	 
		$app->db->setVerbose();

		$app->theme->setTitle("Setup");
	 
		$app->db->dropTableIfExists('user')->execute();
	 
		$app->db->createTable(
			'user',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'acronym' => ['varchar(20)', 'unique', 'not null'],
				'email' => ['varchar(80)', 'unique', 'not null'],
				'name' => ['varchar(80)'],
				'password' => ['varchar(255)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
				'active' => ['datetime'],
			]
		)->execute();

		$app->db->dropTableIfExists('posts')->execute();
		$app->db->dropTableIfExists('category')->execute();
		$app->db->dropTableIfExists('votes')->execute();
		$app->db->dropTableIfExists('tags')->execute();
		$app->db->dropTableIfExists('posts_cat_ref')->execute();
		$app->db->dropTableIfExists('posts_tag_ref')->execute();
		$app->db->dropTableIfExists('comments')->execute();
		$app->db->dropTableIfExists('tags')->execute();
		$app->db->dropTableIfExists('tags')->execute();
	 
		$app->db->createTable(
			'posts',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'cat_id' => ['integer', 'not null'],
				'user_id' => ['integer', 'not null'],
				'title' => ['varchar(128)'],
				'content' => ['text'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'category',
			[
				'cat_id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'name' => ['varchar(64)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'votes',
			[
				'votes_id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'posts_id' => ['integer', 'not null'],
				'user_id' => ['integer', 'not null'],
				'vote' => ['integer', 'not null'],
			]
		)->execute();

		$app->db->createTable(
			'tags',
			[
				'tag_id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'tag_name' => ['varchar(128)'],
			]
		)->execute();

		$app->db->createTable(
			'posts_tag_ref',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'tag_id' => ['integer', 'not null'],
				'posts_id' => ['integer', 'not null'],
			]
		)->execute();

		$app->db->createTable(
			'posts_cat_ref',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'cat_id' => ['integer', 'not null'],
				'posts_id' => ['integer', 'not null'],
			]
		)->execute();


		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `posts`  
						ADD CONSTRAINT `fk_post_cat_id` 
    					FOREIGN KEY (`cat_id`) REFERENCES `posts_tag_ref` (`cat_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `posts`  
						ADD CONSTRAINT `fk_post_tag_id` 
    					FOREIGN KEY (`tag_id`) REFERENCES `posts_cat_ref` (`tag_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `posts_cat_ref`  
						ADD CONSTRAINT `fk_post_ref_cat_id` 
    					FOREIGN KEY (`tag_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `posts_tag_ref`  
						ADD CONSTRAINT `fk_post_ref_tag_id` 
    					FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `posts`  
						ADD CONSTRAINT `fk_post_votes_id` 
    					FOREIGN KEY (`votes_id`) REFERENCES `votes` (`votes_id`) ON DELETE CASCADE;");		


		$app->flashy->success("Setup is Done");

	    $url = $app->url->create('');
	    $app->response->redirect($url);
		
	});

	 
	$app->router->handle();
	$app->theme->render();