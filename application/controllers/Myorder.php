<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myorder extends CI_Controller {


	// Main function
	public function index()
	{
		$data['title'] 	= 'My Order';
		$data['data'] = $this->motor->getAll();

		$this->load->view('templates/content/myyorder', $data);

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

/* End of file Myorder.php */
/* Location: ./application/controllers/Myorder.php */
