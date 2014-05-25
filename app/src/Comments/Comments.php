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

	public function latestCommentsGlobal()
	{
		$sql = "SELECT DISTINCT *
				FROM comments c
				ORDER BY c.created DESC
				LIMIT 5";

		$this->db->execute($sql);
		return $this->db->fetchAll();
	}

}