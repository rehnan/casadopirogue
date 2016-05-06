<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	public $id;
	public $name;
	public $email;
	public $password;
	public $phone1;
	public $phone2;
	public $active;
	public $activation_link;
	public $reset_password_link;

	public function __construct() {
		parent::__construct();
		$this->name = '';
		$this->email = '';
		$this->password = '';
		$this->phone1 = '';
		$this->phone2 = '';
	}

	public function create($user) {
		try
		{
			$linkActivation =   str_shuffle(sha1($user->getEmail().$user->getName()).sha1(date("Y-m-d H:i:s")));
			$user->setPassword(sha1($user->getPassword()));
			$user->setActivationLink($linkActivation);
			if (isset($user) && $this->db->insert('user',  $user))
				return true;
		}
		catch (Exception $e) {
			echo 'ocorreu um erro ao tentar cadastrar: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	public function findByEmail ($email) {
		$this->db->where("email", $email);
		$get = $this->db->get('user');
		$get->result_array();
		if ($get->num_rows() > 0)
			return $get->row(0, 'user_model');
		return false;
	}

	public function findById ($id) {
		$this->db->where("id", $id);
		$get = $this->db->get('user');
		$get->result_array();
        //print_r($get->result_array());
		if ($get->num_rows() > 0)
			return $get->row(0, 'user_model');
		return false;
	}

	public function update($user) {
		$this->db->where("id", $user->getId());
		$updated = $this->db->update("user",$user);
		if ($updated > 0) { return true; }
		return false;
	}

	public function getUser($id) {
		$user = $this->findById($id);
		if ($user) {
			return $user;
		}
		return false;
	}

	public function active_account($user) {
		$this->db->where('id', $user->getId());
             $actived = $this->db->update('user', $user);
             if(isset($actived) && $actived > 0)
              	return true;
        	return false;
	}

	public function findHashActivation($hash) {
		$this->db->where("activation_link", $hash);
		$get = $this->db->get('user');
		$get->result_array();
		if ($get->num_rows() > 0)
			return $get->row(0, 'user_model');
		return false;
	}

     //Getters and Setters
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getName () {
		return $this->name;
	}

	public function getEmail () {
		return $this->email;
	}

	public function getPassword () {
		return $this->password;
	}

	public function getPhone1() {
		return $this->phone1;
	}

	public function getPhone2() {
		return $this->phone2;
	}

	public function getActive() {
		return $this->active;
	}

	public function getActivationLink() {
		return $this->activation_link;
	}

	public function getResetPasswordLink() {
		return $this->reset_password_link;
	}

	public function setName ($name) {
		$this->name = $name;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setPhone1 ($phone1) {
		$this->phone1 = $phone1;
	}

	public function setPhone2 ($phone2) {
		$this->phone2 = $phone2;
	}

	public function setActive ($active) {
		$this->active = $active;
	}

	public function setActivationLink ($link) {
		$this->activation_link = $link;
	}

	public function setResetPasswordLink ($resetLink) {
		$this->reset_password_link = $resetLink;
	}



}

 /*
        Fonte: http://oscardias.com/br/desenvolvimento/php/codeigniter/criando-um-app-usando-codeigniter-parte-5-projetos/

        $this->db->where('user', $user);
        $this->db->order_by('name', 'asc');
        $get = $this->db->get('project');

        if($get->num_rows > 0) return $get->result_array();
        return array();*/

        ?>