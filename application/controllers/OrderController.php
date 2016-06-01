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
		$this->load->helper('url');

		if ($this->order->delete($this->get_current_user()['id'], $this->uri->segment(2))) {
			flash($this, 'flashSuccess', 'Pedido cancelado com sucesso!');
			return redirect('dashboard');
		}

		flash($this, 'flashError', 'Pedido cancelado com sucesso!');
		return redirect('dashboard');
	}

	public function update_order () {
		$this->beforeAction();

		$order_id = $this->input->post("order_id");
		$itens = $this->input->post("itens");
		$json_result = array();

		if ($this->order->update_itens_amount($order_id, $itens)) {
			array_push($json_result, array('status' => 200, 'msg' => 'Quantidade de Itens Atualizados com sucesso!'));
		} else {
			array_push($json_result, array('status' => 500, 'msg' => 'Ocorreu um erro ao tentar atualizar a quantidade de itens.'));
		}

		$payment_mode = $this->input->post("payment_mode");
		if ($this->order->update_payment_mode($this->get_current_user()['id'], $order_id, $payment_mode)) {
			array_push($json_result, array('status' => 200, 'msg' => 'Modo de pagamento atualizado com sucesso!'));
		} else {
			array_push($json_result, array('status' => 500, 'msg' => 'Ocorreu um erro ao tentar atualizar o modo de pagamento'));
		}
		echo  json_encode($json_result);
		return json_encode($json_result);
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

	public function get_order_total () {
		$this->beforeAction();
		$order_id = $this->uri->segment(2);
		$order =  $this->order->get_order($order_id, $this->get_current_user()['id']);
		echo  json_encode($order);
	}

	public function finish_order () {
		error_reporting(E_ERROR | E_PARSE);
		$this->beforeAction();
		$order_id = $this->uri->segment(2);
		$order =  $this->order->get_order($order_id, $this->get_current_user()['id']);

		if (($order->delivery === 'Entrega') && (is_null($order->address))) {
			echo  json_encode(array('status' => 500, 'msg' => 'Endereço não encontrado! Você não possui nenhum endereço vinculado ao pedido. Favor informar o endereço de entrega.'));
			return false;
		}

		if ($order->delivery === 'Entrega' && is_null($order->freight)) {
			echo  json_encode(array('status' => 500, 'msg' => 'Valor de frete inválido! Verifique se o endereço principal vinculado a este pedido está correto. '));
			return false;
		}

		$order_finished = $this->order->finish($order, $this->get_current_user()['id']);

		if ($order_finished) {
			$this->sendEmail($order_finished);
			flash($this, 'flashSuccess', 'Pedido finalizado com sucesso! Logo entraremos em contato para a confirmação deste pedido.');
			echo  json_encode(array('status' => 200, 'msg' => 'Pedido finalizado com sucesso!'));
			return true;
		} else {
			echo  json_encode(array('status' => 500, 'msg' => 'Houve um erro ao tentar finalizar este pedido. Tente novamente.'));
			return false;
		}
	}

	private function sendEmail($order) {
		$path_image = "http://{$_SERVER['SERVER_NAME']}".base_url('assets/img/logo3.png');
		$data = array(
			'fileExt' => get_mime_by_extension($path_image),
			'image'   => base64_encode(file_get_contents($path_image)),
			'order'   => $order
		);
		$this->email->clear();
		$this->load->library('email');
		$this->email->initialize($this->config->item('config_email'));
		$this->output->set_content_type('text/plain', 'UTF-8');
		//$this->email->set_newline("\r\n");
		$this->email->to($this->get_current_user()['email']);
		$this->email->from('pedidos@casadopirogue.com.br', 'Novo Pedido');
		$this->email->subject('Novo Pedido');
		$data = array( 'order'=> $order );
		$body = $this->load->view('emails/request_order', $data, TRUE);
		$this->email->message($body);
		$this->email->send();
		//		$this->email->print_debugger();

	}

	public function get_my_orders()  {
		$this->beforeAction();

		$this->setTitle('Meus Pedidos');

		$orders = $this->order->get_list_orders($this->get_current_user()['id']);

		$datas = array(
			'page_title' => $this->getTitle(),
			'facebook_logout_url' => $this->facebook->get_logout_url(),
			'orders' =>$orders
		);

		if (count($orders) <= 0) {
			flash($this, 'flashInfo', 'Nenhum pedido realizado no momento.');
			return $this->template->load('dashboard',  'order/my-orders', $datas);
		}

		flash($this, 'flashSuccess', 'Total de pedidos encontrados: '.count($orders));
		return $this->template->load('dashboard',  'order/my-orders', $datas);
	}

	public function email_page () {
		error_reporting(E_ERROR | E_PARSE);
		$this->beforeAction();
		$path_image = "http://{$_SERVER['SERVER_NAME']}".base_url('assets/img/logo3.png');
		$order =  $this->order->get_order(80, $this->get_current_user()['id']);
		print_r($order);
		$data = array(
			'fileExt' => get_mime_by_extension($path_image),
			'image'   => base64_encode(file_get_contents($path_image)),
			'order'   => $order
		);
		return $this->load->view('emails/request_order', $data);

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
			'required'      => '<p class="error">Você deve informar o sabor do Item!</p>',
			'trim'     => '<p class="error">O camo sabor não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('item[sabor]', 'Sabor','trim|required', array(
			'required'      => '<p class="error">Você deve informar a categoria do Item!</p>',
			'trim'     => '<p class="error">O campo categoria não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('item[quantidade]', 'Quantidade','trim|required|is_natural', array(
			'required'      => '<p class="error">Você deve informar a quantidade do item desejado!</p>',
			'trim'     => '<p class="error">O campo quantidade não pode ser vazio!</p>',
			'is_natural' => '<p class="error">A quantidade deve ser maior do que zero!</p>'
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
		$new_item->package_price = ($this->input->post("item[sabor]")) ? explode("|", $this->input->post("item[sabor]"))[2] : 0;
		return $new_item;
	}

	public function set_delivery_mode(){

		$this->beforeAction();

		$order_id = $this->input->post("order_id");
		$datas = array (
		'address_id' => ($this->input->post("address_id") === '') ? NULL : $this->input->post("address_id"),
		'freight' => $this->input->post("freight"),
		'delivery' =>  $this->input->post("mode"),
		'distance' => ($this->input->post("distance") === '') ? 0 : $this->input->post("distance")
	);


	return ($this->order->set_delivery_mode($this->get_current_user()['id'], $order_id, $datas)) ? true: false;
}

public function set_delivery_date(){

	$this->beforeAction();

	$order_id = $this->input->post("order_id");
	$datas = array ('delivery_date' =>  $this->input->post("delivery_date"));

	return ($this->order->set_delivery_date($this->get_current_user()['id'], $order_id, $datas)) ? true: false;
}

public function approve_order () {
	$approve_order_link = trim($this->uri->segment(3)) ;
	$approved = $this->order->update_status($approve_order_link, 'approve_order_link');

	if ($approved) {
		flash($this, 'flashSuccess', 'Pedido aprovado com sucesso!');
	} else {
		flash($this, 'flashError', 'Este pedido não pôde ser aprovado!');
	}

	redirect('login');
}

public function disapprove_order () {
	$disapprove_order_link = trim($this->uri->segment(3)) ;
	$disapproved = $this->order->update_status($disapprove_order_link, 'disapprove_order_link');

	if ($disapproved) {
		flash($this, 'flashSuccess', 'Pedido cancelado com sucesso!');
	} else {
		flash($this, 'flashError', 'Este pedido não pôde ser cancelado!');
	}

	redirect('login');
}

}
