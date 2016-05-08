<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends CI_Model {
	public $id;
	public $user_id;
	public $address_name;
	public $uf;
	public $city;
	public $street;
	public $number;
	public $complement;
	public $neighborhood;
	public $zip_code;

	public function create ($address) {
		try
		{
			if ($this->db->insert('address', $address))
				return true ;
			return false;
		}
		catch (Exception $e) {
			echo 'ocorreu um erro ao tentar criar um novo endereço! ',  $e->getMessage(), "\n";
			return false;
		}
	}

	public function delete ($user_id, $address_id) {
		try
   		{
   			$data = array (
   				'id' 	      => $address_id,
   				'user_id' => $user_id,
   			);

   			if ($this->db->delete('address', $data)) {
   				return true ;
   			}
   			return false;
   		}
   		catch (Exception $e) {
   			echo 'ocorreu um erro ao tentar deletar este endereço! ',  $e->getMessage(), "\n";
   			return false;
   		}
	}

	public function get_all ($user_id) {
		$where =  array('user_id' => $user_id);
   		$this->db->select('*');
   		$this->db->from('address');
   		$this->db->where($where);

   		$query = $this->db->get();
   		//$query->num_rows()
		$address = $query->custom_result_object('address_model');
   		return $address;
	}


}