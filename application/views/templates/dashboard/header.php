<!DOCTYPE html>
<html lang="pt">
<head>
      <meta http-equiv="Content-type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Casa do Pirogue<?php if (isset($page_title)) { echo ' | '.$page_title; } ?></title>

<!--       <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed:400,700italic,400italic,700,300,300italic' rel='stylesheet' type='text/css'>
 -->
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/owl.carousel.min.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/animate.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/jquery.steps.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/site.css") ?>" />
      <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
</head>
<body>
<header>Header Dashboard</header>
<div class="container">
      <div class="pg pg-minha-conta">
           <div class="container">
               <center><p class="titulo">Área do Cliente <i class="fa fa-user" aria-hidden="true"></i></p></center>
               <div class="row borda">
                  <div class="col-md-3">
                     <div class="sidebar">
                        <div class="perfil">
                           <div class="foto" title="Fernando" style="background: url(img/face.jpg);">

                           </div>
                           <span title="Fernando" >Nome do Usuário Logado</span>
                           <p><?= anchor('logout', 'Deslogar', 'title="Sair" class="sair"') ?> <span><i class="fa fa-sign-out" aria-hidden="true"></i> </span></p>
                        </div>
                        <a href="<?= base_url('order') ?>" class="menu">Novo Pedido</a>
                         <a href="" class="menu">Meus dados cadastrais</a>
                        <a href="<?= base_url('my-orders') ?>" class="menu">Meus pedidos</a>
                        <a href="<?= base_url('address') ?>" class="menu">Meu endereço</a>
                     </div>
                  </div>
                  <div class="col-md-9">
                        <div class="panel-body">
                        <?php require_once '_flashes.php'; ?>
                        <div id="ajax-flashes"></div>






