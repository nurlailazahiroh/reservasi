<div class="page-header">
	<h3>Data Pengunjung</h3>
</div>
<a href="<?php echo base_url().'admin/tambah_pengunjung'; ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Pengunjung Baru</a>
<br/><br/>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover" id="table-datatable">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Pengunjung</th>
				<th>Jenis Kelamin</th>
				<th>No. Telp</th>
				<th>Alamat</th>
				<th>Email</th>
				<th>Ubah/Hapus</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no = 1;
				foreach($pengunjung as $pel){
			?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $pel->nama_pengunjung ?></td>
				<td><?php echo $pel->jenis_kelamin ?></td>
				<td><?php echo $pel->no_telp ?></td>
				<td><?php echo $pel->alamat ?></td>
				<td><?php echo $pel->email ?></td>
				<td nowrap="nowrap" align="center">
					<a class="btn btn-primary btn-sm" href="<?php echo base_url().'admin/edit_pengunjung/'.$pel->id_pengunjung; ?>"><span class="glyphicon glyphicon-pencil"> </span></a>
					<a class="btn btn-warning btn-sm" href="<?php echo base_url().'admin/hapus_pengunjung/'.$pel->id_pengunjung; ?>"><span class="glyphicon glyphicon-remove"></span></a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>