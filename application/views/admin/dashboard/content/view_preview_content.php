<html>
<head>
	<meta charset="UTF-8" />
	<title>Préview musique - <?php echo $query->title_song; ?></title>
	<?php echo css_url('bootstrap.min'); ?>
</head>
<body>

	<div class="container">

		<div class="row">
			<h1 class="col-md-8"><?php echo $query->title_song; ?></h1>
			<p class="col-md-4"><?php echo img_thumb_song($query->image_song); ?></p>
		</div><!-- end of .row -->

		<div class="row">
			<p><?php echo $query->artist_song; ?></p>
			<p><em><?php echo $query->punchline_song; ?></em> rédigé par <?php echo $query->pseudo_user; ?></p>

			<iframe width="100%" height="150" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php echo $query->id_soundcloud; ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
		</div><!-- end of .row -->


	</div><!-- end of .container -->

</body>
</html>


