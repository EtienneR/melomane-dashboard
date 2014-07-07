<?php 
	echo form_open_multipart(current_url()); // $config['index_page'] = ''; dans config/config.php
?>

		<div class="row">
			<div class="col-md-2 form-group">
				<label for="id_soundcloud">ID Soundcloud</label>
				<input type="text" value="<?php if (isset($id_soundcloud)) echo $id_soundcloud; echo set_value('id_soundcloud'); ?>" name="id_soundcloud" id="id_soundcloud" class="form-control" />
			</div><!-- end of .col-md-2 .form-group -->
		</div><!-- end of .row -->

		<div class="row">
			<div class="col-md-4 form-group">
				<?php if ($page == 'edit_content'): ?>
				<p>Image actuelle :
					<br /><?php echo img_thumb_song($image_song); ?>
				</p>
				<?php endif; ?>
				<?php if (isset($image_bg)) echo $image_bg; ?>
				<input type="file" name="image" size="20" />
			</div><!-- end .col-md-4 .form-group -->

			<div class="col-md-4 form-group">
				<label for="title_song">Titre</label>
				<input type="text" class="form-control" id="title_song" name="title_song" value="<?php if (isset($title_song)) echo $title_song; ?>" />
			</div><!-- end .col-md-4 form-group -->

			<div class="col-md-4 form-group">
				<label for="artist_song">Artiste</label>
				<input type="text" class="form-control" id="artist_song" name="artist_song" value="<?php if (isset($artist_song)) echo $artist_song; ?>" list="authors" />
				<datalist id="authors">
				<?php foreach ($authors->result() as $row): ?>
					<option value="<?php echo $row->artist_song; ?>">
				<?php endforeach; ?>
				</datalist>
			</div><!-- end .col-md-4 form-group -->

		</div><!-- end of .row -->
		
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="punchline_song">Punchline</label>
				<input type="text" class="form-control" id="punchline_song" name="punchline_song" value="<?php if (isset($punchline_song)) echo $punchline_song; ?>" />
			</div><!-- end .col-md-4 form-group -->
		</div><!-- end of .row -->

		<div class="row">

			<div class="col-md-12 form-group">
				<p>Catégorie</p>
				<?php foreach ($categories->result() as $row): ?>
				<input id="<?php echo $row->title_category ;?>" name="category" type="radio" value="<?php echo $row->id_category ;?>" <?php if ($page == 'edit_content' and isset($categories) and $row->id_category == $id_category or set_value('rubrique') == $row->id_category) echo 'checked="checked"'; ?> required />
					<?php echo $row->title_category; ?>
				</label>
				<?php endforeach; ?>
			</div><!-- end .col-md-12 form-group -->

			<div class="col-md-10 form-group">
				<p>Tags</p>
				<?php if ($page == 'add_content'): ?>
					<?php foreach ($tags->result() as $tag): ?>
						<label for="<?php echo $tag->name_tag; ?>">
							<input type="checkbox" name="tag_song[]" id="<?php echo $tag->name_tag; ?>" value="<?php echo $tag->id_tag; ?>" /> <?php echo $tag->name_tag; ?>
						</label>
					<?php endforeach; ?>

				<?php else: ?>
					<?php foreach ($tags->result() as $tag): ?>
					<?php if($this->model_content->get_tags_by_tag($id_song, $tag->id_tag)->num_rows() > 0): ?>
					<?php $id_tag = ($this->model_content->get_tags_by_tag($id_song, $tag->id_tag)->row()->id_tag); ?>

				<?php endif; ?>
						<label for="<?php echo $tag->name_tag; ?>">
							<input type="checkbox" name="tag_song[]" id="<?php echo $tag->name_tag; ?>" value="<?php echo $tag->id_tag; ?>" <?php if (isset($id_tag) && $tag->id_tag == $id_tag or set_value('tag_song') == $tag->id_tag) echo 'checked="checked"'; ?>/> <?php echo $tag->name_tag; ?>
						</label>
					<?php endforeach; ?>
						
				<?php endif; ?>
			</div><!-- end .col-md-10 form-group -->

		</div><!-- end of .row -->

		<div class="row">

			<div class="col-md-4 form-group">
				<p>Etat</p>
				<div class="switch-toggle well">
				<?php
				$array_state = array(0 => "Brouillon", "Publié");
				foreach ($array_state as $key => $value): ?>
					<input id="<?php echo strtolower($value); ?>" name="state_song" type="radio" value="<?php echo $key; ?>" <?php if(isset($state_song) and $state_song == $key or set_value('c_state') == $key) echo 'checked="checked"'; ?> />
					<label for="<?php echo strtolower($value); ?>" onclick="">
						<?php echo $value; ?>
					</label>
				<?php endforeach; ?>
				<a class="btn btn-primary"></a>
				</div><!-- end .switch-toggle .well -->
				<?php if ($page == 'edit_content'): ?>
<!-- 				<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php echo $id_soundcloud; ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe> -->
					<input type="checkbox" name="udate_song" id="udate_song" value="1" <?php echo set_checkbox('udate_song', '1'); ?> checked="checked" />
					<label for="udate_song">Mettre à jour la date de modification</label>
			</div><!-- col-md-4 form-group -->
		
			<?php else: ?>
				<label for="cdate_song">Date planifiée</label>
					<input type="datetime" class="form-control" name="cdate_song" id="cdate_song" value="" min="2014-04-21" placeholder="jj/mm/aaaa hh:mm:ss">
				</div><!-- end .form-group -->
			<?php endif; ?>
		</div><!-- end of .row -->

	<div class="row">

		<div class="col-md-4 form-group">
			<label for="vendor_song">Lien achat</label>
			<input type="text" class="form-control" name="vendor_song" />
		</div><!-- end .form-group -->

	</div><!-- end .row -->

	<div class="row">
		<p>Image de fond</p>
		<?php foreach ($img_bg->result() as $row): ?>
			<input type="radio" name="id_bg" id="<?php echo $row->id_bg; ?>" value="<?php echo $row->id_bg; ?>" <?php if ($page == 'edit_content' && isset($img_bg) && $row->id_bg == $id_bg) echo 'checked="checked"'; ?>>
			<label for="<?php echo $row->id_bg; ?>">
				<?php echo img_thumb_bg($row->image_bg); ?>
				<br /><?php echo $row->tag_bg; ?>
			</label>
		<?php endforeach; ?>
	</div><!-- end .row -->

	<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_content') echo 'Ajouter'; else echo 'Modifier'; ?>" />

</form>