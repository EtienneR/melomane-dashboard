<?php if ($playlists->num_rows() > 0): ?>
	<p class="lead">
		Il y a actuellement
		<?php echo $playlists->num_rows(); ?> playlists enregistrées par <?php echo $playlist_user_distinct; ?> utilisateurs sur un total de <?php echo $users->num_rows(); ?> utilisateurs.
	<?php if ($no_playlist !== 0): ?>
		<br />
		<?php echo $no_playlist; ?>
		<?php if ($no_playlist == 1): ?>
			utilisateur n'a pas créé de playlist.
		<?php else: ?>
			utilisateurs n'ont pas créés de playlist.
		<?php endif; ?>
	<?php endif; ?>
	</p>
	<?php if (!empty($favorites)): ?>
		<p>Sur <?php echo $playlist_songs->num_rows(); ?> musiques enregistrées en playlist, <?php echo $favorites->num_rows(); ?> musiques apparaissent en favoris.</p>
	<?php else: ?>
		<p>Aucune musique n'a été rajouté en favoris par les utilisateurs...</p>
	<?php endif; ?>


	<div class="row">

		<!-- TOP FAVORIS -->
		<?php if (!empty($favorites)): ?>
		<div class="col-md-6">
			<h2>Top favoris (<?php echo $favorites->num_rows(); ?>)</h2>
			<table class="table table-bordered table-hover">
				<tr>
					<th>Titre</th>
					<th>Artiste</th>
					<th>Nombre</th>
				</tr>
				<?php foreach ($favorites->result() as $row): ?>
				<tr>
					<td><?php echo $row->title_song; ?></td>
					<td><?php echo $row->author_song; ?></td>
					<td><?php echo $row->total; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div><!-- end of .col-md-6 -->
		<?php endif; ?>

		<!-- TOP SONGS -->
		<?php if ($playlist_songs->num_rows()): ?>
		<div class="col-md-6">
			<h2>Top musiques (<?php echo $playlist_songs->num_rows(); ?>)</h2>
			<table class="table table-bordered table-hover">
				<tr>
					<th>Titre</th>
					<th>Artiste</th>
					<th>Nombre de playlist</th>
				</tr>
				<?php foreach ($playlist_songs->result() as $row): ?>
				<tr>
					<td><?php echo $row->title_song; ?></td>
					<td><?php echo $row->author_song; ?></td>
					<td><?php echo $row->total; ?></td>
				</tr>
				<?php endforeach; ?> 
			</table>
		</div><!-- end of .col-md-6 -->
		<?php endif; ?>

	</div><!-- end of .row -->

	<!-- NO PLAYLIST SONG -->
	<?php if ($no_playlist_song->num_rows() > 0): ?>
		<h2>Musiques non enregistrées en playlist (<?php echo $no_playlist_song->num_rows(); ?>)</h2>
		<table class="table table-bordered table-hover">
			<tr>
				<th>Titre</th>
				<th>Artiste</th>
			</tr>
			<?php foreach ($no_playlist_song->result() as $row): ?>
			<tr>
				<td><?php echo $row->title_song; ?></td>
				<td><?php echo $row->author_song; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p>NB : Toutes les musiques sont enregistrée dans une ou plusieurs playlist(s)!</p>
	<?php endif; ?>

<?php else: ?>
	<p>Aucune playlist n'existe</p>
<?php endif; ?>