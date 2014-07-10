<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<meta name="description" content="<?php echo $title ; ?>" />
		<?php echo css_url('bootstrap.min'); ?>
	</head>
	<body>

		<div class="container">
			<div class="row">
				<br />
				<div class="col-md-7 col-md-offset-2 panel panel-default">
					<br />
					<?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success">
						<?php echo $this->session->flashdata('success'); ?> <a class="close" data-dismiss="alert" href="#">&times;</a>
					</div>
					<?php endif; ?>	

					<?php if($this->session->flashdata('alert')): ?>
					<div class="alert alert-danger">
						<?php echo $this->session->flashdata('alert'); ?> <a class="close" data-dismiss="alert" href="#">&times;</a>
					</div>
					<?php endif; ?>

					<?php if(validation_errors()): ?>
					<?php echo validation_errors('<div class="alert alert-danger">', ' <a class="close" data-dismiss="alert" href="#">&times;</a></div>'); ?>
					<?php endif; ?>

					<h1 class="text-center"><?php echo $title; ?></h1>
					<br />

					<?php echo form_open(base_url('admin')); ?>
						<div class="input-prepend">
							<label class="col-sm-1 control-label" for="username">
								<i class="glyphicon glyphicon-user" style="font-size: 43px;"></i>
							</label>
							<div class="col-sm-11">
								<input type="text" class="form-control input-lg" placeholder="Username" name="username" id="username" required />
							</div>
							<br/>
							<br/>
							<br/>
							<label class="col-sm-1 control-label" for="password">
								<i class="glyphicon glyphicon-lock" style="font-size: 43px;"></i>
							</label>
							<div class="col-sm-11">
								<input type="password" class="form-control input-lg" placeholder="Password" name="password" id="password" required />
							</div>
							<br/>
							<br/>
							<br/>
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<a class="btn" class="col-md4" href="<?php echo base_url('admin/reset_password'); ?>">Mot de passe oublié</a>	
									<input type="submit" value="Login" class="col-md-4 btn btn-lg btn-primary" />
								</div>
							</div>
							<br/>
						</div>
					</form>

				</div><!-- end .main content -->
			</div><!-- end .row -->
			<p class="text-center">
				<a class="btn" href="<?php echo base_url(); ?>">Retourner sur le site</a>
			</p>
		</div> <!-- end .container -->

	<?php 
		echo js_url('jquery.min');
		echo js_url('bootstrap.min'); 
	?>

	</body>

</html>
