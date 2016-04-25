<section>
    <?= 'Log In'; ?>
    <?=  form_sign_in('login', '', $user); ?>
    <br>
    <?= anchor($login_url, 'Login Facebook', 'title="Logar com Facebook"') ?>
    <?= anchor('account', 'Cadastrar-se', 'title="Criar um novo cadastro"') ?>
    <?=  validation_errors(); ?>
</section>