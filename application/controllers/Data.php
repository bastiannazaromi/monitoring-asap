<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
    
    public function save()
	{
        $this->load->model('M_Data', 'data');

		$suhu = $this->input->get('suhu');
        $kelembapan = $this->input->get('kelembapan');
        $asap = $this->input->get('asap');

        // data dari M_Simpan.php
        $rekap = $this->data->ambil_data_terakhir();
        
        if ($rekap)
        {
            $suhu_sebelumnya = $rekap[0]["suhu"];
            $kelembapan_sebelumnya = $rekap[0]["kelembapan"];
            $asap_sebelumnya = $rekap[0]["asap"];
            
            $awal  = date_create($rekap[0]['waktu']);
            $akhir = date_create(); // waktu sekarang
            $diff  = date_diff( $awal, $akhir );
            
            $hari = $diff->d;
            $jam = $diff->h;

            if ($suhu_sebelumnya == $suhu && $kelembapan_sebelumnya == $kelembapan && $asap_sebelumnya == $asap)
            {
                if ($hari >= 1 || $jam >= 1)
                {
                    // Simoan ke database
                    $this->data->save($suhu, $kelembapan, $asap);
                    echo "Data berhasil disimpan ke database :)";
                }
                else
                {
                    echo "Data masih sama :(";
                }
            }
            else
            {
                // Simpan ke database
                $this->data->save($suhu, $kelembapan, $asap);
                echo "Data berhasil disimpan ke database :)";
            }
        }
        
    }

}