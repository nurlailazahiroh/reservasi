<?php
defined('BASEPATH') or exit ('NO Direct Script Access Allowed');

class Admin extends CI_Controller{
	function __construct(){
		parent::__construct();
		// cek login
		if($this->session->userdata('status') != "login"){
			$alert=$this->session->set_flashdata('alert', 'Silahkan Login Dahulu');
			redirect(base_url());
		}
	}

	function index(){
		$data['penyewaan'] = $this->db->query("select * from transaksi order by id_sewa desc limit 10")->result();
		$data['pengunjung'] = $this->db->query("select * from pengunjung order by id_pengunjung desc limit 10")->result();
		$data['kamar'] = $this->db->query("select * from kamar order by id_kamar desc limit 10")->result();

		$this->load->view('admin/header');
		$this->load->view('admin/index',$data);
		$this->load->view('admin/footer');
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'welcome?pesan=logout');
	}

	function ganti_password(){
		$this->load->view('admin/header');
		$this->load->view('admin/ganti_password');
		$this->load->view('admin/footer');
	}

	function ganti_password_act(){
		$pass_baru = $this->input->post('pass_baru');
		$ulang_pass = $this->input->post('ulang_pass');

		$this->form_validation->set_rules('pass_baru','Password Baru','required|matches[ulang_pass]');
		$this->form_validation->set_rules('ulang_pass','Ulangi Password Baru','required');
		if($this->form_validation->run() != false){
			$data = array('password' => md5($pass_baru));
			$w = array('id_admin' => $this->session->userdata('id'));
			$this->m_hotel->update_data($w,$data,'admin');
			redirect(base_url().'admin/ganti_password?pesan=berhasil');
		}else{
			$this->load->view('admin/header');
			$this->load->view('admin/ganti_password');
			$this->load->view('admin/footer');
		}
	}

	function kamar(){
		$data['kamar'] = $this->m_hotel->get_data('kamar')->result();
		$this->load->view('admin/header');
		$this->load->view('admin/datakamar',$data);
		$this->load->view('admin/footer');
	}

	function tambah_kamar(){
		//memuat data tipekamar untuk ditampilkan di select form
		$data['tipekamar'] =$this->m_hotel->get_data('tipekamar')->result();

		$this->load->view('admin/header');
		$this->load->view('admin/tambahkamar',$data);
		$this->load->view('admin/footer');
	}

	function tambah_kamar_act(){
		$tgl_input = date('dd-mm-Y');
		$id_tipekamar = $this->input->post('id_tipe');
		$kamar = $this->input->post('nama_kamar');
		$nokamar = $this->input->post('no_kamar');
		$kasur = $this->input->post('tipe_kasur');
		$harga_kamar = $this->input->post('harga_kamar');
		$lokasi = $this->input->post('lokasi');
		$status = $this->input->post('status_kamar');
		$this->form_validation->set_rules('id_tipe','Tipe Kamar','required');
		$this->form_validation->set_rules('nama_kamar','Nama Kamar','required');
		$this->form_validation->set_rules('status_kamar','Status Kamar','required');
		if($this->form_validation->run() != false){
			//configurasi upload gambar
			$config['upload_path'] = './assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '2048';
			$config['file_name'] = 'gambar'.time();

			$this->load->library('upload', $config);

			if($this->upload->do_upload('fotokamar')){
				$image=$this->upload->data();

				$data = array(
					'id_tipe' =>$id_tipekamar,
					'nama_kamar' => $kamar,
					'no_kamar' => $nokamar,
					'tipe_kasur' => $kasur,
					'harga_kamar' => $harga_kamar,
					'lokasi' => $lokasi,
					'gambar' => $image['file_name'],
					'status_kamar' => $status
				);
		
				$this->m_hotel->insert_data($data,'kamar');
				redirect(base_url().'admin/kamar');
			}else{
				$this->session->set_flashdata('alert', 'Anda Belum Memilih Foto Kamar');
			}
		}else{
			$this->load->view('admin/header');
			$this->load->view('admin/tambahkamar');
			$this->load->view('admin/footer');
		}
	}

	function edit_kamar($id){
		$where = array('id_kamar' => $id);
		$data['kamar'] = $this->db->query("select * from kamar K, tipekamar T where K.id_tipe=T.id_tipe and K.id_kamar='$id'")->result();
		$data['tipekamar'] =$this->m_hotel->get_data('tipekamar')->result();
		//$data['kamar'] = $this->m_hotel->edit_data($where,'kamar')->result();
		$this->load->view('admin/header');
		$this->load->view('admin/editkamar',$data);
		$this->load->view('admin/footer');
	}

	function update_kamar(){
		$id = $this->input->post('id');
		$id_tipe = $this->input->post('id_tipe');
		$kamar = $this->input->post('nama_kamar');
		$nokamar = $this->input->post('no_kamar');
		$kasur = $this->input->post('tipe_kasur');
		$harga_kamar = $this->input->post('harga_kamar');
		$lokasi = $this->input->post('lokasi');
		$status = $this->input->post('status_kamar');
		$this->form_validation->set_rules('id_tipe', 'Tipe Kamar', 'required');
		$this->form_validation->set_rules('nama_kamar', 'Nama Kamar', 'required|min_length[4]');
		$this->form_validation->set_rules('no_kamar', 'Nomor Kamar', 'required|min_length[3]');
		$this->form_validation->set_rules('tipe_kasur', 'Tipe Kasur', 'required|min_length[5]');
		$this->form_validation->set_rules('harga_kamar', 'Harga Kamar', 'required');
		$this->form_validation->set_rules('lokasi', 'Lokasi kamar', 'required');
		$this->form_validation->set_rules('status_kamar', 'Status Kamar', 'required');

		if($this->form_validation->run() != false){
			$config['upload_path'] = './assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '2048';
			$config['file_name'] = 'gambar'.time();

			$this->load->library('upload', $config);

			$where = array('id_kamar' => $id);
			$data = array(
				'id_tipe' =>$id_tipe,
				'nama_kamar' => $kamar,
				'no_kamar' => $nokamar,
				'tipe_kasur' => $kasur,
				'harga_kamar' => $harga_kamar,
				'lokasi' => $lokasi,
				'status_kamar' => $status,
			);

			if($this->upload->do_upload('fotokamar')){
			    //proses upload gambar
			  $image = $this->upload->data();
			  unlink('assets/upload/'.$this->input->post('old_pict', TRUE));
		      $data['gambar'] = $image['file_name'];

			  $this->m_hotel->update_data($where, $data,'kamar');
			}else {
			  $this->m_hotel->update_data($where, $data,'kamar');
			}

			$this->m_hotel->update_data($where,$data,'kamar');
			redirect(base_url().'admin/kamar');
		}else{
			$where = array('id_kamar' => $id);
			$data['kamar'] = $this->db->query("select * from kamar K , tipekamar T where K.id_tipe=T.id_tipe and K.id_kamar='$id'")->result();
			$data['tipekamar'] =$this->m_hotel->get_data('tipekamar')->result();
			//$data['kamar'] = $this->m_hotel->edit_data($where,'kamar')->result();
			$this->load->view('admin/header');
			$this->load->view('admin/editkamar',$data);
			$this->load->view('admin/footer');
		}
	}

	function hapus_kamar($id){
		$where = array('id_kamar' => $id);
		$this->m_hotel->delete_data($where,'kamar');
		redirect(base_url().'admin/kamar');
	}

	function pengunjung(){
		$data['pengunjung'] = $this->m_hotel->get_data('pengunjung')->result();
		$this->load->view('admin/header');
		$this->load->view('admin/datapengunjung',$data);
		$this->load->view('admin/footer');
	}

	function tambah_pengunjung(){
		$this->load->view('admin/header');
		$this->load->view('admin/tambahpengunjung');
		$this->load->view('admin/footer');
	}

	function tambah_pengunjung_act(){
		$nama = $this->input->post('nama_pengunjung');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		$gender = $this->input->post('jenis_kelamin');
		$notelp = $this->input->post('notelp');
		$alamat = $this->input->post('alamat');
		$email = $this->input->post('email');
		
		$this->form_validation->set_rules('nama_pengunjung','Nama Pengunjung','required');
		$this->form_validation->set_rules('notelp','No Telepon','required');
		$this->form_validation->set_rules('email','Email','required');
		if($this->form_validation->run() != false){
			$data = array(
				'nama_pengunjung' => $nama,
				'password' => md5 ($password),
				'gender' => $gender,
				'no_telp' => $notelp,
				'alamat' => $alamat,
				'email' => $email
			);
		
			$this->m_hotel->insert_data($data,'pengunjung');
			redirect(base_url().'admin/pengunjung');
		}else{
			$this->load->view('admin/header');
			$this->load->view('admin/tambahpengunjung');
			$this->load->view('admin/footer');
		}
	}

	function edit_pengunjung($id){
		$where = array('id_pengunjung' => $id);
		$data['pengunjung'] = $this->m_hotel->edit_data($where,'pengunjung')->result();

		$this->load->view('admin/header');
		$this->load->view('admin/editpengunjung',$data);
		$this->load->view('admin/footer');
	}

	function update_pengunjung(){
		$id = $this->input->post('id');
		$nama = $this->input->post('nama_pengunjung');
		$gender = $this->input->post('gender');
		$notelp = $this->input->post('notelp');
		$alamat = $this->input->post('alamat');
		$email = $this->input->post('email');
		$this->form_validation->set_rules('nama_pengunjung','Nama Pelanggan','required');
		$this->form_validation->set_rules('gender','Jenis Kelamin','required');
		$this->form_validation->set_rules('notelp','No Telepon','numeric|required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('email','Email','required');
		if($this->form_validation->run() != false){
			$where = array('id_pengunjung' => $id);
			$data = array(
				'nama_pengunjung' => $nama,
				'gender' => $gender,
				'no_telp' => $notelp,
				'alamat' => $alamat,
				'email' => $email
			);
			$this->m_hotel->update_data($where,$data,'pengunjung');
			redirect(base_url().'admin/pengunjung');
		}else{
			$where = array('id_pengunjung' => $id);
			$data['kamar'] = $this->m_hotel->edit_data($where,'pengunjung')->result();
			$this->load->view('admin/header');
			$this->load->view('admin/editpengunjung',$data);
			$this->load->view('admin/footer');
		}
	}

	function hapus_pengunjung($id){
		$where = array('id_pengunjung' => $id);
		$this->m_hotel->delete_data($where,'pengunjung');
		redirect(base_url().'admin/pengunjung');
	}

	function penyewaan(){

		$data['penyewaan'] = $this->db->query("SELECT * FROM transaksi T, kamar K, pengunjung P WHERE T.id_kamar=K.id_kamar and T.id_pengunjung=P.id_pengunjung")->result();
		
		$this->load->view('admin/header');
		$this->load->view('admin/penyewaan',$data);
		$this->load->view('admin/footer');
	}

	function tambah_penyewaan(){
		$w = array('status_kamar'=>'1');
		$data['kamar'] = $this->m_hotel->edit_data($w,'kamar')->result();
		$data['pengunjung'] = $this->m_hotel->get_data('pengunjung')->result();
		$data['penyewaan'] = $this->m_hotel->get_data('transaksi')->result();

		$this->load->view('admin/header');
		$this->load->view('admin/tambahpenyewaan',$data);
		$this->load->view('admin/footer');
	}

	function tambah_penyewaan_act(){
		
		$tgl_bayar = date('Y-m-d H:i:s');
		$pengunjung = $this->input->post('pengunjung');
		$kamar = $this->input->post('kamar');
		$tgl_checkin = $this->input->post('tgl_checkin');
		$tgl_checkout = $this->input->post('tgl_checkout');
		$total_extend = $this->input->post('total_extend');
		
		$this->form_validation->set_rules('pengunjung','Nama Pengunjung','required');
		$this->form_validation->set_rules('kamar','Nama Kamar','required');
		$this->form_validation->set_rules('tgl_checkin','Tanggal Check-in','required');
		$this->form_validation->set_rules('tgl_checkout','Tanggal Check-out','required');
		$this->form_validation->set_rules('total_extend','Harga Extend','required');

		if($this->form_validation->run() != false){
			$data = array(
			'tgl_bayar' => $tgl_bayar,
			'id_pengunjung' => $pengunjung,
			'id_kamar' => $kamar,
			'tgl_checkin' => $tgl_checkin,
			'tgl_checkout' => $tgl_checkout,
			'total_extend' => '0',
			'status_sewa' => '0',
			'status_bayar' => '0'
			);

			$this->m_hotel->insert_data($data,'transaksi');
			
			// update status kamar yg di sewa
			$d = array('status_kamar' => '0', 'tgl_input' => substr($tgl_bayar, 0, 10));
			$w = array('id_kamar' => $kamar);
			$this->m_hotel->update_data($w,$d,'kamar');
			
			redirect(base_url().'admin/penyewaan');
		}else{
			$w = array('status_kamar'=>'1');
			$data['kamar'] = $this->m_hotel->edit_data($w,'kamar')->result();
			$data['pengunjung'] = $this->m_hotel->get_data('pengunjung')->result();

			$this->load->view('admin/header');
			$this->load->view('admin/tambahpenyewaan',$data);
			$this->load->view('admin/footer');
		}
	}

	function hapus_penyewaan($id){
		$w = array('id_sewa' => $id);
		$data = $this->m_hotel->edit_data($w,'transaksi')->row();
		//$data = $this->m_hotel->edit_data($w,'penyewaan')->row();
		$ww = array('id_kamar' => $data->id_kamar);
		$data2 = array('status_kamar' => '1');
		$this->m_hotel->update_data($ww,$data2,'kamar');
		$this->m_hotel->delete_data($w,'transaksi');
		redirect(base_url().'admin/penyewaan');
	}

	function transaksi_selesai($id){
		$data['kamar'] = $this->m_hotel->get_data('kamar')->result();
		$data['pengunjung'] = $this->m_hotel->get_data('pengunjung')->result();
		$data['penyewaan'] = $this->db->query("select * from transaksi t, pengunjung p, kamar k  where t.id_kamar = k.id_kamar and t.id_pengunjung=p.id_pengunjung and t.id_sewa='$id'")->result();

		$this->load->view('admin/header');
		$this->load->view('admin/transaksi_selesai',$data);
		$this->load->view('admin/footer');
	}

	function transaksi_selesai_act(){
		$id = $this->input->post('id');
		$tgl_checkout = $this->input->post('tgl_checkout');
		$tgl_checkin = $this->input->post('tgl_checkin');
		$kamar = $this->input->post('kamar');
		$harga_kamar = $this->input->post('harga_kamar');
		if($this->form_validation->run() != false){
			// menghitung selisih hari 
			$awal_checkin = strtotime($tgl_checkin);
			$akhir_checkout = strtotime($tgl_checkout);
			$selisih = abs(($awal_checkin - $akhir_checkout)/(60*60*24));
			$total_bayar = $harga_kamar*$selisih;
			// update status penyewaan
			$data = array('status_bayar' => '1', 'total_extend' => $total_bayar,'tgl_checkout' => $tgl_checkout,'status_sewa' => '1');
			//$data3 = array();
			$w = array('id_sewa' => $id);
			$this->m_hotel->update_data($w,$data,'transaksi');
			//$this->m_hotel->update_data($w,$data3,'detail_sewa');
			// update status kamar
			$data2 = array('status_kamar' => '1');
			$w2 = array('id_kamar' => $kamar);
			$this->m_hotel->update_data($w2,$data2,'kamar');
			redirect(base_url().'admin/penyewaan');
		}
		else{
			$data['kamar'] = $this->m_hotel->get_data('kamar')->result();
			$data['pengunjung'] = $this->m_hotel->get_data('pengunjung')->result();
			$data['penyewaan'] = $this->db->query("select * from penyewaan p, pengunjung a, detail_sewa d, kamar k  where p.id_pengunjung = a.id_pengunjung and p.id_sewa = d.id_sewa and d.id_kamar = k.id_kamar and p.id_sewa='$id'")->result();
			
			$this->load->view('admin/header');
			$this->load->view('admin/transaksi_selesai',$data);
			$this->load->view('admin/footer');
		}
	}
}