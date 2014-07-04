<?php 
	echo form_open(base_url(uri_string()));
?>

	<div class="form-group">
		<label for="p_title">Titre :</label>
		<input type="text" class="form-control" id="p_title" name="p_title" value="<?php if(isset($p_title)): echo $p_title; else: echo set_value('p_title'); endif; ?>" required />
	</div><!-- end .form-group -->

	<div class="form-group">
		<label for="p_m_description">Description :</label>
		<input type="text" class="form-control" id="u_user" name="p_m_description" value="<?php if(isset($p_m_description)): echo $p_m_description; else: echo set_value('p_m_description'); endif; ?>" required />
	</div><!-- end .form-group -->

	<div class="form-group">
		<label for="p_about">A propos :</label>
		<textarea id="p_about" class="form-control" name="p_about" required><?php if(isset($p_about)): echo $p_about; else: echo set_value('p_about'); endif; ?></textarea>
	</div><!-- end .form-group -->

	<div class="form-group">
		<label for="p_email">Email de contact :</label>
		<input type="text" class="form-control" id="u_user" name="p_email" value="<?php if(isset($p_email)): echo $p_email; else: echo set_value('p_email'); endif; ?>" required />
	</div><!-- end .form-group -->

	<div class="row">
		<div class="col-xs-6">
			<label for="p_nb_listing">Nombre d'article par pagination (5 par défaut) :</label>
			<input type="text" class="form-control" id="p_nb_listing" name="p_nb_listing" value="<?php if(isset($p_nb_listing)): echo $p_nb_listing; else: echo set_value('p_nb_listing'); endif; ?>" />
		</div><!-- end .col-xs-6-->
		<div class="col-xs-6">
			<label for="p_nb_listing_f">Nombre d'article par pagination dans le RSS (10 par défaut) :</label>
			<input type="text" class="form-control" id="p_nb_listing_f" name="p_nb_listing_f" value="<?php if(isset($p_nb_listing_f)): echo $p_nb_listing_f; else: echo set_value('p_nb_listing_f'); endif; ?>" />
		</div><!-- end .col-xs-6-->
	</div>


	<div class="form-group">
		<label for="p_twitter">Compte Twitter :</label>
		<input type="text" class="form-control" id="p_twitter" name="p_twitter" value="<?php if(isset($p_twitter)): echo $p_twitter; else: echo set_value('p_twitter'); endif; ?>" />
	</div><!-- end .form-group -->

	<input type="submit" class="btn btn-success" value="Modifier" />

</form>