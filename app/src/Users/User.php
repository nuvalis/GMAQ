<?php

namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\BaseModel
{

	/**
	 * Find and return specific.
	 *
	 * @return this
	 */
	public function findByUsername($username)
	{
	    $this->db->select()
	             ->from($this->getSource())
	             ->where("username = ?")->limit(1);
	 
	    $this->db->execute([$username]);
	    return $this->db->fetchInto($this);
	}

	public function latestAnswers($uid)
	{

		$this->db->select()
	        ->from("answers")
	        ->where("user_id = ?")->orderby("created DESC")->limit(5);
	 
	    $this->db->execute([$uid]);
	    return $this->db->fetchAll();

	}

	public function latestQuestions($uid)
	{

		$this->db->select()
	        ->from("questions")
	        ->where("user_id = ?")->orderby("created DESC")->limit(5);
	 
	    $this->db->execute([$uid]);
	    return $this->db->fetchAll();
		
	}

	public function latestComments($uid)
	{

		$this->db->select()
	        ->from("comments")
	        ->where("user_id = ?")->orderby("created DESC")->limit(5);
	 
	    $this->db->execute([$uid]);
	    return $this->db->fetchAll();
		
	}

 
}