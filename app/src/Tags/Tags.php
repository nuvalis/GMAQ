<?php

namespace nuvalis\Tags;
 
/**
 * Model for Tags.
 *
 */
class Tags extends \Anax\MVC\BaseModel
{

	public function findByTag($tag)
	{

	 	$sql = "SELECT DISTINCT *
			    FROM questions q
			        INNER JOIN questions_tag_ref qtr
			            ON q.id = qtr.questions_id
			        INNER JOIN tags t
			            ON qtr.tag_id = t.tag_id
			    WHERE q.id = ?";

		$this->db->execute($sql, [$tag]);
		$this->db->setFetchModeClass(__CLASS__);
		return$this->db->fetchAll();

	}

 
}