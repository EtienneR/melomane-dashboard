<?php if ($query->num_rows() > 0): ?>
<div class="table-responsive">
	<table class="table table-hover tablesorter" id="keywords">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Statut</th>
				<th>Email</th>
				<th>Musiques ajoutées</th>
				<th>News ajoutées</th>
				<th>Nombre de playlist</th>
				<?php if ($user_data['level'] == 0): ?>
				<th></th>
				<th></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query->result() as $row): ?>
			<tr>
				<td><?php echo $row->id_user; ?></td>
				<td>
					<a href="<?php echo base_url('admin/user/edit/' . $row->id_user); ?>" title="Modifier">
						<?php echo $row->pseudo_user; ?>
					</a>
				</td>
				<td>
					<?php switch ($row->level_user) {
						case 0:
							echo 'Administrateur';
							break;
						
						case 1:
							echo 'Modérateur';
							break;

						default:
							break;
					}
					?>
				</td>
				<td>
					<?php echo $row->email_user; ?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/user/' . $row->id_user); ?>" title="Tous les articles de cet auteur">
						<?php echo ($this->model_content->get_content_by_user($row->id_user, '')->num_rows); ?>
					</a>
				</td>
				<td>
					<?php echo $this->model_user->get_news_by_user($row->id_user)->num_rows(); ?>
				</td>
				<td>
					<?php echo $this->model_user->get_distinct_playlist_by_user($row->id_user)->num_rows(); ?>
				</td>
				<?php if ($user_data['level'] == 0): ?>
				<td>
					<a href="<?php echo base_url('admin/user/edit/' . $row->id_user); ?>" title="Modifier">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/user/delete/' . $row->id_user); ?>" onclick="return deleteConfirm()" title="Supprimer">
						<i class="glyphicon glyphicon-trash"></i>
					</a>
				</td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table><!-- end .table .table-hover -->
</div><!-- end .table-responsive -->

<p class="text-right"><em><?php echo $query->num_rows(); ?> utilisateur(s)</em></p>

<script>
	function deleteConfirm() {
		var a = confirm("Etes-vous sur de vouloir supprimer cet utilisateur ?!");
		if (a){
			return true;
		}
		else{
			return false;
		}
	}
</script>

<?php else: ?>
	<p>Aucun utilisateur</p>
<?php endif; ?>