<div class="page-header">
	<h3>Transaksi Sewa Selesai</h3>
</div>
<?php foreach($penyewaan as $p){ ?>
<form action="<?php echo base_url().'admin/transaksi_selesai_act' ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $p->id_sewa ?>">
	<input type="hidden" name="kamar" value="<?php echo $p->id_kamar ?>">
	<input type="hidden" name="tgl_cekout" value="<?php echo $p->tgl_checkout ?>">
	<input type="hidden" name="tgl_cekin" value="<?php echo $p->tgl_checkin ?>">
	<input type="hidden" name="extend" value="<?php echo $p->extend ?>">
	<div class="form-group">
		<label>Nama Pengunjung</label>
		<select class="form-control" name="pengunjung" disabled>
			<option value="">-Pilih Nama Pengunjung-</option>
			<?php foreach($pengunjung as $k){ ?>
				<option <?php if($p->id_pengunjung == $k->id_pengunjung){echo "selected='selected'";} ?> value="<?php echo $k->id_pengunjung; ?>"><?php echo $k->nama_pengunjung; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="form-group">
		<label>Nama Kamar</label>
		<select class="form-control" name="kamar" disabled>
			<option value="">-Pilih Nama Kamar-</option>
			<?php foreach($kamar as $m){ ?>
			<option <?php if($p->id_kamar == $m->id_kamar){echo "selected='selected'";} ?> value="<?php echo $m->id_kamar; ?>"><?php echo $m->nama_kamar; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="form-group">
		<label>Tanggal Check-in</label>
		<input class="form-control" type="date" name="tgl_checkin" value="<?php echo $p->tgl_checkin ?>" disabled>
	</div>

	<div class="form-group">
		<label>Tanggal Check-out</label>
		<input class="form-control" type="date" name="tgl_checkout" value="<?php echo $p->tgl_checkout ?>" disabled>
	</div>

	<div class="form-group">
		<label>Harga Sewa Kamar per Hari</label>
			<input class="form-control" type="text" name="total_extend" value="<?php echo $p->extend ?>" disabled>
	</div>
	<div class="form-group">
		<input type="submit" value="Simpan" class="btn btnprimary btn-sm">
	</div>
</form>
<?php } ?>