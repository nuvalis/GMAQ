<?php

namespace Anax\Questions;
 
/**
 * A controller for posts and admin related events.
 *
 */
class QuestionsController extends \Anax\Posts\PostsController
{

	public function idAction($id = null)
	{
	 
	    $post = $this->posts->findById($id);
	    $answers = $this->posts->findAnswers($id);
	 
	    $this->theme->setTitle("Question");
	    $this->views->add('posts/view_question', [
	        'post' => $post,
	        'answers' => $answers,
	    ]);
	}

	public function indexAction()
	{

		$all = $this->posts->findByType("question");
	 
		$this->theme->setTitle("List all posts");
	    $this->views->add('posts/list_questions', [
	        'posts' => $all,
	        'title' => "View all posts",
	    ]);

	}

	public function listAction()
	{
	 
	    $all = $this->posts->findByType("question");
	 
	    $this->theme->setTitle("List all questions");
	    $this->views->add('posts/list_questions', [
	        'posts' => $all,
	        'title' => "View all post",
	    ]);

	}

	public function newAction()
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
				'type'        => 'textarea',
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
				        'type'		=> "question",
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
		 
		    $url = $this->url->create('questions');
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