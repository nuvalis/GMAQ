<?php

namespace nuvalis\Questions;
 
/**
 * A controller for posts and admin related events.
 *
 */
class QuestionsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->question = new \nuvalis\Questions\Questions();
	    $this->question->setDI($this->di);
	   	$this->votes = new \nuvalis\Votes\Votes();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("Questions");
	}

	public function indexAction()
	{

		$this->listAction();

	}

	public function testAction($id)
	{
		$this->question->findTags($id);
	}

	public function idAction($id)
	{
	 
	    $question = $this->question->findById($id);
	    $comments = $this->question->findComments($id);
	   	$tags = $this->question->findTags($id);
	   	$votes = $this->votes->calcVotes("questions", $id);
	 
	    $this->theme->setTitle("Question");
	    $this->views->add('question/view_question', [
	        'question' 	=> $question,
	        'comments' 	=> $comments,
	        'tags'		=> $tags,
	        'votes'		=> $votes
	    ]);

	   	$this->dispatcher->forward([
			'controller' => 'answers',
			'action'     => 'list-answers',
			'params'      => [$id],
		]);

		$this->question->countId($id);
	}

	public function listAction()
	{
	 
		$all = $this->question->findAll();

		foreach($all as $q) {

			$q->answersCount = $this->question->countAnswers($q->id);
			$q->tags 		 = $this->question->findTags($q->id);
			$q->votes 		 = $this->votes->calcVotes("questions", $q->id);

		}
	 
		$this->theme->setTitle("List all Questions");
	    $this->views->add('question/list_questions', [
	        'questions' => $all,
	        'title' => "View all Questions",
	    ]);

	}

	public function newAction()
	{

		$this->auth->isLoggedIn();

 		$form = $this->form;

		$form = $form->create([], [
			'title' => [
				'type'        => 'text',
				'label'       => 'Title',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'tags' => [
				'type'        => 'text',
				'label'       => 'Tags',
				'required'    => true,
				'validation'  => ['not_empty'],
				'placeholder' => 'Comma separated list.',
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
			 
				    $this->question->save([
				        'title' 	=> $form->Value('title'),
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        'cat_id' 	=> $this->auth->userid(),
				        'created' 	=> $now,
				    ]);

				    $lastQuestionID = $this->db->lastInsertId();

				    $this->question->addTags($form->Value('tags'), $lastQuestionID);

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
		$this->views->add('question/new_question', [
			'title' => "New Question",
			'form' => $form->getHTML()
		]);
	}

}