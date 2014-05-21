<h1>Answers</h1>
<div class="answers">

	<?php if($answers) : ?>
	<?php foreach($answers as $answer) : ?>

		<div class="answer-<?= $answer->id ?>" data-answersID="<?= $answer->id ?>">
			<h2><?= $answer->title ?></h2>

			<p><?= $answer->content ?></p> 

			<?php

				$this->db->select("c.content, u.username, u.email")
			        ->from("comments AS c")
			       	->where("answers_id = ?")
			       	->join("user AS u", "u.id = c.user_id");

			    $this->db->execute([$answer->id]);
			    $comments = $this->db->fetchAll();

			?>

			<h3>Comments</h3>
			<div class="comments">

			<?php if ($comments): ?>

				<?php foreach($comments as $comment) : ?>
					
					<div class="comment-post">
						<img src="<?= $this->mzHelpers->get_gravatar($comment->email, 40) ?>" alt="">
						<p><?= $comment->content ?></p>
						<p>Author: <?= $comment->username ?></p>
							
					</div>

				<?php endforeach; ?>

			<?php else: ?>

				<p>No comments found for this answer.</p>

			<?php endif ?>
			</div>

		</div>		

		<p><a href="<?= $this->url->create('comments/new/answers/' . $answer->id); ?>">Comment this Answer</a></p>

	<?php endforeach; ?> 
	<?php else : ?>
	
		<h3>No answers yet. Be the first one!</h3>
	
	<?php endif; ?>

</div>
<p><a href="<?= $this->url->create('answers/new/' . $questionID); ?>">New Answer</a></p>
