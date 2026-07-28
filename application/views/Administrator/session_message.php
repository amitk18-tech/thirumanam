<?php if($this->session->flashdata('success_message')){ ?>
<div class="alert alert-success alert-dismissible alert_style">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?php echo $this->session->flashdata('success_message'); ?>
</div>
<?php } ?>

<?php if($this->session->flashdata('warning_message')){ ?>
<div class="alert alert-warning alert-dismissible alert_style">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?php echo $this->session->flashdata('warning_message'); ?>
</div>
<?php } ?>

<?php if($this->session->flashdata('danger_message')){ ?>
<div class="alert alert-danger alert-dismissible alert_style">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?php echo $this->session->flashdata('danger_message'); ?>
</div>
<?php } ?>

<?php if($this->session->flashdata('info_message')){ ?>
<div class="alert alert-info alert-dismissible alert_style">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <?php echo $this->session->flashdata('info_message'); ?>
</div>
<?php } ?>