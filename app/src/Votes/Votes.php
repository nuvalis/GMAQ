<?php

namespace Anax\Votes;
 
/**
 * Model for Users.
 *
 */
class Votes extends \Anax\MVC\BaseModel
{

 	public function voteUpAnswer($postid, $userId) 
 	{
 		$this->checkVoteExist($postid, $userId);

 		$this->save([
		'posts_id' 	=> $postid,
		'user_id' 	=> $userId,
		'vote'		=> "1"
		]);

 	}

 	public function voteDownAnswer($postid, $userId) 
 	{
 		$this->checkVoteExist($postid, $userId);

 		$this->save([
		'posts_id' 	=> $postid,
		'user_id' 	=> $userId,
		'vote'		=> "-1"
		]);
 		
 	}

 	public function checkVoteExist($postid, $userId)
 	{

 		$this->checkPostExist($postid);

 		if($userId == false) {
 			throw new \Exception("You can't vote without a user id.", 1);
 		}

 		$this->db->select()->from($this->getSource())
 		->where("posts_id = ?")
 		->andWhere("user_id = ?");

 		$this->db->execute([$postid, $userId]);
	    $this->db->setFetchModeClass(__CLASS__);
	    $res = $this->db->fetchAll();

 		if($res) {

 			throw new \Exception("You have voted once", 1);

 		}

 	}

 	public function checkPostExist($postid) 
 	{

 		$this->db->select()->from("posts")->where("id = ?");
 		$this->db->execute([$postid]);

 		$res = $this->db->fetchAll();

 		if(!$res) {

 			throw new \Exception("Post does not exist, can't vote on that.", 1);

 		}

 	}
 
}