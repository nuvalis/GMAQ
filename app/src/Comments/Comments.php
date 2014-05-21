<?php

namespace nuvalis\Comments;

class Comments extends \Anax\MVC\BaseModel
{

	public function listAnswersComments($id)
	{
		$this->db->select()
	        ->from($this->getSource())
	       	->where("answers_id = ?");
	 
	    $this->db->execute([$id]);
	    return $this->db->fetchAll();
	}

}