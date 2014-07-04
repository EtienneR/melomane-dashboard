<div class="col-md-9">
<?php 
	echo form_open(base_url(uri_string()));
?>

	<div class="row">

		<div class="form-group">
			<div class="switch-toggle well">
				<?php
					$array_state = array(0 => "Brouillon", "Publiée");
					foreach ($array_state as $key => $value): 
				?>
				<?php set_value('c_state'); ?>
					<input id="<?php echo strtolower($value); ?>" name="state_news" type="radio" value="<?php echo $key; ?>" <?php if (isset($state_news) and $state_news == $key or set_value('c_state') == $key) echo 'checked="checked"'; ?> required />
					<label for="<?php echo strtolower($value); ?>" onclick="">
						<?php echo $value; ?>
					</label>
				<?php endforeach; ?>
				<a class="btn btn-primary"></a>
			</div><!-- end .switch-toggle .well -->
		</div><!-- end .form-group -->

		<div class="form-group">
			<label for="title_news">Titre de la news :</label>
			<input type="text" class="form-control" id="title_news" name="title_news" value="<?php if (isset($title_news)) echo $title_news; echo set_value('title_news'); ?>" required />
		</div><!-- end .form-group -->

		<div class="form-group">
			<label for="content_news">Contenu :</label>
			<textarea type="text" id="content_news" class="form-control" name="content_news" required><?php if (isset($content_news)) echo $content_news; echo set_value('content_news'); ?></textarea>
		</div><!-- end .form-group -->

		<div class="form-group">
			<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_news') echo 'Ajouter'; else echo 'Modifier'; ?>" />
		</div>

	</div><!-- end of .row -->

</form>

</div><!-- end of .col-md-9 -->

<div class="col-md-3">

	<?php if ($page == 'edit_news'): ?>
		<h4>Informations</h4>
		Créé le <?php echo $cdate_news; ?>
		<?php if (!empty($udate_news)): ?>
		<br /> Modifiée le <?php echo $udate_news; ?>
		<?php endif; ?>
		<?php if ($others_news->num_rows() > 0): ?>
		<h4>Autres news (<?php echo $others_news->num_rows(); ?>)</h4>
		<ul>
			<?php foreach($others_news->result() as $row): ?>
			<li>
				<a href="<?php echo base_url('admin/news/edit/' . $row->id_news); ?>" title="Modifier">
					<?php echo $row->title_news; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	<?php elseif($page == 'add_news'): ?>
		<?php if ($news->num_rows() > 0): ?>
		<h4>Toutes les news</h4>
			<ul>
			<?php foreach($news->result() as $row): ?>
			<li>
				<a href="<?php echo base_url('admin/news/edit/' . $row->id_news); ?>" title="Modifier">
					<?php echo $row->title_news; ?>
				</a>
			</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>

</div><!-- end of .col-md-3 -->