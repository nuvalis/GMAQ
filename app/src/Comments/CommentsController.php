<?php

namespace nuvalis\Comments;
 
/**
 * A controller for comments and admin related events.
 *
 */
class CommentsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->comments = new \nuvalis\Comments\Comments();
	    $this->comments->setDI($this->di);
	    $this->theme->setTitle("Comment");
	}

	public function newAction($target, $ID)
	{

		$this->isLoggedIn();
		
 		$form = $this->form;

		$form = $form->create([], [
			'content' => [
				'type'        => 'textarea',
				'label'       => 'Content',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) use ($ID, $target) {

					$now = date(DATE_RFC2822);
			 
				    $this->comments->save([
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        $target . '_id' 	=> $ID,
				        'created' 	=> $now,
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create($target . '/id/' . $ID);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("New Comment");
		$this->views->add('question/new_question', [
			'title' => "New Comment",
			'form' => $form->getHTML()
		]);
	}

	public function listAnswersCommentsAction($id)
	{

		$comments = $this->comments->listAnswersComments($id);

		$this->theme->setTitle("Comment");
		$this->views->add('comments/list_comments', [
			'title' => "New Comment",
			'comments' => $comments
		]);

	}
	 
}