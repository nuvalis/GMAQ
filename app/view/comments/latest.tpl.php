<h3>Comments</h3>
<div class="comments">
<?php foreach($comments as $comment) : ?>
	<?php
	$content = $this->textFilter->markdown($comment->content);
	$content = strip_tags($content);
	$content = htmlentities($content);
	$content = $this->mzHelpers->truncate($content);
	?>
	<div class="comment-post">
		<?php if (isset($comment->questions_id)): ?>
			<a href="<?= $this->url->create('questions/id/' . $comment->questions_id) ?>"><?= $content ?></a>	
		<?php elseif(isset($comment->answers_id)): ?>
			<a href="<?= $this->url->create('answers/id/' . $comment->answers_id) ?>"><?= $content ?></a>
		<?php endif ?>
		
	</div>
<?php endforeach; ?>
</div>