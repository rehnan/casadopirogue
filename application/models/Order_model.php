<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {

	public $id;
	public $user_id;
	public $address_id;
	public $total;
   	public $freight; //Pendente | Confirmado | Saiu para Entrega | Entregue | Cancelado
   	public $status;
   	public $itens_amount;
   	public $created_at;
   	public $updated_at;
   	public $delivery;

   	public function __construct() {
   		parent::__construct();
   		$this->load->model('address_model', 'address');
   		$this->load->model('item_model', 'item');
   		$this->load->model('item_order_model', 'item_order');
   	}

   	public function create ($user_id) {
   		try
   		{
   			$data = array (
   				'user_id' => $user_id,
   				'status'  => 'Aberto'
   				);

   			if ($this->db->insert('order', $data)) {
   				$order_id = $this->db->insert_id();
   				$order =  $this->get_order($order_id, $user_id);
   				return $order ;
   			}

   			return false;
   		}
   		catch (Exception $e) {
   			echo 'ocorreu um erro ao tentar criar um novo pedido! ',  $e->getMessage(), "\n";
   			return false;
   		}

   	}

   	public function delete ($user_id, $order_id) {

		$data = array (
			'id' 	      => $order_id,
			'user_id' => $user_id,
			'status'   => 'Aberto'
			);

		if ($this->db->delete('order', $data)) {
			return true ;
		}
		return false;

   	}

   	public function get_order ($order_id, $user_id) {
   		//Update order before select
   		$this->update_order($order_id, $user_id);

   		$where =  array('status' => 'Aberto', 'user_id' => $user_id, 'order.id' => $order_id);
   		$this->db->select('*');
   		$this->db->from('order');
   		$this->db->where($where);

   		$query = $this->db->get();
		 // Retorno número de linhas $query->num_rows();
   		$order = $query->custom_result_object('order_model');
   		$order[0]->itens = $this->get_itens_order($order_id);
   		//$order[0]->itens_amount = $this->get_itens_amount($order_id);
   		$order[0]->address_id = $this->address->get_delivery_address($user_id);

   		return $order[0];
   	}

   	public function check_by_order_open ($user_id) {
   		$where =  array('status' => 'Aberto', 'user_id' => $user_id);
   		$this->db->select('id');
   		$this->db->from('order');
   		$this->db->where($where);
   		$this->db->limit(1);

   		$query = $this->db->get();

   		if ($query->num_rows() > 0) {
   			$order = $query->custom_result_object('order_model');
   			return $order[0]->id;
   		}
   		return false;
   	}

   	private function get_itens_amount ($order_id) {
   		$where =  array('order_id' => $order_id);
		$this->db->select('SUM(amount) As amount');
		$this->db->from('item_order');
		$this->db->where($where);

		$query = $this->db->get();

		 if ($query->num_rows() > 0) {
		 	return $query->result()[0]->amount;;
		 }
		 return 0;
   	}

   	private function update_order ($order_id, $user_id) {

   		$where =  array('order_id' => $order_id);
		$this->db->select('SUM(amount) As amount_itens , (SUM(amount) * package_price) as total');
		$this->db->from('item_order');
		$this->db->where($where);

		$query = $this->db->get();

   		$where =  array('id' => $order_id, 'Status' => 'Aberto', 'user_id' => $user_id, );


   		$datas = array (
   			'itens_amount' => $query->result()[0]->amount_itens,
   			'total' => $query->result()[0]->total
   		);

   		$this->db->where($where);
   		if ($this->db->update('order', $datas))
   			return true;
   		return false;
   	}

   	public function finish ($order, $user_id) {

   		$where =  array('id' => $order->id, 'user_id' => $user_id);
		$datas  =  array();
		$datas['status'] = 'Finalizado';
		if ($order->delivery === 'Entrega') { $datas['total'] = $order->total + $order->freight; }
		$this->db->where($where);

   		if ($this->db->update('order', $datas))
   			return true;
   		return false;
   	}

   	public function update_itens_amount ($order_id, $itens) {

   		return $this->item_order->set_amount_itens($order_id, $itens);

   	}


   	public function get_itens_order ($order_id) {
   		return $this->item->get_itens($order_id);
   	}

   	public function add_item ($item) {
   		return $this->item_order->create($item);
   	}

   	public function getItemModel () {
   		return $this->item_order;
   	}

   	public function set_delivery_mode ($user_id, $order_id, $datas) {
   		$where =  array('id' => $order_id, 'Status' => 'Aberto', 'user_id' => $user_id, );
   		$this->db->where($where);
   		if ($this->db->update('order', $datas))
   			return true;
   		return false;
   	}
   }

   ?>

