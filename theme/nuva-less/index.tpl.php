<!doctype html>
<html lang='<?= $lang ?>' class='<?=$title?> no-js'>
<head>
<meta charset='utf-8' />
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="viewport" content="width=device-width" />
<title><?=$title . $title_append?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src='<?=$this->url->asset($modernizr)?>'></script>

<?= themeLinks(); ?>

</head>
<body>

	<header>
		<div class="inner">
			<section>
				<?php if(isset($header)) echo $header?>
				<?php $this->views->render('header')?>
				<nav class="main-nav">
					
					<?php if ($this->views->hasContent('navbar')) : ?>
						<a class="mobile-button" onclick="showMenu()" href="#"><span class="menu-icon"></span></a>
						<?php $this->views->render('navbar')?>
					<?php endif; ?>

				</nav>
			</section>
		</div>
	</header>
		
		<?= $this->flashy->show(); ?>

	<main>

		<div class="inner">
			<?php if($this->views->hasContent('featured')) : ?>
				<section class="featured">
					<?php $this->views->render('featured')?>			
				</section>
			<?php endif; ?>

			<?php if(isset($main)) echo $main?>
			<?php $this->views->render('main')?>

		</div>

	</main>

	<footer>
		<div class="inner">

		<?php if(isset($footer)) echo $footer?>
		<?php $this->views->render('footer')?>

		</div>
	</footer>

	<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

	<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
		<script src='<?=$this->url->asset($val)?>'></script>
	<?php endforeach; endif; ?>

	<?php if(isset($google_analytics)): ?>
		<script>
		  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
		  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		  s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	<?php endif; ?>

</body>