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

	public function generate_link_reset_password ($email) {

			$user = $this->findByEmail($email);
			if (!$user) { return false; };

			$linkResetPswd = str_shuffle(sha1($user->getEmail().$user->getName()).sha1(date("Y-m-d H:i:s")));

			$where =  array('email' => $email);
			$this->db->set('reset_password_link', $linkResetPswd);
			$this->db->where($where);

			if ($this->db->update("user")) {
				$user = $this->findById($user->id);
				return $user;
			}
			return false;
	}

	public function find_link_reset_password ($hash) {

		$where =  array('reset_password_link' => $hash);
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where($where);

		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->custom_result_object('user_model')[0] : false;
	}

	public function password_update ($user_id, $hash, $pswd) {

		$user = $this->find_link_reset_password($hash);

		if ($user && $user->id === $user_id) {
			$password = sha1($pswd);
			$where =  array('id' => $user_id);
			$this->db->set('password', $password);
			$this->db->set('reset_password_link', null);
			$this->db->where($where);
			return ($this->db->update("user")) ? true : false;
		}
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

?>
