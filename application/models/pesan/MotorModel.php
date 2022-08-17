<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MotorModel extends CI_Model {

	public function getDetailCustomer($id)
	{
		$exe 		= $this->db->get_where('users', ['user_id' => $id]);

		return $exe;
	}

	public function getAll() {
		$exe = $this->db->select('t.*, u.user_name as user, d.user_name as driver');
		$exe = $exe->join('users u', 't.tran_user_id = u.user_id', 'left');
		$exe = $exe->join('users d', 't.tran_driv_id = d.user_id', 'left');

		if($this->session->userdata('data')['level'] == 'User') {
			$exe = $exe->where('t.tran_user_id', $this->session->userdata('data')['id']);
		} else {
			$exe = $exe->where('t.tran_driv_id', $this->session->userdata('data')['id']);
		}
		
		return $exe->get('transaksi t')->result_array();
	}

	public function getDetail($id) {
		$exe = $this->db->get_where('transaksi', ['tran_id' => $id]);

		return $exe;
	}

	public function order($customerId, $driverId, $from, $to, $price, $jarak, $lama)
	{
		$data['tran_user_id'] 	= $customerId;
		$data['tran_driv_id'] 	= $driverId;
		$data['tran_asal'] 		= $from;
		$data['tran_tujuan'] 	= $to;
		$data['tran_jarak'] 	= $jarak;
		$data['tran_harga'] 	= $price;
		$data['tran_status'] 	= 'Dipesan';

		$exe 					= $this->db->insert('transaksi', $data);

		return $this->db->insert_id();
	}

	public function setStatus($id, $driverId, $status)
	{
		$data['tran_driv_id'] 	= $driverId;
		$data['tran_status'] 	= $status;

		$exe 					= $this->db->where('tran_id', $id);
		$exe 					= $this->db->update('transaksi', $data);

		return $data;	
	}

}

/* End of file MotorModel.php */
/* Location: ./application/models/MotorModel.php */
