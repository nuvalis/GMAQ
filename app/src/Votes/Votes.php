<?php

namespace nuvalis\Votes;
 
/**
 * Model for Users.
 *
 */
class Votes extends \Anax\MVC\BaseModel
{

 	public function voteUp($postid, $userId, $target) 
 	{
 		$this->checkVoteExist($postid, $userId, $target);

 		$this->save([
		$target . '_id' 	=> $postid,
		'user_id' 			=> $userId,
		'vote_value'		=> "1"
		]);

 	}

 	public function voteDown($postid, $userId, $target) 
 	{
 		$this->checkVoteExist($postid, $userId, $target);

 		$this->save([
		$target . '_id' 	=> $postid,
		'user_id' 			=> $userId,
		'vote_value'		=> "-1"
		]);
 		
 	}

 	public function checkVoteExist($postid, $userId, $target)
 	{

 		$this->checkPostExist($postid, $target);

 		if($userId == false) {
 			throw new \Exception("You can't vote without a user id.", 1);
 		}

 		$this->db->select()->from($this->getSource())
 		->where($target . "_id = ?")
 		->andWhere("user_id = ?");

 		$this->db->execute([$postid, $userId]);
	    $this->db->setFetchModeClass(__CLASS__);
	    $res = $this->db->fetchAll();

 		if($res) {

 			throw new \Exception("You have voted once", 1);

 		}

 	}

 	public function checkPostExist($postid, $target) 
 	{

 		$this->db->select()->from($target)->where("id = ?");
 		$this->db->execute([$postid]);

 		$res = $this->db->fetchAll();

 		if(!$res) {

 			throw new \Exception("Target $target does not exist, can't vote on that.", 1);

 		}

 	}
 
}