<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {
	private $page_title;


	public function __construct() {
		parent::__construct();
		$this->setTitle('Login');
		$this->load->model('user_model', 'userInstance');
	}

	public function index() {
		if ($this->session->has_userdata('current_user')) {
			return redirect('dashboard');
		}
		return redirect('login');
	}

	private function getUserModel() {
		return $this->userInstance;
	}

	public function sign_in() {
              //clear_flashes($this);
		$datas = array();
		$datas['logout_url'] = $this->facebook->get_logout_url();

          	if ($this->session->has_userdata('current_user')) {
                   		return redirect('dashboard');
                	}

             	      //print_r($this-> session->all_userdata());

                	$user = $this->getUserModel();

                	$datas['login_url'] = $this->facebook->get_login_url();
                	$datas['page_title']  = $this->getTitle();
                	$datas['user'] = $user;

                	$this->template->load('login', '/login/sign_in', $datas);
          }

          public function sign_in_facebook() {

          	$user['user_token_facebook']  = ($this->session->all_userdata()['fb_token']) ? $this->session->all_userdata()['fb_token'] : null;
          	$user['id'] =  $this->facebook->get_user()['id'];
          	$user['name'] =  $this->facebook->get_user()['name'];
          	$user['email'] =  $this->facebook->get_user_email();
		$user['logout_url'] = $this->facebook->get_logout_url();
		$user['logged_in'] = TRUE;

		$user_found = $this->getUserModel()->findByEmail($this->facebook->get_user_email());

		if($user_found) {
			$datas = array( 'user' => $user_found);
			$this->create_session($user_found);
			flash($this, 'flashSuccess', 'Login realizado com sucesso!');
	                    return redirect('dashboard');
		}

		$user = $this->getUserModel();
		$user->setName($this->facebook->get_user()['name']);
		$user->setEmail($this->facebook->get_user_email());
		$user->setActive(true);

		$user_facebook_registered = $this->register_facebook_user($user);

		if($user_facebook_registered) {
			$datas = array( 'user' => $user_facebook_registered);
			$this->create_session($user_facebook_registered);
			flash($this, 'flashSuccess', 'Login realizado com sucesso!');
	                    return redirect('dashboard');
		}

		//print_r($this->session->get_userdata('current_user'));

          }

          public function sign_out () {
             	$this->destroy_session();
             	return redirect('login');
          }

           public function authenticate_user($user) {

	          $user = $this->getPost(null);
	          $this->validate_post();

	          $datas = array(
	                  'page_title' => $this->getTitle(),
	                  'user' => $user,
	                  'login_url' => $this->facebook->get_login_url()
	          );

	          if (!$this->validate_post()) {
	                 flash($this, 'flashError', 'Pussui(em) erro(s) no formulário!');
	                 return   $this->template->load('login', 'login/sign_in', $datas);
	          }

	          $user_found = $this->getUserModel()->findByEmail($user->getEmail());

	          if ($user_found && $user_found->getActive() == true && $this->comparePasswords($user->getPassword(), $user_found->getPassword())) {
	                   $this->create_session($user_found);
	                   flash($this, 'flashSuccess', 'Login realizado com sucesso!');
	                   return redirect('dashboard');
	          }

	          flash($this, 'flashError', 'Login/Senha incorreto(a) ou Conta inativada!');
	          return $this->template->load('login', 'login/sign_in', $datas);
         }

         private function comparePasswords($password, $correct_password) {
	         	if (sha1(trim($password)) === trim($correct_password))
	         		return true;
	         	return false;
         }

         public function isAuthenticated($user) {
	         	if (isset($user) && $this->session->userdata('current_user')['email'] === $user->getEmail())
	         		return true;
	         	return false;
         }

         private function getTitle() {
         		return $this->page_title;
         }

         private function setTitle($title) {
         		$this->page_title = $title;
         }

         public function getPost($u) {
         		$user = (is_null($u)) ? $this->getUserModel() : $u;
         		$user->setEmail($this->input->post("user[email]"));
         		$user->setPassword($this->input->post("user[password]"));
         		return $user;
         }

         private function destroy_session() {
         	          if ($this->session->has_userdata('current_user'))
                               return $this->session->unset_userdata('current_user');  //$this->session->sess_destroy();
                    return false;
          }

             private function create_session($user) {

             	$new_session = array (
             		'id' => $user->getId(),
             		'name' => $user->getName(),
             		'email' => $user->getEmail(),
             		'logged_in' => TRUE
             	);

             	$this->session->set_userdata('current_user', $new_session);

             	return true;
             }

             public function validate_post() {

             	$this->form_validation->set_rules('user[email]', 'Email', 'trim|required',  array(
             		'required'      => 'Você deve informar seu email ',
             		'trim'     => 'O campo de email não pode ser vazio!'
             		));

             	$this->form_validation->set_rules('user[password]', 'Password', 'trim|required', array(
             		'required'      => 'Você deve informar sua senha',
             		'trim'     => 'O campo de senha não pode ser vazio!'
             		));

             	return $this->form_validation->run();
             }

           private function register_facebook_user($user) {
           	if($this->getUserModel()->create($user))
			return $this->getUserModel()->findByEmail($user->getEmail());
           }

 }

 ?>