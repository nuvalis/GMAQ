<?php

namespace nuvalis\Tags;
 
/**
 * A controller for tags and admin related events.
 *
 */
class TagsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->tags = new \Anax\Tags\Tags();
	    $this->tags->setDI($this->di);
	    $this->theme->setTitle("Tags");
	}

	public function indexAction()
	{

		$this->listAction();

	}

	public function listAction()
	{
		
	}

	public function addAction() 
	{

	}
	 
}