<?php
function status_label ($status) {
  switch ($status) {
    case "Pendente":
    return "warning";
    break;
    case "Aprovado":
    return "success";
    break;
    case "Cancelado":
    return "danger";
    break;
  }
}

function status_message ($status) {
  switch ($status) {
    case "Pendente":
    return "Aguardando Aprovação";
    break;
    case "Aprovado":
    return "Pedido Aprovado";
    break;
    case "Cancelado":
    return "Pedido Rejeitado";
    break;
  }
}

?>
