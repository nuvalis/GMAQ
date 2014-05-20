<?php

namespace nuvalis\Votes;
 
/**
 * A controller for Votes and admin related events.
 *
 */
class VotesController extends \nuvalis\Base\ApplicationController
{

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
	    $this->votes = new \nuvalis\Votes\Votes();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("Vote");
	}

	public function upAction($target, $id)
	{
		$this->votes->voteUpAnswer($id, $this->auth->userId(), $target);
	}

	public function downAction($target, $id)
	{

		$this->votes->voteDownAnswer($id, $this->auth->userId(), $target);
	 
	}
	 
}