<h1><?= $user->name ?></h1>
<div class="user-box">
	<p>Username: <?= $user->username ?></p>
	<p>Status: <?php if($user->deleted !=  null) {echo "<span class='softdelete'>Deleted</span>";} else {echo "<span class='green-active'>Active</span>";} ?></p>
	<p>Last Activity: <?= $user->active ?></p>
</div>

<div class="latest-questions">
<h3>Latest Questions</h3>
<?php if ($user->latestQuestions): ?>
	<?php foreach($user->latestQuestions as $question) : ?>
		<p><a href="<?= $this->url->create('questions/id/' . $question->id); ?>"><?= $question->title; ?></a></p>
	<?php endforeach; ?>
<?php else: ?>
	<p class="smaller"><?= ucfirst($user->username) ?> has not asked any questions yet.</p>
<?php endif; ?>
</div>

<div class="latest-answers">
<h3>Latest Answers</h3>
<?php if ($user->latestAnswers): ?>
	<?php foreach($user->latestAnswers as $answer) : ?>
		<p><a href="<?= $this->url->create('questions/id/' . $answer->questions_id); ?>"><?= $answer->title; ?></a></p>
	<?php endforeach; ?>
<?php else: ?>
	<p class="smaller"><?= ucfirst($user->username) ?> has not answered on anything yet.</p>
<?php endif; ?>
</div>

<div class="latest-comments">
<h3>Latest Comments</h3>
<?php if ($user->latestComments): ?>
	<?php foreach($user->latestComments as $comment) : ?>
		<p><a href="<?= $this->url->create('questions/id/' . $comment->questions_id); ?>"><?= substr($comment->content, 0, 140); ?></a></p>
	<?php endforeach; ?>
<?php else: ?>
	<p class="smaller"><?= ucfirst($user->username) ?> has not commented on anything yet.</p>
<?php endif; ?>
</div>
