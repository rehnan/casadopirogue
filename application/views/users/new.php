<section>
   <article>
     <?php echo 'New Account!'; ?>
     <?php echo form_sign_up('account', $new_user, ''); ?>
     <?= anchor('login', 'Voltar para o Login', 'title="Página de Login"') ?>
     <br>
     <?php echo validation_errors(); ?>
  </article>
</section>
