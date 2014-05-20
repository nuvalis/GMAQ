<?php

namespace Anax\Posts;
 
/**
 * Model for Posts.
 *
 */
class Posts extends \Anax\MVC\BaseModel
{
 	public function voteUpAnswer($postid) 
 	{
 		
 	}

 	public function voteDownAnswer($postid) 
 	{
 		
 	}

 	public function findByType($type) 
 	{

	$this->db->select()
	    ->from($this->getSource())
	    ->where("type = ?");
	 
	$this->db->execute([$type]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}

 	public function linkAnswer($qid, $aid) 
 	{
 		$this->db->insert('quest_answers_ref', ['quest_id', 'answer_id']);
		$this->db->execute([$qid, $aid]);
 	}



}