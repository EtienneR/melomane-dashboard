<?php 
	echo form_open(current_url()); // $config['index_page'] = ''; dans config/config.php
?>

		<div class="row">

			<div class="col-md-2 form-group">
				<label for="id_soundcloud">ID Soundcloud</label>
				<input type="text" value="<?php if (isset($id_soundcloud)) echo $id_soundcloud; echo set_value('id_soundcloud'); ?>" name="id_soundcloud" id="id_soundcloud" class="form-control" />
			</div>

		</div><!-- end of .row -->


		<div class="row">

			<div class="col-md-4 form-group">
				<?php if ($page == 'add_content'): ?>
					<p class="show-img"><b>Image de l'article</b></p>
				<?php endif; ?>

				<div class="get-img">
					<?php if (!empty($images)): ?>
					<?php foreach ($images as $image): ?>
						<?php // faire un var_dump($query) pour comprendre
							$var = $image['relative_path'];
							$var = strstr($var, 'assets');
							$var = str_replace("\\","/", $var);
							$link_image = base_url($var . '/' . $image['name']);
						?>
						<input type="radio" name="image_song" id="<?php echo $image['name']; ?>" value="<?php echo $link_image; ?>" <?php if (isset($image_song) && $image_song == $link_image) echo 'checked="checked"'; ?>>
						<label for="<?php echo $image['name']; ?>"><img class="img-thumbnail" src="<?php echo $link_image; ?>" alt="<?php echo $image['name']; ?>" /></label>
					<?php endforeach; ?>
					<?php else: ?>
					<p>
						Aucune image n'disponible dans la <a href="<?php echo base_url('admin/medias'); ?>">galerie</a>
					</p>
					<?php endif; ?>
					<p class="to_hide">Cacher</p>
				</div><!-- end .form-group -->

				<p class="show-img">
					Image actuelle
					<br />
					<?php if (!empty($image_song)): ?>
					<img  src="<?php echo $image_song; ?>" alt="" width="128px" heigth="128" />
					<?php else: ?>
					<em>Aucune image</em>
					<?php endif; ?>
				</p>
			</div><!-- end .col-md-4 .form-group -->

			<div class="col-md-4 form-group">
				<label for="title_song">Titre</label>
				<input type="text" class="form-control" id="title_song" name="title_song" value="<?php if (isset($title_song)) echo $title_song; ?>" />
			</div><!-- end .col-md-4 form-group -->

			<div class="col-md-4 form-group">
				<label for="author_song">Artiste</label>
				<input type="text" class="form-control" id="author_song" name="author_song" value="<?php if (isset($author_song)) echo $author_song; ?>" list="authors" />
				<datalist id="authors">
				<?php foreach ($authors->result() as $row): ?>
					<option value="<?php echo $row->author_song; ?>">
				<?php endforeach; ?>
				</datalist>
			</div><!-- end .col-md-4 form-group -->

		</div><!-- end of .row -->


		<div class="row">

			<div class="col-md-12 form-group">
				<p>Catégorie</p>
				<div class="switch-toggle switch-<?php echo $categories->num_rows(); ?> well">
				<?php foreach ($categories->result() as $row): ?>
				<input id="<?php echo $row->title_category ;?>" name="category" type="radio" value="<?php echo $row->id_category ;?>" <?php if ($page == 'edit_content' and isset($categories) and $row->id_category == $id_category or set_value('rubrique') == $row->id_category) echo 'checked="checked"'; ?> required />
				<label for="<?php echo $row->title_category ;?>" onclick="">
					<?php echo $row->title_category; ?>
				</label>
				<?php endforeach; ?>
				<a class="btn btn-primary"></a>
				</div><!-- end of .switch-toggle .well -->
			</div><!-- end .col-md-12 form-group -->

			<div class="col-md-10 form-group">
				<p>Tags</p>
				<?php if ($page == 'add_content'): ?>
					<?php foreach ($tags as $tag): ?>
						<?php if (!empty($tag)): ?>
						<label for="<?php echo $tag; ?>">
							<input type="checkbox" name="tag_song[]" id="<?php echo $tag; ?>" value="<?php echo $tag; ?>" /> <?php echo $tag; ?>
						</label>
						<?php endif; ?>
					<?php endforeach; ?>

				<?php else: ?>
					<?php $explode = explode(';', $tags_song); ?>
					<?php $tab = array_unique(array_merge($explode, $tags)); ?>
					<?php foreach ($tab as $key => $tag): ?>
						<?php if (!empty($tag)): ?>
							<label for="<?php echo $tag; ?>">
								<input type="checkbox" name="tags_song[]" id="<?php echo $tag; ?>" value="<?php echo $tag; ?>" 
								<?php if (isset($explode[$key]) && $tag == $explode[$key]){
									echo 'checked';
								}
								?>
								/>
								 <?php echo $tag; ?>
							</label>
						<?php endif; ?>
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
				<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php echo $id_soundcloud; ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
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
	<div id="my-tag-list" class="tag-list"></div>

	<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_content') echo 'Ajouter'; else echo 'Modifier'; ?>" />

</form>