<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressController extends CI_Controller {

	private $page_title;

	public function __construct() {
		parent::__construct();
		$this->setTitle('Cadastro de Endereços');
		$this->load->model('address_model', 'address');
	}

	public function index () {

		$this->beforeAction();

		$address = $this->address->get_all($this->get_current_user()['id']);

		$datas = array(
			'page_title' => $this->getTitle(),
			'facebook_logout_url' => $this->facebook->get_logout_url(),
			'address' => $address
		);


		if (count($address)  <= 0) {
			flash($this, 'flashInfo', 'Você não possui nenhum endereço cadastrado!');
		}

		//print_r($this->session->all_userdata());
		flash($this, 'flashInfo', 'Você possui '.count($address). ' endereço(s) cadastrado(s).');
		$this->template->load('dashboard',  'address/index', $datas);
	}

	public function new_address () {

		$this->beforeAction();
		$address = $this->address;
		$datas   = array(
			'page_title' => $this->getTitle(),
			'facebook_logout_url' => $this->facebook->get_logout_url(),
			'address' => $address,
			'method' => base_url('address/new')
		);
		
		$this->template->load('dashboard',  'address/new', $datas);
	}

	public function edit_address () {
		$this->beforeAction();
		$this->setTitle('Editar Endereço');
		$address_id = $this->uri->segment(2);
		$user_id = $this->get_current_user()['id'];
		$address = $this->address->find($user_id, $address_id);

		$datas   = array(
			'page_title' => $this->getTitle(),
			'address' => $address,
			'method' => base_url('address/'.$address_id.'/edit')
		);

		if ($address) {
			return $this->template->load('dashboard',  'address/edit', $datas);
		}

		flash($this, 'flashError', 'Endereço não encontrado!');
		return redirect('address');
	}

	public function create_address () {

		$this->beforeAction();
		$address = $this->getPost();
		$datas = array(
			'page_title' => $this->getTitle(),
			'address' =>$address,
			'method' => base_url('address/new')
		);

		if (!$this->validate_address()) {
			flash($this, 'flashError', 'Pussui(em) erro(s) no formulário!');
			return $this->template->load('dashboard',  'address/new', $datas);
		}

		$address->user_id = $this->get_current_user()['id'];

		if ($this->address->create($address)) {
			flash($this, 'flashSuccess', 'Endereço '.$address->address_name.' adicionado com sucesso!');
			redirect('address');
		}
	}

	public function update_address () {

		$this->beforeAction();
		$address_id = $this->uri->segment(2);
		$user_id = $this->get_current_user()['id'];
		$address_found = $this->address->find($user_id, $address_id);

		if (!$address_found) {
			flash($this, 'flashError', 'Endereço não encontrado!');
			return redirect('address');
		}

		$address = $this->getPost();
		$datas = array(
			'page_title' => $this->getTitle(),
			'address' => $address,
			'method' => base_url('address/'.$address_id.'/edit')
		);

		if (!$this->validate_address()) {
			flash($this, 'flashError', 'Pussui(em) erro(s) no formulário!');
			return $this->template->load('dashboard',  'address/new', $datas);
		}


		if ($this->address->update($user_id, $address_id, $address)) {
			flash($this, 'flashSuccess', 'Endereço atualizado com sucesso!');
			redirect('address');
		}
	}

	public function check_main_address () {
		$this->beforeAction();

		if ($this->address->check_main($this->get_current_user()['id'], $this->uri->segment(2))) {
			flash($this, 'flashSuccess', 'Novo endereço marcado como principal');
			return redirect('address');
		}

		flash($this, 'flashSuccess', 'Este endereço não pôde ser marcado como principal.');
		return redirect('address');
	}

	public function delete_address () {
		$this->beforeAction();

		if ($this->address->delete($this->get_current_user()['id'], $this->uri->segment(2))) {
			flash($this, 'flashSuccess', 'Endereço excluído com sucesso!');
			return redirect('address');
		}

		flash($this, 'flashError', 'Este endereço não pode ser excluído!');
		return redirect('address');
	}

	private function getTitle() {
		return $this->page_title;
	}

	private function setTitle($title) {
		$this->page_title = $title;
	}

	private function get_current_user () {
		return $this->session->get_userdata('current_user')['current_user'];
	}

	private function beforeAction() {
		if (!$this->session->has_userdata('current_user'))
		return redirect('login');
	}

	private function getPost() {
		$adrs = $this->address;
		$adrs->id = $this->input->post("address[id]");
		$adrs->user_id = $this->input->post("address[user_id]");
		$adrs->address_name = $this->input->post("address[name]");
		$adrs->uf = $this->input->post("address[uf]");
		$adrs->city = $this->input->post("address[city]");
		$adrs->street = $this->input->post("address[street]");
		$adrs->number = $this->input->post("address[number]");
		$adrs->complement = $this->input->post("address[complement]");
		$adrs->neighborhood = $this->input->post("address[neighborhood]");
		$adrs->zip_code = $this->input->post("address[cep]");
		return $adrs;
	}

	private function validate_address () {
		$this->form_validation->set_rules('address[name]', 'Nome', 'trim|required',  array(
			'required'      => '<p class="error">Você deve informar um nome para o endereço!</p>',
			'trim'     => '<p class="error">O camo nome do endereço não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('address[street]', 'Rua', 'trim|required',  array(
			'required'      => '<p class="error">Você deve informar a descrição do endereço!</p>',
			'trim'     => '<p class="error">a descrição do endereço não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('address[complement]', 'Complemento', 'trim|required',  array(
			'required'      => '<p class="error">Você deve informar o complemento do endereço!</p>',
			'trim'     => '<p class="error">O camo complemento não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('address[neighborhood]', 'Bairro', 'trim|required',  array(
			'required'      => '<p class="error">Você deve informar o bairro!</p>',
			'trim'     => '<p class="error">O camo bairro não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('address[uf]', 'UF', 'trim|required',  array(
			'required'      => '<p class="error">Você deve informar o estado!</p>',
			'trim'     => '<p class="error">O camo UF não pode ser vazio!</p>'
		));

		$this->form_validation->set_rules('address[city]', 'Cidade', 'trim|required',  array(
			'required'      => '<p class="error">Você deve informar a cidade!</p>',
			'trim'     => '<p class="error">O camo cidade não pode ser vazio!</p>'
		));

		return $this->form_validation->run();
	}
}
?>
