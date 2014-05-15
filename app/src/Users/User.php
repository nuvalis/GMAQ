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

 
}