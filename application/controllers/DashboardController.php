<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {
      private $page_title;

      public function __construct() {
            parent::__construct();
            $this->setTitle('Dashboard');
            $this->load->model('user_model', 'userInstance');
            $this->load->model('item_model', 'item');
      }

      public function index() {
            $this->beforeAction();

            $datas = array(
                        'page_title' => $this->getTitle(),
                        'facebook_logout_url' => $this->facebook->get_logout_url(),
                        'itens' => $this->item->findAll()
            );

            //print_r($this->session->all_userdata());
            $this->template->load('dashboard',  'dashboard/index', $datas);
      }

      public function getItems()  {

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

      private function beforeAction() {
            if (!$this->session->has_userdata('current_user'))
                  return redirect('login');
      }
}


?>
