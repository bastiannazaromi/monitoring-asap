<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!empty($this->session->userdata('data_login'))) {
			if ($this->uri->segment(2) != 'logout')
			{
				$this->session->set_flashdata('flash-error', 'Anda Sudah Login');
				redirect('Dashboard');
			}
		}
	}

	public function index()
	{
		
		$data['title'] = 'Halaman Login';
		$this->load->view('login/index', $data, FALSE);
		
	}

	public function login()
	{
		$email = $this->input->post("email");
		$password = $this->input->post("password");

		$this->load->model('M_Login');
		$a = $this->M_Login->cek_login($email,$password);
		
		echo $a;
	}

	public function logout(){
		$this->session->sess_destroy($this->session->userdata('data_login'));
		redirect('Login', 'refresh');
	}
	
}