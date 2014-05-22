<h1><?= $question->title ?></h1>

<div class="question" data-questionsID="<?= $question->id ?>">
	<p><?php if ($question->views === 0){echo "0";}else{echo $question->views;} ?> views </p>
	
	<?php if (isset($tags)): ?>
		<div class="tags">
			<?php foreach ($tags as $tag): ?>
				<a href="<?= $this->url->create('tags/' . $tag->tag_name); ?>" class="tag-link"><?= $tag->tag_name; ?></a>
			<?php endforeach ?>
		</div>
	<?php endif ?>

	<p>
	<?= $question->content ?>
	</p>

	<h3>Comments</h3>
	<div class="comments">
	<?php if ($comments): ?>
	
		<?php foreach($comments as $comment) : ?>
				
			<div class="comment-post">
				<a class="comment-gravatar" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
					<img class="gravatar" src="<?= $this->mzHelpers->get_gravatar($comment->email, 40); ?>" alt="">
				</a>

				<div class="content-main">
					<a class="comment-username" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
						<?= $comment->username ?>
					</a>

					<span class="comment-date">Comment posted at <?= date("Y-m-d H:i", strtotime($comment->created)); ?></span>
					
					<p class="comment-content"><?= $comment->content ?></p>
				</div>	
			</div>

		<?php endforeach; ?>

	<?php else: ?>

		<p>No comments found for this question.</p>

	<?php endif ?>
	</div>


</div>
<p><a href="<?= $this->url->create('comments/new/questions/' . $question->id); ?>">Comment this Question</a></p>
<hr>

