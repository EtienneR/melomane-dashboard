		<?php if ($query->num_rows() > 0): ?>
		<div class="table-responsive">
			<table class="table table-hover tablesorter" id="keywords">
				<thead>
					<tr>
						<th>ID</th>
						<th>Auteur</th>
						<th>Titre</th>
						<th>Contenu</th>
						<th>Date de création</th>
						<th>Date de modification</th>
						<th>Etat</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($query->result() as $row): ?>
					<tr>
						<td>
							<?php echo $row->id_news; ?>
						</td>
						<td>
							<?php echo $row->pseudo_user; ?>
						</td>
						<td>
							<a href="<?php echo base_url('admin/news/edit/' . $row->id_news); ?>" title="Modifier">
								<?php echo $row->title_news; ?>
							</a>
						</td>
						<td>
							<?php echo character_limiter(strip_tags($row->content_news, 64)); ?>
						</td>
						<td>
							<?php echo date("d/m/Y à H:i:s", strtotime($row->cdate_news)); ?>
						</td>
						<?php if ($row->cdate_news !== $row->udate_news): ?>
						<td>
							<?php echo date("d/m/Y à H:i:s", strtotime($row->udate_news)); ?>
						</td>
						<?php else: ?>
						<td class="text-center">-</td>
						<?php endif; ?>
						<td>
							<?php 
							switch ($row->state_news) {
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
							<a href="<?php echo base_url('admin/news/edit/' . $row->id_news); ?>" title="Modifier">
								<i class="glyphicon glyphicon-pencil"></i>
							</a>
						</td>
						<td>
							<a href="<?php echo base_url('admin/news/delete/' . $row->id_news); ?>" onclick="return deleteConfirm()" title="Supprimer">
								<i class="glyphicon glyphicon-trash"></i>
							</a>
						</td>
						<td>
							<a href="<?php echo base_url('admin/news/preview/' . $row->id_news); ?>" title="Preview" target="_blank">
								<i class="glyphicon glyphicon-eye-open"></i>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table><!-- end .table .table-hover -->
		</div><!-- end .table-responsive -->

		<p class="text-right">
			<em><?php echo $query->num_rows(); ?> news</em>
		</p>

		<script>
			function deleteConfirm() {
				var a = confirm("Etes-vous sur de vouloir supprimer cette news ?!");
				if (a){
					return true;
				}
				else{
					return false;
				}
			}
		</script>

		<?php else: ?>
			<p>Aucune news créée</p>
		<?php endif; ?>