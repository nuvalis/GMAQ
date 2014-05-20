<?php

namespace nuvalis\Comments;
 
/**
 * A controller for posts and admin related events.
 *
 */
class CommentsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->posts = new \Anax\Posts\Posts();
	    $this->posts->setDI($this->di);
	    $this->theme->setTitle("Application");
	}
	 
}