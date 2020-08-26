<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Data extends CI_Model {

	public function save($suhu, $kelembapan, $asap)
	{
        $tanggal = date('Y-m-d H:i:s');

        $data = [
            "waktu" => $tanggal,
            "suhu" => $suhu,
            "kelembapan" => $kelembapan,
            "asap" => $asap
        ];

        $this->db->insert('tbrekap', $data);
    }

    public function ambil_data_terakhir()
    {
        $this->db->select('*');
        $this->db->from('tbrekap');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);

        return $this->db->get()->result_array();
    }

}