<?php

function form_sign_in($action_url, $params = '', $user) {
	echo form_open($action_url, $params);

	echo form_label("E-mail ", "email");
	echo form_input(array(
		"name" =>
		"user[email]",
		"id" => "email",
		"class" => "form-control",
		"value" => $user->getEmail()
	));
	echo "<p></p>";

	echo form_label("Senha ", "senha");
	echo form_password(array(
		"name" => "user[password]",
		"id" => "password",
		"class" => "form-control",
		"value" => $user->getPassword()
	));
	echo "<p></p>";

	echo form_button(array(
		"class" => "btn btn-primary",
		"content" => "Login",
		"type" => "submit"
	));

	echo form_close();
}

function form_sign_up($action_url, $new_user,  $params) {

	echo form_open($action_url, $params);

	echo form_label("Nome ", "name");
	echo form_input(array(
		"name" => "user[name]",
		"id" => "name",
		"class" => "form-control",
		"value" => $new_user->getName()
		));
	echo "<p></p>";

	echo form_label("E-mail ", "email");
	echo form_input(array(
		"name" => "user[email]",
		"id" => "email",
		"class" => "form-control",
		"value" => $new_user->getEmail()
		));
	echo "<p></p>";

	echo form_label("Senha ", "password");
	echo form_password(array(
		"name" => "user[password]",
		"id" => "password",
		"class" => "form-control",
		"value" => $new_user->getPassword()
		));
	echo "<p></p>";

	echo form_label("Confirmar Senha ", "password_confirm");
	echo form_password(array(
		"name" => "user[password_confirm]",
		"id" => "password_confirm",
		"class" => "form-control"
		));
	echo "<p>";
	echo form_label("Telefone 1", "phone1");
	echo form_input(array(
		"name" => "user[phone1]",
		"id" => "phone1",
		"class" => "form-control",
		"value" => $new_user->getPhone1()
		));
	echo "<p>";
	echo form_label("Telefone 2 ", "phone2");
	echo form_input(array(
		"name" => "user[phone2]",
		"id" => "phone2",
		"class" => "form-control",
		"value" => $new_user->getPhone2()
		));
	echo "<p>";
	echo form_button(array(
		"class" => "btn btn-primary",
		"content" => "Cadastrar",
		"type" => "submit"
		));

	echo form_close();
}

function form_update_account ($action_url, $new_user,  $params) {

	echo form_open($action_url, $params);

	echo form_label("Nome ", "name");
	echo form_input(array(
		"name" => "user[name]",
		"id" => "name",
		"class" => "form-control",
		"value" => $new_user->getName()
		));
	echo "<p></p>";
	echo form_label("Telefone 1", "phone1");
	echo form_input(array(
		"name" => "user[phone1]",
		"id" => "phone1",
		"class" => "form-control",
		"value" => $new_user->getPhone1()
		));
	echo "<p>";
	echo form_label("Telefone 2 ", "phone2");
	echo form_input(array(
		"name" => "user[phone2]",
		"id" => "phone2",
		"class" => "form-control",
		"value" => $new_user->getPhone2()
		));
	echo "<p>";
	echo form_button(array(
		"class" => "btn btn-primary",
		"content" => "Atualizar",
		"type" => "submit"
		));

	echo form_close();

}

function form_update_password($action_url,  $params) {

	echo form_open($action_url, $params);

	echo form_password(array(
		"name" => "user[password]",
		"id" => "password",
		"class" => "form-control"
	));
	echo "<p></p>";

	echo form_label("Confirmar Senha ", "password_confirm");
	echo form_password(array(
		"name" => "user[password_confirm]",
		"id" => "password_confirm",
		"class" => "form-control"
	));
	echo "<p>";

	echo form_button(array(
		"class" => "btn btn-primary",
		"content" => "Atualizar Senha",
		"type" => "submit"
	));

	echo form_close();
}

function showUser($user) {
	echo '<p>Código: '.$user->getId().'</p>';
	echo '<p>Nome: '.$user->getName().'</p>';
	echo '<p>Email: '.$user->getEmail().'</p>';
	echo '<p>Telefone: '.$user->getPhone1().'</p>';
	echo '<p> <b>Ações:</b>';
	echo anchor("account/{$user->getId()}", 'Visualizar', 'title="Visualizar Conta" ');
	echo '&nbsp;&nbsp;';
	echo anchor("account/{$user->getId()}/edit", 'Editar', 'title="Editar Conta" ');
	echo '&nbsp;&nbsp;';
	echo anchor("account", 'Novo', 'title="Nova Conta" ');
	echo '&nbsp;&nbsp;';
	echo anchor('dashboard', 'Dashboard', 'title="Ir para o Dashboard"') ;
}

?>