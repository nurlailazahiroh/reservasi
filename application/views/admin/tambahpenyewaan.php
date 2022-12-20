<div class="page-header">
	<h3>Transaksi Sewa Baru</h3>
</div>
<?php foreach ($penyewaan as $key) { ?>
<form action="<?php echo base_url().'admin/tambah_penyewaan_act/' ?>" method="post">
	<?php
		$id = $key->id_sewa+1;
	?>
		<input type="hidden" name="id" value="<?php echo $id ?>">
	<?php } ?>
	<div class="form-group">
		<label>Nama Pengunjung</label>
		<select name="pengunjung" class="form-control">
			<option value="">-Pilih Nama Pengunjung-</option>
			<?php foreach($pengunjung as $pel){ ?>
			<option value="<?php echo $pel->id_pengunjung; ?>"><?php echo $pel->nama_pengunjung; ?></option>
			<?php } ?>
		</select>
		<?php echo form_error('pengunjung'); ?>
	</div>

	<div class="form-group">
		<label>Nama Kamar</label>
		<select name="kamar" class="form-control">
			<option value="">-Pilih Nama Kamar-</option>
			<?php foreach($kamar as $k){ ?>
			<option value="<?php echo $k->id_kamar; ?>"><?php echo $k->nama_kamar; ?></option>
			<?php } ?>
		</select>
		<?php echo form_error('kamar'); ?>
	</div>

	<div class="form-group">
		<label>Tanggal Check-in</label>
		<input type="date" name="tgl_checkin" class="form-control">
		<?php echo form_error('tgl_cekin'); ?>
	</div>

	<div class="form-group">
		<label>Tanggal Check-out</label>
		<input type="date" name="tgl_checkout" class="form-control">
		<?php echo form_error('tgl_checkout'); ?>
	</div>

	<div class="form-group">
		<label>Harga Sewa Kamar per Hari</label>
		<input type="text" name="total_extend" class="form-control">
		<?php echo form_error('total_extend'); ?>
	</div>

	<div class="form-group">
		<input type="submit" value="Simpan" class="btn btnprimary btn-sm">
	</div>
</form>