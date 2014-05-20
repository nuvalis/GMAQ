<?php

namespace nuvalis\Answers;
 
/**
 * A controller for posts and admin related events.
 *
 */
class AnswersController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->posts = new \nuvalis\Answers\Answers();
	    $this->posts->setDI($this->di);
	    $this->theme->setTitle("Application");
	}

	public function newAction($questionID)
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
				'callback'  => function($form) use ($questionID) {

					$now = date(DATE_RFC2822);
			 
				    $this->posts->save([
				        'title' 	=> $form->Value('title'),
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        'questions_id' 	=> $questionID,
				        'created' 	=> $now,
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create('questions/id/' . $questionID);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("New Answer");
		$this->views->add('question/new_question', [
			'title' => "New Answer",
			'form' => $form->getHTML()
		]);
	}

	public function listAnswersAction($id)
	{

	}
	 
}