<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Order_model extends CI_Model {

	public $id;
	public $item_id;
	public $order_id;
	public $name;
	public $description;
	public $category;
	public $amount;
	public $package_price;

	public function create ($item) {
		try
		{
			$amount_itens = $this->amount_itens($item);
			return ($amount_itens > 0) ? $this->update_amount_itens($item, $amount_itens) : $this->insert($item);

		}
		catch (Exception $e) {
			echo 'ocorreu um erro ao tentar criar um novo item de pedido! ',  $e->getMessage(), "\n";
			return false;
		}
	}

	private function amount_itens ($item) {

		$where =  array('order_id' => $item->order_id, 'item_id' => $item->item_id);
   		$this->db->select('ifnull(SUM(amount), 0) As amount');
   		$this->db->from('item_order');
   		$this->db->where($where);
   		$this->db->limit(1);

   		$query = $this->db->get();

   		return $query->result()[0]->amount;
	}

	private function update_amount_itens ($item, $amount_itens) {
		$where =  array('order_id' => $item->order_id, 'item_id' => $item->item_id);
		$total_amount = $amount_itens+$item->amount;
		$total_price = $total_amount * $item->package_price;
   		$this->db->set('amount', ($amount_itens+$item->amount));
   		$this->db->set('package_price',  $total_price);
   		$this->db->where($where);
   		return  ($this->db->update('item_order')) ? true : false;
	}

	private function insert ($item) {
		return ($this->db->insert('item_order', $item)) ? true : false;
	}

}