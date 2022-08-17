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
		$data['tran_id'] 	= $this->input->get('tran_id');
		$data['harga']  = $this->hargaModel->getAllData()->row_array()['tari_harga'];

		// Get detail transaction if tran_id != null
		if($data['tran_id']) {
			$data['transaction'] = $this->motor->getDetail($data['tran_id'])->result_array();
		}


		// Load view
		$this->load->view('templates/content/dashboard', $data);
	
	}

	// Load Model and Library
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('pengaturan/hargaModel', 'hargaModel');
		$this->load->model('pesan/motorModel', 'motor');
		$this->load->library('sesion');
		$this->sesion->cek_session();
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/pengaturan/Dashboard.php */
