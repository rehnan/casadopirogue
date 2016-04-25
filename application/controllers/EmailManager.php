<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailManager {
     private $to;
     private $from;
     private $subject;
     private $message;

     public function __construct($infos) {
            $this->to = infos['to'];
            $this->from = infos['from'];
            $this->subject = infos['subject'];
            $this->message = infos['message'];
            $this->load->library('email');
            $this->email->clear();

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://br714.hostgator.com.br',
                'smtp_port' => 465,
                'smtp_user' => 'carol681',
                'smtp_pass' => '2U8nyq7vN7',
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1'
            );

            $this->load->library('email', $config);

      }

     public function setTo($to) {
            $this->to = $to;
     }

     public function setFrom($from) {
            $this->from = $from;
     }

     public function setSubject($to) {
            $this->subject = $subject;
     }

     public function setMessage($message) {
            $this->message = $message;
     }

     public function getTo () {
        return $this->to;
     }

      public function getFrom () {
        return $this->from;
     }

      public function getSubject () {
        return $this->subject;
     }

      public function getMessage () {
        return $this->message;
     }

     public function send() {
        $this->email->to('rehnancarolinoo@gmail.com');
        $this->email->from('contato@casadopirogue.com.br');
        $this->email->subject('Teste de envio de email ');
        $this->email->message('Hi Rehnan, Here is the info you requested.');
        $this->email->send();
        //$this->email->send();
     }



/*$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'xxx',
    'smtp_pass' => 'xxx',
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1'
);
$this->load->library('email', $config);
$this->email->set_newline("\r\n");

// Set to, from, message, etc.

$result = $this->email->send();


    $this->email->clear();

    $this->email->to($address);
    $this->email->from('your@example.com');
    $this->email->subject('Here is your info '.$name);
    $this->email->message('Hi '.$name.' Here is the info you requested.');
    $this->email->send();

    Fonte: http://stackoverflow.com/questions/1555145/sending-email-with-gmail-smtp-with-codeigniter-email-library
*/

}