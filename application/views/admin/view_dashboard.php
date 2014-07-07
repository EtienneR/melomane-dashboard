<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title><?php echo strip_tags($title); ?> - Dashboard - Mélomane</title>
		<meta name="description" content="<?php echo $title ; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php echo css_url('bootstrap.min'); ?>
		<?php
			if ($page == 'add_content' or $page == 'edit_content' or $page =='add_news' or $page == 'edit_news'):
				echo css_url('toggle-switch');
			endif;
			if ($page =='add_news' or $page == 'edit_news'):
				echo css_url('redactor');
			endif;
		?>
	</head>

	<body class="container-fluid">

		<nav class="navbar navbar-default" role="navigation">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button><!-- end .navbar-toggle -->
				<a class="navbar-brand" href="<?php echo base_url('admin/content'); ?>">Dashboard</a>
			</div><!-- end .navbar-header -->

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php if ($page == 'home' or $page == 'tags' or $page == 'artists' or $page == 'add_content' or $page == 'edit_content' or $page == 'author'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/content'); ?>" class="dropdown-toggle">Musiques</a>
					</li>
					<li <?php if ($page == 'news' or $page == 'add_news' or $page == 'edit_news'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/news'); ?>">News</a>
					</li>
					<li <?php if ($page == 'categories' or $page == 'add_category' or $page == 'edit_category'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/category'); ?>">Catégories</a>
					</li>
					<li <?php if ($page == 'tag' or $page == 'add_tag' or $page == 'edit_tag'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/tag'); ?>">Tags</a>
					</li>
					<li <?php if ($page == 'users' or $page == 'add_user' or $page == 'edit_user'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/user'); ?>">Utilisateurs</a>
					</li>
					<li <?php if ($page == 'stats'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/stats'); ?>">Statistiques</a>
					</li>
					<li <?php if ($page == 'gallery' or $page == 'add_bg' or $page == 'edit_bg'){ echo "class='active'"; }; ?>>
						<a href="<?php echo base_url('admin/medias'); ?>">Galerie</a>
					</li>
				</ul><!-- end .nav navbar-nav -->
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo base_url(); ?>" target="_blank">Le site</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user_data['login']; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo base_url('admin/user/change_password'); ?>">
									<i class="glyphicon glyphicon-user"></i> Changer mot de passe
								</a>
							</li>
							<li>
								<a href="<?php echo base_url('admin/logout'); ?>">
									<i class="glyphicon glyphicon-off"></i> Se déconnecter
								</a>
							</li>
						</ul><!-- end .dropdown-menu -->
					</li><!-- end .dropdown -->
				</ul><!-- end .nav .navbar-nav .navbar-right -->
			</div><!-- end .collapse .navbar-collapse #bs-example-navbar-collapse-1 -->

		</nav><!-- end .navbar .navbar-default -->

		<div class="row-fluid">

			<section class="col-md-2">
				<div class="btn-group-vertical">
					<button onClick="window.location.href='<?php echo base_url('admin/content/edit'); ?>'" class="btn btn-danger">
						<i class="glyphicon glyphicon-plus"></i> Ajouter une musique
					</button>
					<button onClick="window.location.href='<?php echo base_url('admin/news/edit'); ?>'" class="btn btn-success">
						<i class="glyphicon glyphicon-plus"></i> Ajouter une news
					</button>
					<?php if ($user_data['level'] == 0): ?>
					<button onClick="window.location.href='<?php echo base_url('admin/user/edit'); ?>'" class="btn btn-primary">
						<i class="glyphicon glyphicon-plus"></i> Ajouter un utilisateur
					</button>
					<?php endif; ?>
					<button onClick="window.location.href='<?php echo base_url('admin/medias/edit'); ?>'" class="btn btn">
						<i class="glyphicon glyphicon-plus"></i> Ajouter un background
					</button>
					<?php if ($page == 'tags' or $page == 'artists'): ?>
					<button onClick="window.location.href='<?php echo base_url('admin/content'); ?>'" class="btn btn-link">
						Toutes les musiques
					</button>
					<?php endif; ?>

					<?php if (current_url() !== base_url('admin/user/' . $user_data['id_user'])): ?>
					<button onClick="window.location.href='<?php echo base_url('admin/user/' . $user_data['id_user']); ?>'" class="btn btn-link">
						Mes musiques (<?php echo ($this->model_content->get_content_by_user($user_data['id_user'], '')->num_rows); ?>)
					</button>
					Mes news
					<?php else: ?>
					<button onClick="window.location.href='<?php echo base_url('admin/content'); ?>'" class="btn btn-link">
						Toutes les musiques
					</button>
					<?php endif; ?>
				</div>
				<?php if (!empty($categories) && $categories->num_rows() > 0): ?>
				<p>
					<br /><i class="glyphicon glyphicon-tag"></i> Catégories (<?php echo $categories->num_rows(); ?>)
					<a href="<?php echo base_url('admin/category/edit'); ?>" title="Ajouter un tag">
						<i class="glyphicon glyphicon-plus"></i>
					</a>
				</p>
				<ul class="list-unstyled">

				<?php foreach ($categories->result() as $category): ?>
					<li>
						<a href="<?php echo base_url('admin/content/c?q=' . $category->title_category); ?>">
							<?php echo $category->title_category; ?>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
				<?php endif; ?>

				<?php if (!empty($tags) && $tags->num_rows() > 0): ?>
					<p>
						<br /><i class="glyphicon glyphicon-tags"></i> Tags (<?php echo $tags->num_rows(); ?>)
						<a href="<?php echo base_url('admin/tag/edit'); ?>" title="Ajouter un tag">
							<i class="glyphicon glyphicon-plus"></i>
						</a>
					</p>
					<ul class="list-unstyled">
					<?php foreach ($tags->result() as $tag): ?>
						<?php if (!empty($tag)): ?>
						<li>
							<?php echo '<a href="' . base_url('admin/content') . '/t?q=' . $tag->id_tag . ' ">'. $tag->name_tag . '</a> '; ?>
						</li>
						<?php endif; ?>
					<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<p><a href="<?php echo base_url('admin/tag/edit'); ?>">Ajouter un tag</a>
				<?php endif; ?>

			</section>

		<div class="col-md-10">

		<?php if (validation_errors()): ?>
			<?php echo validation_errors('<div class="alert alert-danger">', ' <a class="close" data-dismiss="alert" href="#">&times;</a></div>'); ?>
		<?php endif; ?>

		<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success">
			<?php echo $this->session->flashdata('success'); ?> <a class="close" data-dismiss="alert" href="#">&times;</a>
		</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('alert')): ?>
		<div class="alert alert-danger">
			<?php echo $this->session->flashdata('alert'); ?> <a class="close" data-dismiss="alert" href="#">&times;</a>
		</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('warning')): ?>
		<div class="alert alert-warning">
			<?php echo $this->session->flashdata('warning'); ?> <a class="close" data-dismiss="alert" href="#">&times;</a>
		</div>
		<?php endif; ?>


		<h2 style="margin-top: 0px;"><?php echo $title; ?></h2> 

		<?php switch ($page) {
			case 'home':
			case 'author':
			case 'tags':
			case 'artists':
				$this->load->view('admin/dashboard/content/view_listing_content');
				break;

			case 'add_content':
			case 'edit_content':
				$this->load->view('admin/dashboard/content/view_edit_content');
				break;

			case 'news':
				$this->load->view('admin/dashboard/news/view_listing_news');
				break;

			case 'add_news':
			case 'edit_news':
				$this->load->view('admin/dashboard/news/view_edit_news');
				break;				

			case 'categories':
				$this->load->view('admin/dashboard/categories/view_listing_categories');
				break;

			case 'add_category':
			case 'edit_category':
				$this->load->view('admin/dashboard/categories/view_edit_category');
				break;

			case 'tag':
				$this->load->view('admin/dashboard/tags/view_listing_tags');
				break;

			case 'add_tag':
			case 'edit_tag':
				$this->load->view('admin/dashboard/tags/view_edit_tag');
				break;

			case 'users':
				$this->load->view('admin/dashboard/users/view_listing_users');
				break;

			case 'add_user':
			case 'edit_user':
				$this->load->view('admin/dashboard/users/view_edit_user');
				break;

			case 'stats':
				$this->load->view('admin/dashboard/stats/view_listing_stats');
				break;

			case 'change_password':
				$this->load->view('admin/dashboard/users/view_change_password');
				break;

			case 'gallery':
				$this->load->view('admin/dashboard/gallery/view_listing_gallery');
				break;

			case 'add_bg':
			case 'edit_bg':
				$this->load->view('admin/dashboard/gallery/view_edit_gallery');
				break;


			default:
				$this->load->view('admin/dashboard');
				break;
		}
		?>
		</div><!-- end .col-md-10 -->

	</div><!-- end .row --> 

	<footer>
		<footer data-role="footer">
			<p class="text-center">
				<small><br />Propulsé par Codeigniter &amp; made with <i class="glyphicon glyphicon-heart-empty"></i> from Paris - Temps d'exécution : <strong>{elapsed_time}</strong> secondes</small>
			</p>
		</footer>
	</footer>

	<?php
		echo js_url('jquery.min');
		echo js_url('bootstrap.min');
		echo js_url('jquery.tablesorter.min');
	?>
	<script>
	$(document).ready(function(){
		$("#keywords").tablesorter();
	});
	</script>

	<?php
		if ($page == 'add_content'):
		echo js_url('bootstrap-datepicker');
	?>

	<script>
		$('#datetimepicker input').datepicker({

	});
	</script>

	<?php
		endif;
		if ($page == 'add_news' || $page == 'edit_news'):
			echo js_url('redactor.min');
	?>

	<script>
		$(function()
		{
			$('#content_news').redactor();
		});
	</script>
	<script>
		$('.get-img').fadeOut(0);

		$('.show-img').css('cursor', 'pointer');
		$('.to_hide').css('cursor', 'pointer');

		$('.show-img').click(function() {
			$( ".get-img" ).fadeIn(0);
		});

		$('.to_hide').click(function() {
			$( ".get-img" ).fadeOut(0);
		});
	</script>
	<?php
		endif;
	?>

	</body>

</html>