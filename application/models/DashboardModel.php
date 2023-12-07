<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardModel extends CI_Model {

    public function getData() {
        // Load the database library
        $this->load->database();

        // Endpoint API
        $api_url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';

        // Data untuk dikirim (gunakan format sesuai kebutuhan API)
        $data = array(
            'username' => 'tesprogrammer071223C21',
            'password' => 'ed214b2ef6873c681fdcd1ab3305f97e'
        );

        // Konfigurasi cURL
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Eksekusi cURL untuk mendapatkan response
        $response = curl_exec($ch);

        // Tutup koneksi cURL
        curl_close($ch);

        // Decode the response
        $responseData = json_decode($response, true);

        // Save data to the database
        if (isset($responseData['data']) && is_array($responseData['data'])) {
            $this->saveStatusData($responseData['data']);
            $this->saveKategoriData($responseData['data']);
            $this->saveProdukData($responseData['data']);

            return true;
        } else {
            return false;
        }
    }

    private function saveStatusData($dataStatus) {
        foreach ($dataStatus as $status) {
            // Check if status already exists in the database
            $existingStatus = $this->db->get_where('status', array('nama_status' => $status['status']))->row_array();

            if (empty($existingStatus)) {
                $statusData = array(
                    'nama_status' => $status['status']
                    // Add other columns and values as needed
                );

                $this->db->insert('status', $statusData);
            // } else {
            //     echo 'Status already exists: ' . $product['status'] . '<br>';
            }
        }
    }

    private function saveKategoriData($dataKategori) {
        foreach ($dataKategori as $kategori) {
            // Check if status already exists in the database
            $existingKategori = $this->db->get_where('kategori', array('nama_kategori' => $kategori['kategori']))->row_array();

            if (empty($existingKategori)) {
                $kategoriData = array(
                    'nama_kategori' => $kategori['kategori']
                    // Add other columns and values as needed
                );

                $this->db->insert('kategori', $kategoriData);
            // } else {
            //     echo 'Status already exists: ' . $product['status'] . '<br>';
            }
        }
    }

    private function saveProdukData($dataProduk) {
        foreach ($dataProduk as $produk) {
            // Periksa apakah produk sudah ada di dalam database
            $cekProduk = $this->db->get_where('produk', array('id_produk' => $produk['id_produk']))->row_array();
    
            if (empty($cekProduk)) {
                // Dapatkan kategori_id dari tabel Kategori
                $kategori = $this->db->get_where('kategori', array('nama_kategori' => $produk['kategori']))->row_array();
                $kategori_id = $kategori['id_kategori'];
    
                // Dapatkan status_id dari tabel Status
                $status = $this->db->get_where('status', array('nama_status' => $produk['status']))->row_array();
                $status_id = $status['id_status'];
    
                // Persiapkan data untuk dimasukkan ke dalam tabel Produk
                $produkData = array(
                    'id_produk' => $produk['id_produk'],
                    'nama_produk' => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'kategori_id' => $kategori_id,
                    'status_id' => $status_id
                    // Tambahkan kolom dan nilai lain sesuai kebutuhan
                );
    
                // Masukkan data ke dalam tabel Produk
                $this->db->insert('produk', $produkData);
            // } else {
            //     echo 'Produk sudah ada: ' . $produk['id_produk'] . '<br>';
            }
        }
    }
    
    public function getProdukData($filter_status = 'all')
    {
        $this->db->select('produk.id_produk, produk.nama_produk, produk.harga, kategori.nama_kategori, status.nama_status');
        $this->db->from('produk');
        $this->db->join('kategori', 'kategori.id_kategori = produk.kategori_id');
        $this->db->join('status', 'status.id_status = produk.status_id');

        if ($filter_status != 'all') {
            $this->db->where('produk.status_id', $filter_status);
        }

        $this->db->order_by('produk.id_produk', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }
}
