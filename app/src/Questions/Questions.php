<?php

namespace nuvalis\Questions;

class Questions extends \Anax\MVC\BaseModel
{

	public function addTags($string, $questionID)
	{
		$tags = explode(',', $string);
		$tags = array_filter($tags, function($var){
			return (trim($var) !== ''); //Return true if not empty string
		});

		foreach ($tags as $tag) {
					
			$tag = trim($tag);

			$this->db->select("tag_id, tag_name")->from("tags")->where('tag_name = ?');

			$this->db->execute([$tag]);
			$result = $this->db->fetchOne();

			if($result){
				
				$tagId = $result->tag_id;

				$this->db->insert('questions_tag_ref', ['tag_id', 'questions_id']);
				$this->db->execute([$tagId, $questionID]);

			} else {
				
				$this->db->insert('tags', ['tag_name']);
				$this->db->execute([$tag]);

				$lastTagId = $this->db->lastInsertId();

				$this->db->insert('questions_tag_ref', ['tag_id', 'questions_id']);
				$this->db->execute([$lastTagId, $questionID]);

			}


		}
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

 	public function findTags($questionID) 
 	{

 	$sql = "SELECT t.tag_name, t.tag_id
		    FROM questions q
		        INNER JOIN questions_tag_ref qtr
		            ON q.id = qtr.questions_id
		        INNER JOIN tags t
		            ON qtr.tag_id = t.tag_id
		    WHERE q.id = ?";

	$this->db->execute($sql, [$questionID]);
	$this->db->setFetchModeClass(__CLASS__);
	return $this->db->fetchAll();

 	}

 	public function findByTag($tag)
	{

	 	$sql = "SELECT DISTINCT *
			    FROM questions q
			        INNER JOIN questions_tag_ref qtr
			            ON q.id = qtr.questions_id
			        INNER JOIN tags t
			            ON qtr.tag_id = t.tag_id
			    WHERE t.tag_name = ?
			    ORDER BY q.created DESC";

		$this->db->execute($sql, [$tag]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();

	}

 	public function findComments($questionID) 
 	{

	$this->db->select("c.content, c.created, u.username, u.email, u.id AS user_id")
        ->from("comments AS c")
       	->where("questions_id = ?")
       	->join("user AS u", "u.id = c.user_id");

    $this->db->execute([$questionID]);
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

	 	$this->db->select("COUNT() AS count")
		    ->from('answers')
		    ->where("questions_id = ?");

		$this->db->execute([$id]);
		$res = $this->db->fetchOne();
		
		return $res->count;

 	}

 	public function orderList($order)
 	{
 		
 	}



}