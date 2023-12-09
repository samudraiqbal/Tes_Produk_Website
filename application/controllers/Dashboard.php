<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    // Konstruktor class Dashboard
    public function __construct() {
        parent::__construct();
        // Memuat library session dan model DashboardModel
        $this->load->library('session');
        $this->load->model('DashboardModel');
    }

    // Method untuk menampilkan halaman dashboard
	public function index()
    {
        // Mengambil nilai filter_status dari parameter URL
        $filter_status = $this->input->get('filter_status');

        // Menetapkan nilai filter_status default jika tidak ada parameter
        if (empty($filter_status)) {
            $filter_status = 'all';
        }

        // Mengambil data produk berdasarkan filter_status dari model DashboardModel
        $data['produkData'] = $this->DashboardModel->getProdukData($filter_status);

        // Mendapatkan data kategori dan status dari database
        $data['kategori'] = $this->DashboardModel->getKategori();
        $data['status'] = $this->DashboardModel->getStatus();
        
        // Menetapkan view dan melewatkan data ke template_view
        $data['view'] = 'dashboard_view';
        $this->load->view('template_view', $data);
    }

    // Method untuk mengambil data dari API dan menyimpannya ke database
    public function fetchData() {
        $result = $this->DashboardModel->getData();
        // Menetapkan pesan sesuai dengan hasil pengambilan data
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data berhasil diambil dari API dan disimpan ke database.');
        } else {
            $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat mengambil data dari API.');
        }
        redirect('dashboard');
    }

    // Method untuk menambahkan produk baru
    public function tambahProduk() {
        //Load library form_validation
        $this->load->library('form_validation');

        // Menetapkan aturan validasi untuk form
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        
        // Memeriksa apakah validasi form berhasil atau tidak
        if ($this->form_validation->run() == FALSE) {
            // Validasi gagal, menetapkan pesan error ke session
            $this->session->set_flashdata('error_message', validation_errors());

            redirect('dashboard');
        } else {
            // Validasi berhasil, lanjutkan proses input data ke database
            $nama_produk = $this->input->post('nama_produk');
            $harga = $this->input->post('harga');
            $kategori = $this->input->post('kategori');
            $status = $this->input->post('status');

            // Menyimpan data produk ke database
            $data = array(
                'nama_produk' => $nama_produk,
                'harga' => $harga,
                'kategori_id' => $kategori,
                'status_id' => $status
            );

            // Memanggil method tambahProduk dari model DashboardModel
            $result = $this->DashboardModel->tambahProduk($data);

            // Menetapkan pesan sesuai dengan hasil penambahan data
            if ($result) {
                $this->session->set_flashdata('success_message', 'Data berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error_message', 'Data gagal ditambahkan.');
            }
            redirect('dashboard');
        }
    }

    // Method untuk menghapus produk
    public function hapusProduk($data) {
        // Memanggil method hapusProduk dari model DashboardModel
        $result = $this->DashboardModel->hapusProduk($data);
        // Menetapkan pesan sesuai dengan hasil penghapusan data
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Data gagal dihapus.');
        }
        redirect('dashboard');
    }

    // Method untuk mengedit produk
    public function editProduk() {
        //Load library form_validation
        $this->load->library('form_validation');

        // Menetapkan aturan validasi untuk form
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        
        // Memeriksa apakah validasi form berhasil atau tidak
        if ($this->form_validation->run() == FALSE) {
            // Validasi gagal, menetapkan pesan error ke session
            $this->session->set_flashdata('error_message', validation_errors());

            redirect('dashboard');
        } else {
            // Validasi berhasil, lanjutkan proses input data ke database
            $id_produk = $this->input->post('id_produk');
            $nama_produk = $this->input->post('nama_produk');
            $harga = $this->input->post('harga');
            $kategori = $this->input->post('kategori');
            $status = $this->input->post('status');

            // Menyimpan data produk ke database
            $data = array(
                'nama_produk' => $nama_produk,
                'harga' => $harga,
                'kategori_id' => $kategori,
                'status_id' => $status
            );

            // Memanggil method updateProduk dari model DashboardModel
            $result = $this->DashboardModel->updateProduk($id_produk, $data);
            // Menetapkan pesan sesuai dengan hasil pembaruan data
            if ($result) {
                $this->session->set_flashdata('success_message', 'Data berhasil diedit.');
            } else {
                $this->session->set_flashdata('error_message', 'Data gagal diedit.');
            }
            redirect('dashboard');
        }
    }
}
?>