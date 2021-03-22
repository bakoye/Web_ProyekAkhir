<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Freelance/M_freelance');
        $this->load->model('Perusahaan/M_perusahaan');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['nama'];
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/index', $data);
        $this->load->view('Freelance/footer');
    }
    public function Lihatlistfreelancer()
    {
        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        $data['freelancer'] = $this->M_freelance->tampil_user()->result();
        // echo 'Selamat datang ' . $data['user']['nama'];
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/lihatlistfreelancer', $data);
        $this->load->view('Freelance/footer');
    }
    public function hapus_freelance($id)
    {
        $where =  array('id_fre' => $id);
        $this->M_freelance->hapus_data($where, 'freelancer');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    		Akun sudah berhasil terhapus
    	  </div>');
        redirect('Admin/lihatlistfreelancer');
    }
    public function tambah_aksi()
    {
        $nama_lengkap           = $this->input->post('nama_lengkap');
        $alamat       = $this->input->post('alamat');
        $kota          = $this->input->post('kota');
        $provinsi       = $this->input->post('provinsi');
        $no_telp        = $this->input->post('no_telp');
        $jenis_kelamin        = $this->input->post('jenis_kelamin');
        $agama         = $this->input->post('agama');
        $image = $_FILES['image'];
        $config['upload_path']      = APPPATH . '../assets/img';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']    = '200000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('Admin/upload', $error);
        } else {
            $upload_data = $this->upload->data();

            $data['image'] = $upload_data['file_name'];

            $this->M_freelance->tambah2($data);
        }
        $data = array(
            'nama_lengkap'      => $nama_lengkap,
            'alamat'  => $alamat,
            'kota'     => $kota,
            'provinsi'  => $provinsi,
            'no_telp'   => $no_telp,
            'jenis_kelamin'   => $jenis_kelamin,
            'agama'   => $agama,

        );
        // $this->db->insert('user', $data);
        $this->M_freelance->tambah2($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Selamat anda sudah terdaftar sebagai user INFREELANCER,
		  </div>');
        redirect('Admin/lihatlistfreelancer');
    }
    public function Lihatlistperusahaan()
    {
        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        $data['perusahaan'] = $this->M_perusahaan->tampilin_user()->result();
        // echo 'Selamat datang ' . $data['user']['nama'];
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/lihatlistperusahaan', $data);
        $this->load->view('Freelance/footer');
    }
    public function hapus_perusahaan($id)
    {
        $where =  array('id' => $id);
        $this->M_perusahaan->hapus_data2($where, 'perusahaan');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    		Akun sudah berhasil terhapus
    	  </div>');
        redirect('Admin/lihatlistperusahaan');
    }
    public function tambah_aksii()
    {
        $nama_perusahaan           = $this->input->post('nama_perusahaan');
        $alamat       = $this->input->post('alamat');
        $kota          = $this->input->post('kota');
        $provinsi       = $this->input->post('provinsi');
        $bidang_perusahaan        = $this->input->post('bidang_perusahaan');
        $deskripsi         = $this->input->post('deskripsi');

        $data = array(
            'nama_perusahaan'      => $nama_perusahaan,
            'alamat'  => $alamat,
            'kota'     => $kota,
            'provinsi'  => $provinsi,
            'bidang_perusahaan'   => $bidang_perusahaan,
            'deskripsi'   => $deskripsi,
        );
        // $this->db->insert('user', $data);
        $this->M_perusahaan->tambah_data2($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Selamat anda sudah terdaftar sebagai user INFREELANCER,
		  </div>');
        redirect('Admin/lihatlistperusahaan');
    }
    public function detail($id_fre)
    {
        $this->load->model('M_freelance');
        $detail = $this->M_freelance->detail_data($id_fre);
        $data['detail'] = $detail;

        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        $data['freelancer'] = $this->M_freelance->tampil_user()->result();
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/detail_data', $data);
        $this->load->view('Freelance/footer');
    }
    public function detailin($id)
    {
        $this->load->model('M_freelance');
        $detail = $this->M_perusahaan->detail_data($id);
        $data['detail'] = $detail;

        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        $data['perusahaan'] = $this->M_freelance->tampil_user()->result();
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/detail', $data);
        $this->load->view('Freelance/footer');
    }
    public function buatproyek()
    {
        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['nama'];


        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/buat_proyek', $data);
        $this->load->view('Freelance/footer');
    }
    public function tambahproyek()
    {
        $nama_perusahaan    = $this->input->post('nama_perusahaan');
        $judul              = $this->input->post('judul');
        $kota               = $this->input->post('kota');
        $provinsi           = $this->input->post('provinsi');
        $alamat             = $this->input->post('alamat');
        $bidang_pekerjaan  = $this->input->post('bidang_pekerjaan');
        $deskripsi          = $this->input->post('deskripsi');
        $persyaratan        = $this->input->post('persyaratan');
        $gaji               = $this->input->post('gaji');

        $data = array(
            'nama_perusahaan' => $nama_perusahaan,
            'judul'           => $judul,
            'kota'            => $kota,
            'provinsi'        => $provinsi,
            'alamat'          => $alamat,
            'bidang_pekerjaan' => $bidang_pekerjaan,
            'deskripsi'       => $deskripsi,
            'persyaratan'     => $persyaratan,
            'gaji'            => $gaji,

        );
        $this->M_perusahaan->tambah_data($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Proyek anda sudah terdaftar
		  </div>');
        redirect('perusahaan/buatproyek');
    }
    public function carilowongan()
    {
        // $data['perusahaan'] = $this->M_perusahaan->tampil_data()->result();
        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        $data['buat_lowongan'] = $this->M_perusahaan->tampil_data()->result();
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/cari_lowongan', $data);
        $this->load->view('Freelance/footer');
    }
    public function upload()
    {
        $data['title'] = 'INFREELANCER| Dashboard';
        $data['user'] = $this->db->get_where('user', ['Email' =>
        $this->session->userdata('Email')])->row_array();
        $data['freelancer'] = $this->M_freelance->tampil_user()->result();
        // echo 'Selamat datang ' . $data['user']['nama'];
        $this->load->view('Freelance/header', $data);
        $this->load->view('Admin/sidebaradm', $data);
        $this->load->view('Freelance/topbar', $data);
        $this->load->view('Admin/upload', $data);
        $this->load->view('Freelance/footer');
    }
    public function hapus_freelancer($id)
    {
        $where =  array('id_fre' => $id);
        $this->M_freelance->hapus_data($where, 'freelancer');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    		Akun sudah berhasil terhapus
    	  </div>');
        redirect('Admin/lihatlistfreelancer');
    }
    public function tambah_aksir()
    {
        $data['nama_lengkap']           = $this->input->post('nama_lengkap');
        $data['alamat']       = $this->input->post('alamat');
        $data['kota']          = $this->input->post('kota');
        $data['provinsi']       = $this->input->post('provinsi');
        $data['no_telp']        = $this->input->post('no_telp');
        $data['jenis_kelamin']        = $this->input->post('jenis_kelamin');
        $data['agama']         = $this->input->post('agama');

        $config['upload_path']      = APPPATH . '../assets/img';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']    = '200000';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('Admin/upload', $error);
        } else {
            $upload_data = $this->upload->data();

            $data['image'] = $upload_data['file_name'];

            $this->M_freelance->tambah($data);

            redirect('Admin/upload');
        }




        // $this->db->insert('user', $data);
        // $this->M_freelance->tambah($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Selamat anda sudah terdaftar sebagai user INFREELANCER,
		  </div>');
        redirect('Admin/upload');
    }
}
