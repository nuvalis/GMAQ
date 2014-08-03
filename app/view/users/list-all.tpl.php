<h1><?=$title?></h1>
        
        <h5>Ordered by Points</h5>

		<?php foreach ($users as $user) : ?>
			<div class="mini-profile left">
			<img class="gravatar left" src="<?= $this->mzHelpers->get_gravatar($user->email, 128); ?>" alt=""><br>
			<a href="<?= $this->url->create('users/id/' . $user->id ); ?>"><?= $user->username ?></a> <br>
			Points <?= $user->points ?> <br>
            </div>
		<?php endforeach; ?>


