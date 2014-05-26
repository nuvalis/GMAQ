<div id="question-box" class="question" data-questions-ID="<?= $question->id ?>">
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

	<?php include ANAX_APP_PATH . '/view/comments/partial.tpl.php'; ?>

	<p><a href="<?= $this->url->create('comments/new/questions/' . $question->id); ?>">Comment this Question</a></p>


</div>


