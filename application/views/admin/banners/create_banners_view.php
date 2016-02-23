<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top: 40px;">
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4">
      <h1><?php echo $page_title; ?></h1>
      <?php echo validation_errors(); ?>
      <?php echo form_open_multipart('',array('class'=>'form-horizontal'));?>
        <div class="form-group">
          <label for="title">Título</label>
          <input type="input" name="title" class="form-control" id = "title" /><br />
          <?php echo form_error('title'); ?>
        </div>

        <div class="form-group">
          <label for="img_path">Imagem principal (1349x500)</label>
          <input name = "img_path" type="file" class="form-control" id = "img_path" />
          <?php echo form_error('img_path'); ?>
        </div>

        <div class="form-group">
          <label for="mobile_img_path">Imagem mobile (360x360)</label>
          <input name = "mobile_img_path" type="file" class="form-control" id = "mobile_img_path" />
          <?php echo form_error('mobile_img_path'); ?>
        </div>
        <?php echo form_submit('submit', 'Salvar', 'class="btn btn-primary btn-lg btn-block"');?>
    <?php echo form_close();?>
  </div>
</div>
</div>
