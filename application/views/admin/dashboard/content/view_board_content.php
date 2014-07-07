<?php if ($query->num_rows() > 0): ?>
<div class="table-responsive">
	<table class="table table-hover tablesorter" id="keywords">
		<thead>
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Auteur</th>
				<th>Catégorie</th>
				<th>Tags</th>
				<?php if ($page == 'home' or $page == 'artists'): ?>
				<th>Posteur</th>
				<?php endif; ?>
				<th>Date</th>
				<th>MAJ</th>
				<th>Etat</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query->result() as $row): ?>
			<tr>
				<td>
					<?php echo $row->id_song; ?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/edit/' . $row->id_song); ?>" title="Modifier"><?php echo $row->title_song; ?></a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/a?q=' . $row->artist_song); ?>" title="Afficher toutes les musiques de cette auteur"><?php echo $row->artist_song; ?>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/c?q=' . $row->title_category); ?>
					" title="Afficher toutes les musiques de cette catégorie">
					<?php echo $row->title_category; ?>
					</a>
				</td>
				<?php 
					if (!empty($row->tag_song)):
						$tags = explode(';', $row->tag_song);
						echo '<td>';
						foreach ($tags as $tag):
							if (!empty($tag)):
								echo '<a href="'.base_url('admin/content').'/t?q=' . $tag . '" title="Afficher toutes les musiques avec ce tag">'. $tag . '</a> ';
							endif;
						endforeach;
						echo '</td>';
					endif;
				?>
				<?php if ($page == 'home' or $page == 'artists'): ?>
				<td>
					<?php echo $row->pseudo_user; ?>
				</td>
				<?php endif; ?>
				<td>
					<?php echo date("d/m/Y à H:i:s", strtotime($row->cdate_song)); ?>
				</td>
				<?php if ($row->cdate_song !== $row->udate_song): ?>
				<td>
					<?php echo date("d/m/Y à H:i:s", strtotime($row->udate_song)); ?>
				</td>
				<?php else: ?>
				<td class="text-center">-</td>
				<?php endif; ?>
				<td>
				<?php 
				switch ($row->state_song) {
					case '0':
						echo 'Brouillon';
						break;

					case '1':
						echo 'Publié';
						break;
					
					default:
						echo 'Error';
						break;
				}
				?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/edit/' . $row->id_song); ?>" title="Modifier">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/delete/' . $row->id_song); ?>" onclick="return deleteConfirm()" title="Supprimer">
						<i class="glyphicon glyphicon-trash"></i>
					</a>
				</td>
			</tr>

			<?php endforeach; ?>
		</tbody>
	</table><!-- end .table .table-hover -->
	
	<p class="text-right">
		<em><?php echo $query->num_rows(); ?> musique(s)</em>
	</p>

<?php else: ?>
<p>Aucun résultat</p>
<?php endif; ?>