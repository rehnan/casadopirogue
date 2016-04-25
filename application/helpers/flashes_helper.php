<?php

function flash($context, $type, $message) {
    clear_flashes($context);
    return  $context->session->set_flashdata($type, $message);
}

function clear_flashes($context) {
    $context->session->unset_userdata('flashSuccess');
    $context->session->unset_userdata('flashError');
    $context->session->unset_userdata('flashInfo');
    $context->session->unset_userdata('flashWarning');
}

?>