<?php

namespace nuvalis\Answers;

class Answers extends \Anax\MVC\BaseModel
{
 	public function voteUpAnswer($answersID) 
 	{
 		
 	}

 	public function voteDownAnswer($answersID) 
 	{
 		
 	}

 	public function findAnswers($questionID) 
 	{

 	$this->db->select()
	    ->from('answers')
	    ->where("questions_id = ?");

	$this->db->execute([$questionID]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}



}