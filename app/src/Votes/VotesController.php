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
		$this->votes->voteUp($id, $this->auth->userId(), $target);
	}

	public function downAction($target, $id)
	{

		$this->votes->voteDown($id, $this->auth->userId(), $target);
	 
	}

	public function calcAction($target, $id) 
	{
		$this->votes->calcVotes($target, $id);
	}
	 
}