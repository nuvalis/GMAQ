<h1><?= $user->name ?></h1>
<div class="user-box">
	<p>Acronym: <?= $user->username ?></p>
	<p>Status: <?php if($user->deleted !=  null) {echo "<span class='softdelete'>Deleted</span>";} else {echo "<span class='green-active'>Active</span>";} ?></p>
	<p>Last Activity: <?= $user->active ?></p>
</div>

<div class="latest-questions">
<h3>Latest Questions</h3>
<?php foreach($user->latestQuestions as $question) : ?>
	<p><a href="<?= $this->url->create('questions/id/' . $question->id); ?>"><?= $question->title; ?></a></p>
<?php endforeach; ?>
</div>
<div class="latest-answers">
<h3>Latest Answers</h3>
<?php foreach($user->latestAnswers as $answer) : ?>
	<p><a href="<?= $this->url->create('questions/id/' . $answer->questions_id); ?>"><?= $answer->title; ?></a></p>
<?php endforeach; ?>
</div>

<div class="latest-comments">
<h3>Latest Comments</h3>
<?php foreach($user->latestComments as $comment) : ?>
	<p><a href="<?= $this->url->create('questions/id/' . $comment->questions_id); ?>"><?= substr($comment->content, 0, 140); ?></a></p>
<?php endforeach; ?>
</div>