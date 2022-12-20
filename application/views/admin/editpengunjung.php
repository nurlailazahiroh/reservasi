<div class="page-header">
	<h3>Edit Data Pengunjung</h3>
</div>
<?php foreach($pengunjung as $p){ ?>
<form action="<?php echo base_url().'admin/update_pengunjung' ?>" method="post">
	<div class="form-group">
		<label>Nama Pengunjung</label>
		<input type="hidden" name="id" value="<?php echo $p->id_pengunjung; ?>">
		<input class="form-control" type="text" name="nama_pengunjung" value="<?php echo $p->nama_pengunjung; ?>">
		<?php echo form_error('nama_pengunjung'); ?>
	</div>

	<div class="form-group">
		<label>Jenis Kelamin</label>
		<input class="form-control" type="text" name="jenis_kelamin" value="<?php echo $p->jenis_kelamin; ?>">
		<?php echo form_error('jenis_kelamin'); ?>
	</div>

	<div class="form-group">
		<label>No Telepon</label>
		<input class="form-control" type="text" name="notelp" value="<?php echo $p->no_telp; ?>">
		<?php echo form_error('notelp'); ?>
	</div>

	<div class="form-group">
		<label>Alamat</label>
		<input class="form-control" type="text" name="alamat" value="<?php echo $p->alamat; ?>">
		<?php echo form_error('alamat'); ?>
	</div>

	<div class="form-group">
		<label>Email</label>
		<input class="form-control" type="text" name="email" value="<?php echo $p->email; ?>" >
		<?php echo form_error('email'); ?>
	</div>

	<div class="form-group">
		<input type="submit" value="Simpan" class="btn btnprimary">
	</div>
</form>
<?php } ?>