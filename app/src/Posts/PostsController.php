<?php

namespace Anax\Posts;
 
/**
 * A controller for posts and admin related events.
 *
 */
class PostsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


	public function initialize()
	{
	    $this->posts = new \Anax\Posts\Posts();
	    $this->posts->setDI($this->di);
	    $this->theme->setTitle("Posts");
	}

	public function indexAction()
	{

		$all = $this->posts->findAll();
	 
		$this->theme->setTitle("List all posts");
	    $this->views->add('posts/list', [
	        'posts' => $all,
	        'title' => "View all posts",
	    ]);

	}

	public function idAction($id = null)
	{
	 
	    $post = $this->posts->findById($id);
	 
	    $this->theme->setTitle("View user with id");
	    $this->views->add('posts/view', [
	        'post' => $post,
	    ]);
	}

	public function listAction()
	{
	 
	    $all = $this->posts->findAll();
	 
	    $this->theme->setTitle("List all posts");
	    $this->views->add('posts/list', [
	        'posts' => $all,
	        'title' => "View all post",
	    ]);
	}

	public function voteUpAnswerAction($id)
	{
	    $this->posts->voteOnAnswer($id);
	 
	    $this->theme->setTitle("Voting");
	    $this->url->create("posts/id/$id");
	    $this->response->redirect($url);

	}

	public function newQuestionAction()
	{

 		$form = $this->form;

		$form = $form->create([], [
			'title' => [
				'type'        => 'text',
				'label'       => 'Title',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'content' => [
				'type'        => 'text',
				'label'       => 'Content',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {

					$now = date(DATE_RFC2822);
			 
				    $this->posts->save([
				        'title' 	=> $form->Value('title'),
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        'cat_id' 	=> $this->auth->userid(),
				        'created' 	=> $now,
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create('posts/id/' . $this->posts->id);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("New Question");
		$this->views->add('posts/new_question', [
			'title' => "New Question",
			'form' => $form->getHTML()
		]);
	}
	 
}