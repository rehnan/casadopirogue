<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends CI_Model {

	public $id;
	public $name;
	public $description;
	public $category;

	public function getAll() {

		$this->db->select('Itens.post_title As pedido_id, Itens.post_content As Descrição,  Itens.post_mime_type As Imagem,   Categorias.name As Categoria');
		$this->db->from('cp_posts As Itens');
		$this->db->join('cp_term_relationships As Categoria_Itens', 'Categoria_Itens.object_id = Itens.id');
		$this->db->join('cp_terms As Categorias', 'Categorias.term_id = Categoria_Itens.term_taxonomy_id');
		$this->db->where('Itens.post_type', 'produtos');
		//$this->db->join('cp_postmeta', 'cp_postmeta.post_id = cp_posts.id');

		$query = $this->db->get();

		print_r($query->result());

	}

	public function findAll($item = null) {

		$where = (is_null($item)) ? array('Itens.post_type' => 'produtos') :  array('Itens.post_type' => 'produtos', 'Categorias.name' => $item);
		$this->db->select('Itens.id As id, Itens.post_title As name, Itens.post_content As description,  Categorias.name As category');
		$this->db->from('cp_posts As Itens');
		$this->db->join('cp_term_relationships As Categoria_Itens', 'Categoria_Itens.object_id = Itens.id');
		$this->db->join('cp_terms As Categorias', 'Categorias.term_id = Categoria_Itens.term_taxonomy_id');
		$this->db->where($where);

		$query = $this->db->get();
		 // Retorno número de linhas $query->num_rows();
		$itens = $query->custom_result_object('item_model');
		return $itens;
	}

	 public function count_itens ($order_id, $user_id) {
   		$where =  array('order_id' => $order_id);
		$this->db->select('COUNT(*) As count');
		$this->db->from('item_order');
		$this->db->where($where);

		$query = $this->db->get();

		 if ($query->num_rows() > 0) {
		 	$count = $query->custom_result_object('item_model');
		 	return $count[0]->count;
		 }
		 return false;
   }









}