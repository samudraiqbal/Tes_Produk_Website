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
        $data['view'] = 'dashboard_view';
        $this->load->view('template_view', $data);
    }

    public function fetchData() {
        $result = $this->DashboardModel->getData();

        if ($result) {
            $this->session->set_flashdata('success_message', 'Berhasil mengambil data dari API dan disimpan ke database.');
        } else {
            $this->session->set_flashdata('error_message', 'Terjadi kesalahan saat mengambil data dari API.');
        }
    
        redirect('dashboard');
    }
}
?>