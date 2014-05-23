<h1>List of available tags</h1>
<div class="tags">
	<?php foreach ($tags as $tag) : ?>
		
		<span class="tag-list"><a href="<?= $this->url->create('tags/find/' . $tag->tag_name); ?>" class="tag-link"><?= $tag->tag_name; ?></a></span>

	<?php endforeach; ?>
</div>