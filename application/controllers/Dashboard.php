<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('DashboardModel');
    }

	public function index()
    {
        $filter_status = $this->input->get('filter_status');

        // Atur filter_status default jika tidak diberikan
        if (empty($filter_status)) {
            $filter_status = 'all';
        }

        $data['produkData'] = $this->DashboardModel->getProdukData($filter_status);

        // Mendapatkan data kategori dan status dari database
        $data['kategori'] = $this->DashboardModel->getKategori();
        $data['status'] = $this->DashboardModel->getStatus();

        $data['view'] = 'dashboard_view';
        $this->load->view('template_view', $data);
    }

    public function fetchData() {
        $result = $this->DashboardModel->getData();

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data berhasil diambil dari API dan disimpan ke database.');
        } else {
            $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat mengambil data dari API.');
        }
    
        redirect('dashboard');
    }

    public function tambahProduk() {
        $nama_produk = $this->input->post('nama_produk');
        $harga = $this->input->post('harga');
        $kategori = $this->input->post('kategori');
        $status = $this->input->post('status');

        // Simpan data produk ke database
        $data = array(
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'kategori_id' => $kategori,
            'status_id' => $status
        );

        $result = $this->DashboardModel->tambahProduk($data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error_message', 'Data gagal ditambahkan.');
        }

        // Redirect atau tampilkan pesan sukses sesuai kebutuhan
        redirect('dashboard');
    }
}
?>