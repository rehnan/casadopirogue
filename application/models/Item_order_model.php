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
			if ($this->db->insert('item_order', $item)) {
				return true ;
			}
			return false;
		}
		catch (Exception $e) {
			echo 'ocorreu um erro ao tentar criar um novo item de pedido! ',  $e->getMessage(), "\n";
			return false;
		}
	}

}