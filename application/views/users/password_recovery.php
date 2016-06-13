<div class="pg pg-login">
  <div class="login">
    <article>
      <p>Recuperação de Senha <i class="fa fa-lock" aria-hidden="true"></i></p>
      <form action='<?= base_url("user/password_recovery/$reset_password_link") ?>' method="POST" name="password_recovery_form">
        <input type="hidden" name="user[id]" value="<?= (isset($user_id)) ? $user_id : '' ?>">

        <div class="form-group">
          <label for="user_password" class="hidden">Nova senha: </label>
          <input type="password" class="form-control" id="user_password" name="user[password]" placeholder="Informe sua nova senha" value="<?= (isset($password)) ? $password : '' ?>" />
        </div>

        <div class="form-group">
          <label for="user_password_confirm" class="hidden">Confirmação da nova senha: </label>
          <input type="password" class="form-control" id="user_password_confirm" name="user[password_confirm]" placeholder="Confirme a nova senha informada" value="<?= (isset($password_confirm)) ? $password_confirm : '' ?>" />
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg" title="Atualizar Senha"><i class="fa fa-check-square-o" aria-hidden="true"></i> Atualizar Senha</button>
        </div>
        <?php echo validation_errors(); ?>
      </form>
    </article>
  </div>
</div>

<br>
