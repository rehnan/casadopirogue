<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <title>Casa do Pirogue | Recuperação de Senha</title>

  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed:400,700italic,400italic,700,300,300italic' rel='stylesheet' type='text/css'>

</head>
<body style="border:solid 1px #ccc;border-radius:6px;font-family:Roboto;">
  <!-- TOPO -->
  <header style="text-align:center;height:150px;padding-top:30px;">
    <div class="topo" id="topo">
      <nav class="navbar" role="navigation">
        <div class="container">
          <div class="row text-center">
            <!-- LOGO -->
            <a href="http://www.casadopirogue.com.br" title="Casa do Pirogue">
              <?php echo "<img alt='' src='http://".$_SERVER['SERVER_NAME'].base_url('assets/img/logo3.png')."' />" ; ?>
            </a>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <hr>
  <section>
    <br>
    <h3><center>Recuperação de Senha</center></h3>
    <div style="margin-left: 30px">
      <article>
        <p>Olá, <?= $user->name ?>!</p>
        <p>Clique no link para atualizar sua senha: <a href=<?php echo "http://{$_SERVER['SERVER_NAME']}/delivery/user/password_recovery/{$user->reset_password_link}"  ?> title="Clique para atualizar sua senha"> Atualizar Senha </a></p>
      </article>
    </div>
  </section>
</body>
</html>
