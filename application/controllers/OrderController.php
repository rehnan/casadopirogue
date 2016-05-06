<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends CI_Controller {
   private $page_title;

   public function __construct() {
      parent::__construct();
      $this->setTitle('Novo Pedido');
      $this->load->model('user_model', 'userInstance');
      $this->load->model('order_model', 'order');
      $this->load->model('item_model', 'item');
   }

   public function new_order () {

      $this->beforeAction();


      $order = $this->create_order();

      $datas = array(
         'page_title' => $this->getTitle(),
         'facebook_logout_url' => $this->facebook->get_logout_url(),
         'order' => $order,
         'itens_order' => $this->count_itens_order($order->id)
         );

        //Depois verificar se há algum pedido em aberto
      $this->template->load('dashboard',  'order/new', $datas);

   }

   private function create_order () {
         return $this->order->create($this->get_current_user()['id']);
   }

   public function count_itens_order ($order_id) {
         return $this->item->count_itens($order_id, $this->get_current_user()['id']);
   }


   public function delete_order() {

   }

   public function add_item () {
      $this->load->helper('form');
        print_r($_POST);
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



}