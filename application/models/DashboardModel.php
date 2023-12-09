<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardModel extends CI_Model {

    // Method untuk mengambil data dari API dan menyimpannya ke database
    public function getData() {
        // Load library database
        $this->load->database();

        // Endpoint API
        $api_url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';

        // Data untuk dikirim ke API
        $data = array(
            'username' => 'tesprogrammer091223C19',
            'password' => '349c77a5762af90d145944651bbb4f7e'
        );

        // Konfigurasi cURL untuk mengirim data ke API
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Eksekusi cURL untuk mendapatkan response dari API
        $response = curl_exec($ch);

        // Tutup koneksi cURL
        curl_close($ch);

        // Decode response dari JSON menjadi array
        $responseData = json_decode($response, true);

        // Simpan data ke database jika response memiliki data
        if (isset($responseData['data']) && is_array($responseData['data'])) {
            $this->saveStatusData($responseData['data']);
            $this->saveKategoriData($responseData['data']);
            $this->saveProdukData($responseData['data']);

            return true;
        } else {
            return false;
        }
    }

    // Method untuk menyimpan data status ke dalam tabel Status
    private function saveStatusData($dataStatus) {
        foreach ($dataStatus as $status) {
            // Cek apakah status sudah ada di dalam database
            $existingStatus = $this->db->get_where('status', array('nama_status' => $status['status']))->row_array();

            // Jika status belum ada, tambahkan ke dalam tabel Status
            if (empty($existingStatus)) {
                $statusData = array(
                    'nama_status' => $status['status']
                );

                $this->db->insert('status', $statusData);
            }
        }
    }

    // Method untuk menyimpan data kategori ke dalam tabel Kategori
    private function saveKategoriData($dataKategori) {
        foreach ($dataKategori as $kategori) {
            // Cek apakah kategori sudah ada di dalam database
            $existingKategori = $this->db->get_where('kategori', array('nama_kategori' => $kategori['kategori']))->row_array();

            // Jika kategori belum ada, tambahkan ke dalam tabel Kategori
            if (empty($existingKategori)) {
                $kategoriData = array(
                    'nama_kategori' => $kategori['kategori']
                );

                $this->db->insert('kategori', $kategoriData);
            }
        }
    }

    // Method untuk menyimpan data produk ke dalam tabel Produk
    private function saveProdukData($dataProduk) {
        foreach ($dataProduk as $produk) {
            // Cek apakah produk sudah ada di dalam database
            $cekProduk = $this->db->get_where('produk', array('id_produk' => $produk['id_produk']))->row_array();

            // Jika produk belum ada, tambahkan ke dalam tabel Produk
            if (empty($cekProduk)) {
                // Dapatkan kategori_id dari tabel Kategori
                $kategori = $this->db->get_where('kategori', array('nama_kategori' => $produk['kategori']))->row_array();
                $kategori_id = $kategori['id_kategori'];
    
                // Dapatkan status_id dari tabel Status
                $status = $this->db->get_where('status', array('nama_status' => $produk['status']))->row_array();
                $status_id = $status['id_status'];
    
                // Data untuk dimasukkan ke dalam tabel Produk
                $produkData = array(
                    'id_produk' => $produk['id_produk'],
                    'nama_produk' => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'kategori_id' => $kategori_id,
                    'status_id' => $status_id
                );
    
                // Masukkan data ke dalam tabel Produk
                $this->db->insert('produk', $produkData);
            }
        }
    }

    // Method untuk mendapatkan data produk dari database dengan filter berdasarkan status
    public function getProdukData($filter_status = 'all')
    {
        $this->db->select('produk.id_produk, produk.nama_produk, produk.harga, kategori.nama_kategori, status.nama_status');
        $this->db->from('produk');
        $this->db->join('kategori', 'kategori.id_kategori = produk.kategori_id');
        $this->db->join('status', 'status.id_status = produk.status_id');

        // Filter berdasarkan status jika bukan 'all'
        if ($filter_status != 'all') {
            $this->db->where('produk.status_id', $filter_status);
        }

        $this->db->order_by('produk.id_produk', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Method untuk mendapatkan data kategori dari database
    public function getKategori() {
        // Query untuk mendapatkan data kategori dari tabel Kategori
        $query = $this->db->get('kategori');
        return $query->result();
    }

    // Method untuk mendapatkan data status dari database
    public function getStatus() {
        // Query untuk mendapatkan data status dari tabel Status
        $query = $this->db->get('status');
        return $query->result();
    }

    // Method untuk menambahkan data produk ke dalam tabel Produk
    public function tambahProduk($data) {
        // Masukkan data ke dalam tabel Produk dan kembalikan ID produk yang baru ditambahkan
        $this->db->insert('produk', $data);
        return $this->db->insert_id();
    }

    // Method untuk menghapus data produk dari tabel Produk berdasarkan ID produk
    public function hapusProduk($data) {
        // Hapus data produk dari tabel Produk berdasarkan ID produk
        $this->db->where('id_produk', $data);
        return $this->db->delete('produk');
    }

    // Method untuk mendapatkan data produk dari tabel Produk berdasarkan ID produk
    public function getProdukById($id_produk) {
        // Query untuk mendapatkan data produk dari tabel Produk berdasarkan ID produk
        $this->db->where('id_produk', $id_produk);
        return $this->db->get('produk')->row();
    }

    // Method untuk update data produk dari tabel Produk berdasarkan ID produk
    public function updateProduk($id_produk, $data) {
        $this->db->where('id_produk', $id_produk);
        return $this->db->update('produk', $data);
    }
}
