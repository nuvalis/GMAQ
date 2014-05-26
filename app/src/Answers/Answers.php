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

	 $sql = "SELECT *,
	 		(SELECT SUM(v.vote_value) FROM votes v WHERE a.id = v.answers_id) AS votes
	 		FROM answers a
	 		WHERE questions_id = ?";

	$this->db->execute($sql,[$questionID]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}

 	public function getAnswerParent($id)
 	{

 	$this->db->select()
	    ->from('answers')
	    ->where("id = ?");

	$this->db->execute([$id]);
	$res = $this->db->fetchOne();

	return $res->questions_id;

 	}

 	public function getAnswersComments($id)
 	{

		$this->db->select("c.content, c.created, u.username, u.email, u.id AS user_id")
		    ->from("comments AS c")
		   	->where("answers_id = ?")
		  	->join("user AS u", "u.id = c.user_id");

		$this->db->execute([$id]);
		return $this->db->fetchAll();
 	}



}