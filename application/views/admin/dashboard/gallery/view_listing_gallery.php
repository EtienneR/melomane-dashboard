<?php if ($query->num_rows() > 0): ?>
<div class="table-responsive">
	<table class="table table-hover tablesorter" id="keywords">
		<thead>
			<tr>
				<th>ID</th>
				<th>Image</th>
				<th>Nb articles</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query->result() as $row): ?>
			<tr>
				<td>
					<?php echo $row->id_bg; ?>
				</td>
				<td>
					<?php echo img_thumb_bg($row->image_bg); ?>
				</td>
				<td>
					<?php echo ($this->model_content->get_content_by_bg($row->id_bg)->num_rows); ?>
				</td>
				<td>
					<a href="<?php echo base_url('admin/medias/edit/' . $row->id_bg); ?>" title="Modifier">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="<?php echo base_url('admin/medias/delete/' . $row->id_bg); ?>" onclick="return deleteConfirm()" title="Supprimer">
						<i class="glyphicon glyphicon-trash"></i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table><!-- end .table .table-hover -->
</div><!-- end .table-responsive -->

<p class="text-right">
	<em><?php echo $query->num_rows(); ?> background(s)</em>
</p>

<script>
	function deleteConfirm() {
		var a = confirm("Etes-vous sur de vouloir supprimer ce background ?!");
		if (a){
			return true;
		}
		else{
			return false;
		}
	}
</script>

<?php else: ?>
	<p>Aucun background créé</p>
<?php endif; ?>