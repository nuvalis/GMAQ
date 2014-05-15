<?php

namespace Anax\Votes;
 
/**
 * A controller for Votes and admin related events.
 *
 */
class VotesController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
	    $this->votes = new \Anax\Votes\Votes();
	    $this->auth->isLoggedIn();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("User");
	}

	public function upAction($id)
	{
		$this->votes->voteUpAnswer($id, $this->auth->userId());
	}

	public function downAction($id)
	{

		$this->votes->voteDownAnswer($id, $this->auth->userId());
	 
	}


	 
}