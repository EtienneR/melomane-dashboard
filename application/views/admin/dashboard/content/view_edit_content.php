<?php 
	echo form_open_multipart(current_url()); // $config['index_page'] = ''; dans config/config.php
?>

	<div class="row">
		<div class="col-md-8 form-group">
			<label for="url_soundcloud">URL Soundcloud</label>
			<input type="text" name="url_soundcloud" id="url_soundcloud" class="form-control" value="<?php 
				if (isset($url_soundcloud) && !empty($url_soundcloud)):
					echo $url_soundcloud;
				elseif (isset($_REQUEST['url_soundcloud'])):
					echo $_REQUEST['url_soundcloud'];
				endif;  
			?>" required />
		</div><!-- end of .col-md-8 .form-group -->
	</div><!-- end of .row -->

	<div class="row">
		<div class="col-md-12 form-group">
			<p>Etat</p>
				<?php $array_state = array(0 => "Brouillon", "Publié");
				foreach ($array_state as $key => $value): ?>
					<input id="<?php echo strtolower($value); ?>" name="state_song" type="radio" value="<?php echo $key; ?>" 
						<?php 
							if (isset($state_song) && $state_song == $key) echo "checked";
							if (isset($_REQUEST['state_song'])) echo "checked";  
							if ($page == 'add_content' && $key == 0) echo "checked";  
						?> />
					<label for="<?php echo strtolower($value); ?>" onclick="">
						<?php echo $value; ?>
					</label>
				<?php endforeach; ?>
		</div><!-- end of .col-md-12 .form-group -->
	</div><!-- end of .row -->

	<div class="row">
		<div class="col-md-12 form-group">
			<input type="checkbox" name="udate_song" id="udate_song" value="1" <?php echo set_checkbox('udate_song', '1'); ?> checked="checked" />
			<label for="udate_song">Mettre à jour la date de modification</label>
		</div><!-- end of .col-md-12 .form-group -->
	</div><!-- end of .row -->


	<div class="row">
		<div id="datetimepicker" class="col-md-3 form-group">
			<label for="pdate_song">Date planifiée :</label>
			<input type="text" class="form-control" id="pdate_song" name="pdate_song" value="<?php
				if (isset($pdate_song) && !empty($pdate_song)):
					echo $pdate_song;
				elseif (isset($_REQUEST['pdate_song'])):
					echo $_REQUEST['pdate_song'];
				endif;
			?>" data-date-format="yyyy-mm-dd 00:00:00" />
		</div><!-- end #datetimepicker .col-md-3 .form-group -->
	</div><!-- end .row -->

	<div class="row">
		<div class="col-md-4 form-group">
			<?php if ($page == 'edit_content'): ?>
			<p>Image actuelle :
				<br /><?php echo img_thumb_song($image_song); ?>
			</p>
			<?php endif; ?>
			<?php if (isset($image_song)) echo $image_song; ?>
			<input type="file" name="image" size="20" />
		</div><!-- end .col-md-4 .form-group -->
	</div><!-- end of .row -->

	<div class="row">

		<div class="col-md-6 form-group">
			<label for="title_song">Titre</label>
			<input type="text" class="form-control" id="title_song" name="title_song" value="<?php 
				if (isset($title_song) && !empty($title_song)):
					echo $title_song;
				elseif (isset($_REQUEST['title_song'])):
					echo $_REQUEST['title_song'];
				endif; ?>" required />
		</div><!-- end of .col-md-6 .form-group -->

		<div class="col-md-6 form-group">
			<label for="artist_song">Artiste</label>
			<input type="text" class="form-control" id="artist_song" name="artist_song" value="<?php 
				if (isset($artist_song) && !empty($artist_song)):
					echo $artist_song;
				elseif (isset($_REQUEST['artist_song'])):
					echo $_REQUEST['artist_song'];
				endif;
				?>" list="authors" required />
			<datalist id="authors">
			<?php foreach ($authors->result() as $row): ?>
				<option value="<?php echo $row->artist_song; ?>">
			<?php endforeach; ?>
			</datalist>
		</div><!-- end .col-md-6 form-group -->

	</div><!-- end .row -->

	<div class="row">
		<div class="col-md-12 form-group">
			<label for="punchline_song">Punchline</label>
			<input type="text" class="form-control" id="punchline_song" name="punchline_song" value="<?php 
				if (isset($punchline_song) && !empty($punchline_song)):
					echo $punchline_song;
				elseif (isset($_REQUEST['punchline_song'])):
					echo $_REQUEST['punchline_song'];
				endif;
				?>" required />
		</div><!-- end .col-md-12 form-group -->
	</div><!-- end of .row -->

	<div class="row">
		<div class="col-md-12 form-group">
			<p>Catégorie</p>
			<?php foreach ($categories->result() as $row): ?>
			<label for="<?php echo $row->title_category; ?>">
			<input id="<?php echo $row->title_category; ?>" name="category" type="radio" value="<?php 
				if (isset($id_category) and $page == 'edit_content') echo $id_category; ?><?php if (isset($row->id_category) and $page == 'add_content') echo $row->id_category; ?>"
			<?php
				if (isset($id_category)) echo 'checked';
				if (isset($_REQUEST['category']) && $_REQUEST['category'] == $row->id_category) echo 'checked';
			?> />
				<?php echo $row->title_category; ?>
			</label>
			<?php endforeach; ?>
		</div><!-- end .col-md-12 form-group -->
	</div><!-- end of .row -->

	<div class="row">
		<div class="col-md-10 form-group">
			<p>Tags</p>
			<?php if ($page == 'add_content'): ?>
				<?php foreach ($tags->result() as $key => $tag): ?>
					<label for="<?php echo $tag->name_tag; ?>">
						<input type="checkbox" name="tag_song[]" id="<?php echo $tag->name_tag; ?>" value="<?php echo $tag->id_tag; ?>" <?php
				if (isset($_REQUEST['tag_song'][$key]) && $_REQUEST['tag_song'][$key] == $tag->id_tag) echo 'checked';
			?> />
						<?php echo $tag->name_tag; ?>
					</label>
				<?php endforeach; ?>
			<?php else: ?>
				<?php foreach ($tags->result() as $tag): ?>
				<?php 
					if ($this->model_content->get_tags_by_tag($id_song, $tag->id_tag)->num_rows() > 0):
						$id_tag = $this->model_content->get_tags_by_tag($id_song, $tag->id_tag)->row()->id_tag;
					endif;
				?>
					<label for="<?php echo $tag->name_tag; ?>">
						<input type="checkbox" name="tag_song[]" id="<?php echo $tag->name_tag; ?>" value="<?php echo $tag->id_tag; ?>" <?php if (isset($id_tag) && $id_tag == $tag->id_tag) echo 'checked=checked'; ?> />
						<?php echo $tag->name_tag; ?>
					</label>
				<?php endforeach; ?>
			<?php endif; ?>
			
		</div><!-- end .col-md-10 form-group -->
	</div><!-- end of .row -->

	<div class="row">
		<div class="col-md-6 form-group">
			<label for="vendor_song">Lien achat</label>
			<input type="text" class="form-control" name="vendor_song" value="<?php 
				if (isset($vendor_song) && !empty($vendor_song)):
					echo $vendor_song;
				elseif (isset($_REQUEST['vendor_song'])):
					echo $_REQUEST['vendor_song'];
				endif;
				?>" />
		</div><!-- end of .col-md-6 .form-group -->
	</div><!-- end of .row -->

	<div class="row">
		<div class="col-md-12 form_group">
			<p>Image de fond</p>
			<?php foreach ($img_bg->result() as $row): ?>
				<input type="radio" name="id_bg" id="<?php echo $row->id_bg; ?>" value="<?php echo $row->id_bg; ?>" <?php if ($page == 'edit_content' && isset($img_bg) && $row->id_bg == $id_bg) echo 'checked="checked"'; ?> />
				<label for="<?php echo $row->id_bg; ?>">
					<?php echo img_thumb_bg($row->image_bg); ?>
				</label>
			<?php endforeach; ?>
		</div><!-- end of .col-md-12 .form-group -->
	</div><!-- end of .row-->

	<input type="submit" class="btn btn-success form_group" value="<?php if ($page == 'add_content') echo 'Ajouter'; else echo 'Modifier'; ?>" />

</form>