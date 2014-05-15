
<?php foreach($posts as $post) : ?>
	
	<h1> <a href="<?= $this->url->create('posts/id/' . $post->id); ?>"><?= $post->title; ?></a></h1>

<?php endforeach; ?> 