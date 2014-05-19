<?php

namespace nuvalis\Base;
 
/**
 * A controller for posts and admin related events.
 *
 */
class AnswersController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->posts = new \Anax\Posts\Posts();
	    $this->posts->setDI($this->di);
	    $this->theme->setTitle("Application");
	}
	 
}