<?php 
	echo form_open(base_url(uri_string()));
?>

	<div class="form-group">
		<label for="pseudo_user">Login :</label>
		<input type="text" class="form-control" id="pseudo_user" name="pseudo_user" value="<?php if (isset($pseudo_user)) echo $pseudo_user; echo set_value('pseudo_user'); ?>" required />
	</div><!-- end .form-group -->

	<?php if ($page == 'add_user'): ?>
	<div class="form-group">
		<label for="password_user">Password :</label>
		<input type="password" id="password_user" class="form-control" name="password_user" value="<?php if (isset($password_user)) echo $password_user; echo set_value('password_user'); ?>" required />
	</div><!-- end .form-group -->
	<?php endif; ?>

	<div class="form-group">
		<label for="email_user">Email :</label>
		<input type="text" class="form-control" id="email_user" name="email_user" value="<?php if (isset($email_user)) echo $email_user; echo set_value('email_user'); ?>" required />
	</div><!-- end .form-group -->	

	<div class="form-group">
		<p>Level :</p>
		<?php
		$array_level = array(0 => "Admin", "Modérateur");
		foreach ($array_level as $key => $value): ?>
			<label class="radio" for="<?php echo strtolower($value); ?>"><?php echo $value; ?>
				<input type="radio" id="<?php echo strtolower($value); ?>" name="level_user" value="<?php echo $key; ?>" <?php if(isset($level_user) and $level_user == $key or set_value('level_user') == $key) echo 'checked="checked"'; ?> required />
			</label>
		<?php endforeach; ?>
	</div><!-- end .form-group -->

	<input type="submit" class="btn btn-success" value="<?php if ($page == 'add_user') echo 'Ajouter'; else echo 'Modifier'; ?>" />

</form>