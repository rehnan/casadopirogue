<?php if (isset($this->session)) { ?>
    <?php if ($this->session->flashdata('flashSuccess')) { ?>
    <p class='flashMsg flashSuccess'> <?php echo $this->session->flashdata('flashSuccess')?> </p>
    <?php } ?>

    <?php if ($this->session->flashdata('flashError')) { ?>
    <p class='flashMsg flashError'> <?php echo $this->session->flashdata('flashError')?> </p>
    <?php } ?>

    <?php if ($this->session->flashdata('flashInfo')) { ?>
    <p class='flashMsg flashInfo'> <?php echo $this->session->flashdata('flashInfo')?> </p>
    <?php } ?>

    <?php if ($this->session->flashdata('flashWarning')) { ?>
    <p class='flashMsg flashWarning'> <?php echo $this->session->flashdata('flashWarning')?> </p>
    <?php } ?>
<?php } ?>