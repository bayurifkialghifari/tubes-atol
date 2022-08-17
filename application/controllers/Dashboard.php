<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	// Main function
	public function index()
	{
		if($this->session->userdata('data')['level'] == 'User')
		{
			redirect('users/home','refresh');
		}
	
		// Data for view
		$data['title'] 		= 'Dashboard';


		// Load view
		$this->load->view('templates/content/dashboard', $data);
	
	}

	// Load Model and Library
	function __construct()
	{
		parent::__construct();

		$this->load->library('sesion');
		$this->sesion->cek_session();
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/pengaturan/Dashboard.php */
