<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
   <meta http-equiv="content-type" content="text/html" charset="UTF-8">
       <title>Casa do Pirogue | Requisição de Pedido</title>
   </head>
   <body>
      <section>
      <h1>Requisição de Pedido</h1>
      <article>
            Informações do Pedido:
      </article>
      Aceitar Requisição de Pedido:
      <p>Link: <a href=<?php echo "http://{$_SERVER['SERVER_NAME']}/casadopirogue/order/to_approve/{$order->getActivationLink()}"  ?> title="Link de Ativação"> Link de Ativação </a></p>
      Recusar Requisição de Pedido:
      <p>Link: <a href=<?php echo "http://{$_SERVER['SERVER_NAME']}/casadopirogue/order/to_disapprove/{$user->getActivationLink()}"  ?> title="Link de Ativação"> Link de Ativação </a></p>
      </section>
     <p> Novo pedido! </p>

   </body>
</html>