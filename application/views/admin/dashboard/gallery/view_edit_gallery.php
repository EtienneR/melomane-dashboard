<?php 
	echo form_open_multipart(base_url(uri_string()));
?>

	<div class="form-group">
		<label for="tag_bg">Légende du background</label>
		<input type="text" class="form-control" id="tag_bg" name="tag_bg" value="<?php if (isset($tag_bg)) echo $tag_bg; echo set_value('tag_bg'); ?>" />
	</div><!-- end .form-group -->

	<div class="form-group">
		<?php if ($page == 'edit_bg'): ?>
		<p>Image actuelle :
			<br /><?php echo img_thumb_imag($image_bg); ?>
		</p>
		<?php endif; ?>
		<?php if (isset($image_bg)) echo $image_bg; ?>
		<input type="file" name="image" size="20" />
	</div><!-- end .col-md-4 .form-group -->

	<div class="form-group">
		<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_bg') echo 'Ajouter'; else echo 'Modifier'; ?>" />
	</div><!-- end .form-group -->

	<?php if ($page == 'edit_bg'): ?>
	<div class="form-group">
		<?php if ($content->num_rows > 0): ?>
			<h3><?php echo $content->num_rows(); ?> Musiques(s) associé(s) à ce background</h3>
			<ul class="unstyled">
			<?php foreach ($content->result() as $row): ?>
				<li>
					<a href="<?php echo base_url('admin/content/edit/' . $row->id_song); ?>">
						<?php echo $row->title_song; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>Aucune musique n'est rattachée à ce background</p>
		<?php endif; ?>
	</div><!-- end of .form-group -->
	<?php endif; ?>

</form>