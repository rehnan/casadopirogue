<!DOCTYPE html>
<html lang="pt">
<head>
      <meta http-equiv="Content-type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Casa do Pirogue<?php if (isset($page_title)) { echo ' | '.$page_title; } ?></title>

      <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed:400,700italic,400italic,700,300,300italic' rel='stylesheet' type='text/css'>

      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/owl.carousel.min.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/animate.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/jquery.steps.css") ?>" />
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/site.css") ?>" />
      <!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" /> -->
</head>
<body>
<!-- TOPO -->
   <div class="topo" id="topo">
      <nav class="navbar" role="navigation">

         <div class="container">

            <div class="row">
               <div class="col-md-3">
                  <!-- LOGO -->
                  <a href="#" title="Casa do Pirogue">
                     <h1>
                        Casa do Pirogue
                     </h1>
                  </a>
                  <!-- LOGOTIPO / MENU MOBILE-->
                  <div class="navbar-header">


                     <!-- MENU MOBILE TRIGGER -->
                     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                     </button>

                  </div>
               </div>
               <div class="col-md-9 text-center">
                  <!-- MENU -->
                  <nav class="collapse navbar-collapse" id="collapse">

                     <ul class="nav navbar-nav">

                        <li><a href="#">Home</a></li>
                        <li><a href="#">Nossos Produtos</a></li>
                        <li><a href="#">Pedidos Online</a></li>
                        <li><a href="#">Sobre nós</a></li>
                        <li><a href="#contato" id="contato">Contato</a></li>

                     </ul>

                  </nav>
               </div>
            </div>
         </div>
      </nav>
   </div>
<div class="container">
      <div class="pg pg-minha-conta">
           <div class="container">
               <center><p class="titulo">Área do Cliente <i class="fa fa-user" aria-hidden="true"></i></p></center>
               <div class="row borda">
                  <div class="col-md-3">
                     <div class="sidebar">
                        <div class="perfil">
                           <div class="foto" title="Fernando">

                           </div>
                           <span title="Fernando" >Nome do Usuário Logado</span>
                           <p><?= anchor('logout', 'Sair', 'title="Sair" class="sair"') ?> <span><i class="fa fa-sign-out" aria-hidden="true"></i> </span></p>
                        </div>
                        <a href="<?= base_url('order') ?>" class="menu">Fazer Pedido</a>
                        <a href="<?= base_url('my-orders') ?>" class="menu">Meus pedidos</a>
                        <a href="<?= base_url('address') ?>" class="menu">Meus Endereços</a>
                        <a href="" class="menu">Meus dados cadastrais</a>
                     </div>
                  </div>
                  <div class="col-md-9">
                        <div class="panel-body">
                        <?php require_once '_flashes.php'; ?>
                        <div id="ajax-flashes"></div>
                        <p class="mensagem-conta">Olá <span>Hudson</span> seja bem vindo a sua conta na <i>Casa do Pirogue!</i> Para realiza alterações em sua conta utilize o menu ao lado.</p>
