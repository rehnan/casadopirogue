<?php

function flash($context, $type, $message) {
  clear_flashes($context);
  $btn_close_flash = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
  switch ($type) {
     case "flashSuccess":
          $msg = "<div class='alert alert-success' role='alert'>".$btn_close_flash.$message."</div>";
     break;
     case "flashError":
          $msg = "<div class='alert alert-danger' role='alert'>".$btn_close_flash.$message."</div>";
     break;
     case "flashInfo":
           $msg = "<div class='alert alert-info' role='alert'>".$btn_close_flash.$message."</div>";
     break;
     case "flashWarning":
           $msg = "<div class='alert alert-warning' role='alert'>".$btn_close_flash.$message."</div>";
     break;
  }

  return  $context->session->set_flashdata($type, $msg);
}

function clear_flashes($context) {
  $context->session->unset_userdata('flashSuccess');
  $context->session->unset_userdata('flashError');
  $context->session->unset_userdata('flashInfo');
  $context->session->unset_userdata('flashWarning');
}

?>