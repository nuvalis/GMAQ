<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	    $this->theme->setTitle("User");
	}

	/**
	 * List user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	 
	    $user = $this->users->find($id);
	 
	    $this->theme->setTitle("View user with id");
	    $this->views->add('users/view', [
	        'user' => $user,
	    ]);
	}

    /**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAction()
	{
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	 
	    $all = $this->users->findAll();
	 
	    $this->theme->setTitle("List all users");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "View all users",
	    ]);
	}

	/**
	 * Add new user.
	 *
	 * 
	 *
	 * @return void
	 */
	public function addAction()
	{

		$form = $this->form;

		$form = $form->create([], [
			'acronym' => [
				'type'        => 'text',
				'label'       => 'Acronym',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'password' => [
				'type'        => 'password',
				'label'       => 'Password',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
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
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {

					$now = date(DATE_RFC2822);
			 
				    $this->users->save([
				        'acronym' 	=> $form->Value('acronym'),
				        'email' 	=> $form->Value('email'),
				        'name' 		=> $form->Value('name'),
				        'password' 	=> password_hash($form->Value('password'), PASSWORD_BCRYPT),
				        'created' 	=> $now,
				        'active' 	=> $now,
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create('users/id/' . $this->users->id);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("Add user");
		$this->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
		]);
	 

	}


	/**
	 * Edit user.
	 *
	 * @param int id of user.
	 *
	 * @return void
	 */
	public function updateAction($id)
	{

		$form = $this->form;

		$user = $this->users->find($id);

		$form = $form->create([], [
			'acronym' => [
				'type'        => 'text',
				'label'       => 'Acronym',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value' => $user->acronym,
			],
			'name' => [
				'type'        => 'text',
				'label'       => 'Name of contact person:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value' => $user->name,
			],
			'email' => [
				'type'        => 'text',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
				'value' => $user->email,
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) use ($user) {

					$now = date(DATE_RFC2822);

				    $this->users->save([
				    	'id'		=> $user->id,
				        'acronym' 	=> $form->Value('acronym'),
				        'email' 	=> $form->Value('email'),
				        'name' 		=> $form->Value('name'),
				        'updated' 	=> $now,
				        'active' 	=> $now,
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 	$this->flash->success("Changes has been saved!");
		    $url = $this->url->create('users/id/' . $user->id);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			$this->flash->error("Something went wrong in the saving process.");
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;
		}

		$this->theme->setTitle("Edit user");
		$this->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
		]);
	 

	}

	/**
	 * Change password for user.
	 *
	 * @param int id of user.
	 *
	 * @return void
	 */
	public function changePasswordAction($id)
	{

		$form = $this->form;

		$user = $this->users->find($id);

		$form = $form->create([], [

			'password' => [
				'type'        => 'password',
				'label'       => 'Password',
				'required'    => true,
				'validation'  => ['not_empty'],
				'placeholder' => 'New Password',
			],

			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) use ($user) {

					$now = date(DATE_RFC2822);

				    $this->users->save([
				    	'id'		=> $user->id,
				        'password' 	=> password_hash($form->Value('password'), PASSWORD_BCRYPT),
				        'updated' 	=> $now,
				        'active' 	=> $now,
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 	
		 	$this->flash->success("New password has been saved!");
		    $url = $this->url->create('users/id/' . $user->id);
		    $this->response->redirect($url);
		
		} else if ($status === false) {

			$this->flash->error("Something went wrong in the saving process.");
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;

		}

		$this->theme->setTitle("Change Password");
		$this->views->add('nuva/test', [
			'title' => "Try out a form using CForm",
			'form' => $form->getHTML()
		]);
	 

	}



	/**
	 * Delete user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $res = $this->users->delete($id);
	 
	    $url = $this->url->create('users/list');

	    $this->flash->success("Perma Deleted User");
	    $this->response->redirect($url);
	}

	/**
	 * Delete (soft) user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function softDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $now = date(DATE_RFC2822);
	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = $now;
	    $user->save();

	    $this->flash->success("Soft Deleted User");
	 
	    $url = $this->url->create('users/id/' . $id);
	    $this->response->redirect($url);
	}


	/**
	 * Undo Delete (soft) user.
	 *
	 * @param integer $id of user to undo delete.
	 *
	 * @return void
	 */
	public function undoSoftDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = null;
	    $user->save();

	 	$this->flash->success("Reanimated user is a Success");

	    $url = $this->url->create('users/id/' . $id);
	    $this->response->redirect($url);
	}

	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function activeAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NOT NULL')
	        ->andWhere('deleted is NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are active");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are active",
	    ]);
	}


	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function inactiveAction()
	{
	    $all = $this->users->query()
	        ->where('deleted IS NOT NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are inactive");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are inactive/Deleted",
	    ]);
	}

	public function loginAction($user, $pass) 
	{
		$_POST["username"] = $user;
		$_POST["password"] = $pass;

		$user = $this->users->findByUsername($_POST["username"]);

		$hash = $user->password;

		$check = password_verify($_POST["password"], $hash);

		if($check === true) {
			
			$_SESSION["auth"]["username"] = $user->username;
			$_SESSION["auth"]["userid"] = $user->id;
			$this->flashy->success("You are now logged in");
			$this->response->redirect("");

		} else {

			$this->flashy->error("Could not login");
			$this->response->redirect("");

		}

	}

	public function logoutAction() 
	{

		session_destroy();
		unset($_SESSION);

		$this->flashy->error("Logged Out");
		$this->response->redirect("");

		return true;
		
	}

	public function statusAction() 
	{
		if($this->auth->userId()){

			$this->flashy->success("Status: Logged In as " . $this->auth->username());
			$this->response->redirect("");


		} else {

			$this->flashy->warning("Status: Logged Out");
			$this->response->redirect("");

		}

	}
	 
}