<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CekKoneksi extends CI_Controller {

    public function index()
    {
        // Load the database library
        $this->load->database();

        // Check the database connection
        if ($this->db->conn_id) {
            echo 'Database connection successful';
        } else {
            echo 'Unable to connect to the database';
        }
    }
}
