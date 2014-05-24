<div id="question-box" class="question" data-questionsID="<?= $question->id ?>">
<h1><?= $question->title ?></h1>

	<div class="views">Views <br><br> <?php if ($question->views === 0){echo "0";} else {echo $question->views;} ?></div>
	<div class="votes">Votes
		<a href="<?= $this->url->create("votes/up/questions/" . $question->id) ?>">
			<div class="vote-up"></div>
		</a>
		<?php if ($votes == 0){echo "0";} else {echo $votes;} ?>
		<a href="<?= $this->url->create("votes/down/questions/" . $question->id) ?>">
			<div class="vote-down"></div>
		</a>
	</div>
	
	<?php if (isset($tags)): ?>
		<div class="tags">
			<?php foreach ($tags as $tag): ?>
				<a href="<?= $this->url->create('tags/find/' . $tag->tag_name); ?>" class="tag-link"><?= $tag->tag_name; ?></a>
			<?php endforeach ?>
		</div>
	<?php endif ?>

	<div class="content clear">
		<?= $this->textFilter->markdown($question->content) ?>
	</div>

	<h3 class="clear">Comments</h3>
	<div class="comments">
	<?php if ($comments): ?>
	
		<?php foreach($comments as $comment) : ?>
				
			<div class="comment-post">
				<a class="comment-gravatar" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
					<img class="gravatar" src="<?= $this->mzHelpers->get_gravatar($comment->email, 64); ?>" alt="">
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

	<p><a href="<?= $this->url->create('comments/new/questions/' . $question->id); ?>">Comment this Question</a></p>


</div>


