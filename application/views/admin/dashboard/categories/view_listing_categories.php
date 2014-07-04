<?php if ($query->num_rows() > 0): ?>
<div class="table-responsive">
	<table class="table table-hover tablesorter" id="keywords">
		<thead>
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Description</th>
				<th>Nb articles</th>
				<th>Date de création</th>
				<th>Date de modification</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query->result() as $row): ?>
			<tr>
				<td>
					<?php echo $row->id_category; ?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/category/edit/' . $row->id_category); ?>" title="Modifier">
						<?php echo $row->title_category; ?>
					</a>
				</td>
				<td>
					<?php echo character_limiter($row->description_category, 64); ?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/c?q=' . $row->title_category); ?>">
						<?php echo ($this->model_content->get_content_by_category($row->id_category)->num_rows); ?>
					</a>
				</td>
				<td>
					<?php echo date("d/m/Y à H:i:s", strtotime($row->cdate_category)); ?>
				</td>
				<?php if ($row->cdate_category !== $row->udate_category): ?>
				<td>
					<?php echo date("d/m/Y à H:i:s", strtotime($row->udate_category)); ?>
				</td>
				<?php else: ?>
					<td class="text-center">-</td>
				<?php endif; ?>
				<td>
					<a href="<?php echo base_url('admin/category/edit/' . $row->id_category); ?>" title="Modifier">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/category/delete/' . $row->id_category); ?>" onclick="return deleteConfirm()" title="Supprimer">
						<i class="glyphicon glyphicon-trash"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table><!-- end .table .table-hover -->
</div><!-- end .table-responsive -->

<p class="text-right">
	<em><?php echo $query->num_rows(); ?> catégorie(s)</em>
</p>

<script>
	function deleteConfirm() {
		var a = confirm("Etes-vous sur de vouloir supprimer cette catégorie ?!");
		if (a){
			return true;
		}
		else{
			return false;
		}
	}
</script>

<?php else: ?>
	<p>Aucune catégorie créée</p>
<?php endif; ?>