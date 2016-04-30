<section>
    <?php echo 'Edit Account!'; ?>
    <?php echo form_update_account("account/{$user->getId()}/edit", $user,  ''); ?>
    <?php echo anchor("account/{$user->getId()}", 'Visualizar', 'title="Visualizar Conta" '); ?>
    <?php echo validation_errors(); ?>
</section>


