<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends CI_Controller {
	private $page_title;

	public function __construct() {
		parent::__construct();
		$this->setTitle('Novo Pedido');
		$this->load->model('user_model', 'userInstance');
		$this->load->model('order_model', 'order');
	}

	public function new_order () {

		$this->beforeAction();

		//Procura por ordens não finalizadas, caso encontrar retorna para ser finalizada
		$order_found = $this->order->check_by_order_open($this->get_current_user()['id']);

		if (!$order_found) {
			flash($this, 'flashSuccess', 'Novo pedido aberto.');
			$order = $this->create_order();
		} else {
			$order =  $this->order->get_order($order_found, $this->get_current_user()['id']);
			flash($this, 'flashInfo', 'O pedido '.$order->id.' está em aberto. Para cancelá-lo clique em Cancelar Pedido, assim você poderá abrir um novo.');
		}

		$datas = array(
			'page_title' => $this->getTitle(),
			'facebook_logout_url' => $this->facebook->get_logout_url(),
			'order' => $order,
			'item' =>  $this->order->getItemModel()
			);

		return $this->template->load('dashboard',  'order/new', $datas);
	}

	private function create_order () {
		$this->beforeAction();
		return $this->order->create($this->get_current_user()['id']);
	}

	public function delete_order() {

		$this->beforeAction();

		if ($this->order->delete($this->get_current_user()['id'], $this->uri->segment(2))) {
			flash($this, 'flashSuccess', 'Pedido cancelado com sucesso!');
			return redirect('dashboard');
		}

		flash($this, 'flashError', 'Pedido cancelado com sucesso!');
		return redirect('dashboard');
	}

	public function add_item () {

		$this->beforeAction();

		$item = $this->getPost();
		$order = $this->order->get_order($item->order_id, $this->get_current_user()['id']);

		$datas = array(
			'page_title' => $this->getTitle(),
			'facebook_logout_url' => $this->facebook->get_logout_url(),
			'order' => $order,
			'item' =>  $item
			);

		if (!$this->validate_post_item()) {
			flash($this, 'flashError', 'Pussui(em) erro(s) no formulário!');
			return $this->template->load('dashboard',  'order/new', $datas);
		}

		if ($this->order->add_item($item)) {
			flash($this, 'flashSuccess', 'O Item '. $item->name.' foi adicionado ao carrinho.');
			$datas['order'] = $this->order->get_order($item->order_id, $this->get_current_user()['id']);
			$datas['item'] =$this->order->getItemModel() ;
			return $this->template->load('dashboard',  'order/new', $datas);
		}

		flash($this, 'flashError', 'Houve um erro ao tentar adiciona o item!');
		return $this->template->load('dashboard',  'order/new', $datas);
	}

	public function get_itens () {
		$this->beforeAction();
		$category = $this->uri->segment(3);
		echo  json_encode($this->item->findAll($category));
	}

	private function getTitle() {
		return $this->page_title;
	}

	private function setTitle($title) {
		$this->page_title = $title;
	}

	private function beforeAction() {
		if (!$this->session->has_userdata('current_user'))
			return redirect('login');
	}

	private function get_current_user () {
		return $this->session->get_userdata('current_user')['current_user'];
	}

	public function validate_post_item() {

		$this->form_validation->set_rules('item[categoria]', 'Categoria', 'trim|required',  array(
			'required'      => 'Você deve informar o sabor do Item!',
			'trim'     => 'O camo sabor não pode ser vazio!'
			));

		$this->form_validation->set_rules('item[sabor]', 'Sabor','trim|required', array(
			'required'      => 'Você deve informar a categoria do Item!',
			'trim'     => 'O campo categoria não pode ser vazio!'
			));

		$this->form_validation->set_rules('item[quantidade]', 'Quantidade','trim|required|is_natural', array(
			'required'      => 'Você deve informar a quantidade do item desejado!',
			'trim'     => 'O campo quantidade não pode ser vazio!',
			'is_natural' => 'A quantidade deve ser maior do que zero!'
			));

		return $this->form_validation->run();
	}

	private function getPost($item = null) {
		$new_item = (is_null($item)) ? $this->order->getItemModel() : $item;
		$new_item->order_id =$this->input->post("item[pedido_id]");
		$new_item->item_id =  ($this->input->post("item[sabor]")) ? explode("|", $this->input->post("item[sabor]"))[0] : null;
		$new_item->name = ($this->input->post("item[sabor]")) ? explode("|", $this->input->post("item[sabor]"))[1] : null;
		$new_item->category = ($this->input->post("item[categoria]") === '[Selecione um Produto]') ? null : $this->input->post("item[categoria]");
		$new_item->amount = $this->input->post("item[quantidade]");
		$new_item->description = $this->input->post("item[observacao]");
		return $new_item;
	}



}