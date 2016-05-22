 <section>
 	<div class="pg pg-login">
 		<div class="container">
 			<div class="row">
 				<div class="col-md-6">
 					<div class="login">
 						<p>Login <i class="fa fa-sign-in" aria-hidden="true"></i></p>
 						<?=  form_sign_in('login', $login_url, $user); ?>
 						<!-- <div class="erros-form-login"> <?= validation_errors(); ?> </div> -->
 					</div>
 				</div>
 				<div class="col-md-6 borda">
 					<div class="cadastro">
 						<p>Sou um novo cliente <i class="fa fa-user" aria-hidden="true"></i></p>
 						<?= form_open('account/new'); ?>

 						<?=  '<div class="form-group">'; ?>
 						<?= form_label("E-mail ", "email", array("class"=>"hidden")); ?>
 						<?= form_input(array(
 							"name" => "email",
 							"type" => "email",
 							"id" => "email",
 							"class" => "form-control",
 							"value" => "",
 							"placeholder" => "E-mail"
 							));
 						  ?>
 						  <?= '</div>'; ?>

 						  <?=  '<div class="form-group">'; ?>
							<?=  form_button(array(
								"class" => "cadastrar",
								"type" => "submit",
								"content" => "Cadastre-se Agora !"
							));
							?>

							<?=  form_close(); ?>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>