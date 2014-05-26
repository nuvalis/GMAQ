<div class="comments">
	<?php if ($comments): ?>
	
	<?php foreach($comments as $comment) : ?>	
			<div class="comment-post" data-comments-ID="<?= $comment->id ?>">
				<a class="comment-gravatar" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
					<img class="gravatar" src="<?= $this->mzHelpers->get_gravatar($comment->email, 128); ?>" alt="">
				</a>

				<div class="content-main">
					<a class="comment-username" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
						<?= $comment->username ?>
					</a>

					<span class="comment-date">Comment posted at <?= date("Y-m-d H:i", strtotime($comment->created)); ?></span>
					
					<div class="comment-content"><?= $this->textFilter->markdown($comment->content) ?></div>
				</div>	
			</div>
	<?php endforeach; ?>
		
	<?php else: ?>

		<p>No comments found for this question.</p>

	<?php endif ?>
</div>