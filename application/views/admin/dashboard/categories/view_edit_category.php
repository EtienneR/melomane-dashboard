<?php 
	echo form_open(base_url(uri_string()));
?>

	<div class="form-group">
		<label for="title_category">Titre de la catégorie:</label>
		<input type="text" class="form-control" id="title_category" name="title_category" value="<?php if (isset($title_category)) echo $title_category; echo set_value('title_category'); ?>" />
	</div><!-- end .form-group -->

	<div class="form-group">
		<label for="description_category">Description (256 caractères max) de la catégorie :</label>
		<input type="text" id="description_category" class="form-control" name="description_category" value="<?php if (isset($description_category)) echo $description_category; echo set_value('description_category'); ?>" />
	</div><!-- end .form-group -->

	<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_category') echo 'Ajouter'; else echo 'Modifier'; ?>" />

	<?php if ($page == 'edit_category'): ?>
		<?php if ($content->num_rows > 0): ?>
			<h3>Musiques(s) associé(s) à cette catégorie</h3>
			<ul class="unstyled">
			<?php foreach ($content->result() as $row): ?>
				<li><a href="<?php echo base_url('admin/content/edit/' . $row->id_song); ?>"><?php echo $row->title_song; ?></a></li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>Aucune musique n'est rattachée à cette catégorie</p>
		<?php endif; ?>

	<?php endif; ?>

</form>