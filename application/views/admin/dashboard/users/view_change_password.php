<?php 
	echo form_open(base_url(uri_string()));
?>

	<div class="form-group">
		<label for="u_old_pass">Ancien Password :</label>
		<input type="password" id="u_old_pass" class="form-control" name="u_old_pass" value="" required />
	</div><!-- end .form-group -->

	<div class="form-group">
		<label for="password_user">Nouveau Password :</label>
		<input type="password" id="password_user" class="form-control" name="password_user" value="" required />
	</div><!-- end .form-group -->

	<div class="form-group">
		<label for="password_user_2">Nouveau Password (confirmation) :</label>
		<input type="password" id="password_user_2" class="form-control" name="password_user_2" value="" required />
	</div><!-- end .form-group -->
	
	<input type="submit" class="btn btn-success" value="Modifier" ?>

</form>