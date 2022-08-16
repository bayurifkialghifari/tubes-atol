<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Socket extends CI_Controller {

	public function innitPusher() {
		/**
		 * APP_KEY Pusher liblary
		 * 
		 * 
		 * app_id = "1463863"
		 * key = "fb1c5952e0aaa79fdced"
		 * secret = "56f728172350e77d5f7d"
		 * cluster = "ap1"
		 *
		 *
		 *
		 **/
		require_once APPPATH . 'libraries/pusher/autoload.php';

		$options 						= array(
			'cluster' 	=> 'ap1',
			'useTLS' 	=> true
		);

		$pusher 						= new Pusher\Pusher(
			'fb1c5952e0aaa79fdced',
			'56f728172350e77d5f7d',
			'1463863',
			$options
		);

		return $pusher;
	}

	public function pesan()
	{
		$pusher = $this->innitPusher();

		$customerId 	= $this->input->post('user_id');
		$status 		= $this->input->post('status');
		// $driverId 		= $this->input->post('driv_id');
		$from 			= $this->input->post('from');
        $to 			= $this->input->post('to');
        $price 			= $this->input->post('price');
        $jarak 			= $this->input->post('jarak');
        $lama 			= $this->input->post('lama');

		// Triger websocket
		$data['message'] 				= 'success';
		$data['status'] 				= $status;
		$data['from'] 					= $from;
		$data['to'] 					= $to;
		$data['price'] 					= $price;
		$data['jarak'] 					= $jarak;
		$data['customerId'] 			= $customerId;

		$pusher->trigger('motor', 'pesanan-datang', $data);

		echo json_encode(1);
	}

	public function jalan()
	{
		$pusher = $this->innitPusher();
		
		$customerId 	= $this->input->post('user_id');
		$status 		= $this->input->post('status');
		$driver 		= $this->input->post('driv_id');

		// Triger websocket
		$data['message'] 				= 'success';
		$data['status'] 				= $status;
		$data['customerId'] 			= $customerId;
		$data['driver'] 				= $driver;

		$pusher->trigger('motor', 'jalan', $data);

		echo json_encode(1);
	}

	public function batalPesanan()
	{
		$pusher = $this->innitPusher();

		$id 			= $this->input->post('user_id');
		$status 		= $this->input->post('status');
		// Triger websocket
		$data['message'] 				= 'success';
		$data['status'] 				= $status;
		$data['id'] 					= $id;

		$pusher->trigger('motor', 'batal', $data);

		echo json_encode(1);
	}


}

/* End of file Motor.php */
/* Location: ./application/controllers/pesan/Soclet.php */
