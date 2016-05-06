<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(APPPATH.'controllers/LoginController.php');

class UserController extends CI_Controller {

	private $page_title = '';
	private $user;

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model', 'userInstance');
	}

	private function getUserModel() {
		return $this->userInstance;
	}

	private function getTitle() {
		return $this->page_title;
	}

	private function setTitle($title) {
		$this->page_title = $title;
	}

	public function new_user ($user = null) {

		$this->setTitle('Nova Conta');

		if (is_null($user)) { $this->user  = $user; } else { $this->user  = $this->getUserModel(); }

		$datas = array(
			'page_title' => $this->getTitle(),
			'new_user' => $this->user
			);

		$this->template->load('login', 'users/new', $datas);
	}

	public function create_user () {

		$this->getPost(null);

		$datas = array(
			'page_title' => $this->getTitle(),
			'new_user' => $this->user
			);

		if (!$this->validate_post()) {
			flash($this, 'flashError', 'Pussui(em) erro(s) no formulário!');
			return $this->template->load('login', 'users/new', $datas);
		}

		if ($this->user->getPassword() !== $this->input->post("user[password_confirm]")) {
			flash($this, 'flashError', 'Senha informada diferente de senha de confirmação!');
			return $this->template->load('login', 'users/new', $datas);
		}

		if($this->getUserModel()->findByEmail($this->user->getEmail())) {
			flash($this, 'flashError', 'Email já cadastrado!');
			return $this->new_user($this->user);
		}

		if($this->getUserModel()->create($this->user)) {
			$user = $this->getUserModel()->findByEmail($this->user->getEmail());
			$this->senEmail($user);
			flash($this, 'flashInfo', 'Cadastro realizado com sucesso! Um email foi enviado para sua conta de email com o link de ativação desta conta.');
			redirect('login');
		}
	}

	public function edit_user () {

		$this->setTitle('Editar Conta');

		($this->uri->segment(2) != 0)  ? $id  = $this->uri->segment(2) : '';

		$user = $this->getUserModel()->findById($id);

            //Verificar se o usuário corrente logado é o mesmo usuário procurado para edição

		if ($user) {
			$datas = array(
				'page_title' => $this->getTitle(),
				'user' => $user
				);

			$this->template->load('dashboard', 'users/edit', $datas);
			return true;
		}

		flash($this, 'flashError', 'Usuário não cadastrado! Efetue o novo cadastro acima.');
		return redirect('account');
	}

	public function update_user () {

		($this->uri->segment(2) != 0)  ? $id  = $this->uri->segment(2) : '';

             // Verificar novamente se usuário existe antes de atualizá-lo por questão de segura
		$user = $this->getUserModel()->findById($id);

            if (!$user) { //Se o usuário não for encontrado para atualização a ágina é redirecionada para o login
            	flash($this, 'flashError', 'Usuário não encontrado para atualização!');
            	return redirect('account');
            }


            	$this->user = (is_null($user)) ? $this->getUserModel() : $user;
            	$this->user->setName($this->input->post("user[name]"));
          	$this->user->setPhone1($this->input->post("user[phone1]"));
          	$this->user->setPhone2($this->input->post("user[phone2]"));

            $datas = array(
            	'page_title' => $this->getTitle(),
            	'user' => $this->user
            	);


            if(!$this->validate_post_update()) {
            	flash($this, 'flashError', 'Pussui(em) erro(s) no formulário!');
            	return $this->template->load('dashboard', 'users/edit', $datas);
            }


            if ($this->getUserModel()->update($this->user)) {
            	flash($this, 'flashSuccess', 'Dados atualizados com sucesso!');
            	return $this->template->load('dashboard', 'users/edit', $datas);
            }

            flash($this, 'flashError', 'Ocorreu um erro ao tentar atualizar seus dados!');
            return $this->template->load('dashboard', 'users/edit', $datas);
          }

          public function get_user () {

          	$this->setTitle('Visualizar Conta');
          	($this->uri->segment(2) != 0)  ? $id  = $this->uri->segment(2) : '';

          	$user = $this->getUserModel()->getUser($id);

            if (!$user) { //Se o usuário não for encontrado para atualização a ágina é redirecionada para o login
            	$datas = array('page_title' => $this->getTitle());
            	flash($this, 'flashError', 'Usuário inexistente!');
            	return $this->template->load('dashboard', 'users/index', $datas);
            }

            $datas = array(
            	'page_title' => $this->getTitle(),
            	'user' => $user
            	);

            return $this->template->load('dashboard', 'users/index', $datas);
          }

          public function find_user() {
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]',  array(
                         'required'      => 'Por favor, informe seu %s.',
                         'max_length'     => 'Seu email deve possuir no máximo 50 caracteres.'
                    ));

                    $user = $this->getUserModel();
                    $user->setEmail($this->input->post("email"));
                    $datas = array( 'new_user' => $user);

                    if (!$this->form_validation->run()) {
                           flash($this, 'flashError', 'Email inválido!');
                           return redirect('login');
                    }

                    if ($this->getUserModel()->findByEmail($user->getEmail())) {
                           flash($this, 'flashError', 'Email já cadastrado!');
                           return redirect('login');
                    }

                    return $this->new_user($user);
          }

          public function getPost($user) {
          	$this->user = (is_null($user)) ? $this->getUserModel() : $user;
          	$this->user->setName($this->input->post("user[name]"));
          	$this->user->setEmail($this->input->post("user[email]"));
          	$this->user->setPassword($this->input->post("user[password]"));
          	$this->user->setPhone1($this->input->post("user[phone1]"));
          	$this->user->setPhone2($this->input->post("user[phone2]"));
          }

          public function validate_post() {

          	$this->form_validation->set_rules('user[name]', 'Name', 'trim|required|max_length[50]',  array(
          		'required'      => 'Por favor, informe seu %s.',
          		'max_length'     => 'Seu nome deve possuir no máximo 50 caracteres'
          		));

          	$this->form_validation->set_rules('user[email]', 'Email', 'trim|required|max_length[30]',  array(
          		'required'      => 'Por favor, informe seu  %s.',
          		'max_length'     => 'Seu %s deve possuir no máximo 30 caracteres'
          		));

          	$this->form_validation->set_rules('user[password]', 'Password', 'trim|required|min_length[6]|max_length[20]', array(
          		'required'      => 'Por favor, informe sua %s.',
          		'min_length'     => 'Sua %s deve possuir no mínimo 6 caracteres'
          		));

          	$this->form_validation->set_rules('user[password_confirm]', 'Password Confirm', 'trim|required|min_length[6]', array(
          		'required'      => 'Por favor, informe seu sua %s.',
          		'min_length'     => 'Sua %s deve possuir no mínimo 6 caracteres'
          		));

          	$this->form_validation->set_rules('user[phone1]', 'Telefone 1', 'trim|required|max_length[30]', array(
          		'required'      => 'Por favor, informe seu %s.',
          		'max_length'     => 'Este campo não deve possuir mais que 50 caracteres'
          		));

          	$this->form_validation->set_rules('user[phone2]', 'Telefone 2', 'trim|required|max_length[30]', array(
          		'required'      => 'Por favor, informe seu %s.',
          		'max_length'     => 'Este campo não deve possuir mais que 50 caracteres'
          		));

          	$this->form_validation->set_error_delimiters('<font size="3" color="red" class="error">', '</font><br>       ');

          	return $this->form_validation->run();
          }

          public function validate_post_update () {
          	$this->form_validation->set_rules('user[name]', 'Name', 'trim|required|max_length[50]',  array(
          		'required'      => 'Por favor, informe seu %s.',
          		'max_length'     => 'Este campo não deve possuir mais que 50 caracteres'
          		));

          	$this->form_validation->set_rules('user[phone1]', 'Telefone 1', 'trim|required|max_length[30]', array(
          		'required'      => 'Por favor, informe seu %s.',
          		'max_length'     => 'Este campo não deve possuir mais que 50 caracteres'
          		));

          	$this->form_validation->set_rules('user[phone2]', 'Telefone 2', 'trim|required|max_length[30]', array(
          		'required'      => 'Por favor, informe seu seu %s.',
          		'max_length'     => 'Este campo não deve possuir mais que 50 caracteres'
          		));
          	return $this->form_validation->run();
          }

       public function active_account() {

          	$hash_activate = trim($this->uri->segment(3)) ;
          	$user = $this->getUserModel()->findHashActivation($hash_activate);

          	if($user) {
          		$user->setActive(true);
          		$user->setActivationLink(NULL);
          	       $this->getUserModel()->active_account($user);

          		$new_session = array (
	             		'id' => $user->getId(),
	             		'name' => $user->getName(),
	             		'email' => $user->getEmail(),
	             		'logged_in' => TRUE
	             		);

             		$this->session->set_userdata('current_user', $new_session);

             		 return redirect('dashboard');
             	       //autenticar usuário e redirecionar para o dashboard; $_SERVER['REQUEST_URI']
          	}

          	return redirect('404_override');
       }

      public function senEmail($user) {

      		try{
      			$this->email->clear();
                    $this->load->library('email');
                    $this->email->initialize($this->config->item('config_email'));
                    $this->output->set_content_type('text/plain', 'UTF-8');
                    //$this->email->set_newline("\r\n");
			$this->email->to($user->getEmail());
        		$this->email->from('contato@casadopirogue.com.br', 'Casa do Pirogue');
        		$this->email->subject('Casa do Pirogue [Ativação da Conta]');
        		$data = array( 'user'=> $user );
        		$body = $this->load->view('emails/sign_up_confirmation', $data, TRUE);
        		$this->email->message($body);
        		$this->email->send();
        		 //		$this->email->print_debugger();
        		 return true;
        	} catch (Exception $e) {
			echo 'Ocorreu um erro ao tentar enviar email de confirmação de conta: ',  $e->getMessage(), "\n";
			return false;
		}

      }
}

?>