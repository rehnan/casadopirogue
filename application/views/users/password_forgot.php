<div class="pg pg-login">
  <div class="login">
    <article>
      <p>Esqueceu sua senha?</p>
      <form action="password_forgot" method="POST" name="password_recovery">
        <div class="form-group">
          <label for="user_email" class="hidden">Informe seu E-mail: </label>
          <input type="text" class="form-control" id="user_email" name="user[email]" placeholder="Informe seu E-mail" value="<?= (isset($email)) ? $email : '' ?>" />
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg" title="Recuperar Senha"><i class="fa fa-unlock" aria-hidden="true"></i> Recuperar Senha</button>
        </div>
        <?php echo validation_errors(); ?>
        <?= anchor('login', ' Voltar para o Login', 'title="Voltar para a página de login" <i class="fa fa-sign-in" aria-hidden="true"'); ?>
      </form>
    </article>
  </div>
</div>

<br>
