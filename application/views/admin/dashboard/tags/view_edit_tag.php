<?php 
	echo form_open(base_url(uri_string()));
?>

	<div class="form-group">
		<label for="name_tag">Nom du tag</label>
		<input type="text" class="form-control" id="name_tag" name="name_tag" value="<?php if (isset($name_tag)) echo $name_tag; echo set_value('name_tag'); ?>" />
	</div><!-- end .form-group -->

	<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_tag') echo 'Ajouter'; else echo 'Modifier'; ?>" />

	<?php if ($page == 'edit_tag'): ?>
		<?php if ($content->num_rows > 0): ?>
			<h3><?php echo $content->num_rows(); ?> Musiques(s) associé(s) à ce tag</h3>
			<ul class="unstyled">
			<?php foreach ($content->result() as $row): ?>
				<li><a href="<?php echo base_url('admin/content/edit/' . $row->id_song); ?>"><?php echo $row->title_song; ?></a></li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>Aucune musique n'est rattachée à ce tag</p>
		<?php endif; ?>

	<?php endif; ?>

</form>