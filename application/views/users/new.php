<section>
    <?php echo 'New Account!'; ?>
    <?php echo form_sign_up('account', $new_user, ''); ?>
     <?= anchor('login', 'Login', 'title="Página de Login"') ?>
    <?php echo validation_errors(); ?>
</section>