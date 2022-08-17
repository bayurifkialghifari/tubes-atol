<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Motor extends CI_Controller {


	// Main function
	public function index()
	{
		if($this->session->userdata('data')['level'] != 'User')
		{
			redirect('dashboard','refresh');
		}

		$model 			= $this->load->model('pengaturan/hargaModel', 'hargaModel');
	
      	$data['harga']  = $this->hargaModel->getAllData()->row_array()['tari_harga'];
		$data['title'] 	= 'ORDER BIKE';
		$data['tran_id'] = $this->input->get('tran_id');

		// Get detail transaction if tran_id != null
		if($data['tran_id']) {
			$data['transaction'] = $this->motor->getDetail($data['tran_id'])->result_array();
		}

		$this->load->view('templates/content/motor', $data);

	}


	// Get Detail Customer
	public function getDetailCustomer()
	{

		$customerId 	= $this->input->post('id');

		$exe 			= $this->motor->getDetailCustomer($customerId)->row_array();

		$this->output->set_content_type('application/json')->set_output(json_encode($exe));
	}



	// Get Detail Driver
	public function getDetailDriver()
	{

		$driverId 		= $this->input->post('id');

		$exe 			= $this->motor->getDetailCustomer($driverId)->row_array();

		$this->output->set_content_type('application/json')->set_output(json_encode($exe));
	}



	// Load model
	function __construct()
	{

		parent::__construct();

		$this->load->model('pesan/motorModel', 'motor');
		$this->load->library('sesion');
		$this->sesion->cek_session();

	}


}

/* End of file Motor.php */
/* Location: ./application/controllers/pesan/Motor.php */
