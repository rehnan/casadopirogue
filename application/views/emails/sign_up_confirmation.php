<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
   <meta http-equiv="content-type" content="text/html" charset="UTF-8">
       <title>Casa do Pirogue | Ativação Da Conta</title>
   </head>
   <body>
     <p> Olá <?php echo $user->getName() ?>, clique no link de ativação abaixo para ativar sua conta. </p>
     <p>Link: <a href=<?php echo "http://{$_SERVER['SERVER_NAME']}/casadopirogue/account/active_account/{$user->getActivationLink()}"  ?> title="Link de Ativação"> Link de Ativação </a></p>
   </body>
</html>