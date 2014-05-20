<?php

namespace nuvalis\Questions;

class Questions extends \Anax\MVC\BaseModel
{
 	public function voteUpQuestion($postid) 
 	{
 		
 	}

 	public function voteDownQuestion($postid) 
 	{
 		
 	}

 	public function linkAnswer($qid, $aid) 
 	{
 		$this->db->insert('questions_answers_ref', ['questions_id', 'answers_id']);
		$this->db->execute([$qid, $aid]);
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

 	public function countId($id) 
 	{

 		$sql = $this->findById($id);
 		$views = $sql->views;
 		$count = $views + 1;
 		$this->save(["id" => $id, "views" => $count]);

 	}

 	public function countAnswers($id) 
 	{

	 	$this->db->select("COUNT()")
		    ->from('answers')
		    ->where("questions_id = ?");

		$this->db->execute([$id]);
		$res = $this->db->fetchAll();
		$res = (array) $res[0];
		return $res = (string) $res["COUNT()"];


 	}



}