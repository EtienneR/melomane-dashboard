<?php if ($query->num_rows() > 0): ?>
<div class="table-responsive">
	<table class="table table-hover tablesorter" id="keywords">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Nb articles</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query->result() as $row): ?>
			<tr>
				<td>
					<?php echo $row->id_tag; ?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/tag/edit/' . $row->id_tag); ?>" title="Modifier">
						<?php echo $row->name_tag; ?>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/content/t?q=' . $row->name_tag); ?>">
						<?php echo ($this->model_content->get_content_by_tag($row->id_tag)->num_rows); ?>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/tag/edit/' . $row->id_tag); ?>" title="Modifier">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/tag/delete/' . $row->id_tag); ?>" onclick="return deleteConfirm()" title="Supprimer">
						<i class="glyphicon glyphicon-trash"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table><!-- end .table .table-hover -->
</div><!-- end .table-responsive -->

<p class="text-right">
	<em><?php echo $query->num_rows(); ?> tag(s)</em>
</p>

<script>
	function deleteConfirm() {
		var a = confirm("Etes-vous sur de vouloir supprimer cet tag ?!");
		if (a){
			return true;
		}
		else{
			return false;
		}
	}
</script>

<?php else: ?>
	<p>Aucun tag créé</p>
<?php endif; ?>