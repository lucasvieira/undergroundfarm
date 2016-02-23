<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top: 40px;">
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4">
      <h1><?php echo $page_title; ?></h1>
      <?php echo validation_errors(); ?>
      <?php echo form_open_multipart('',array('class'=>'form-horizontal'));?>
        <input type="hidden" name="id" class="form-control" id = "id" value="<?php echo $banner_id; ?>"/>
        <div class="form-group">
          <label for="title">Título</label>
          <input type="input" name="title" class="form-control" id = "title" value="<?php echo $banner_title; ?>"/><br />
          <?php echo form_error('title'); ?>
        </div>

        <div class="form-group">
          <label for="img_path">Imagem principal (1349x500)</label></br>
          <!-- exibir aqui a imagem -->
          <img class="mini_img" src="<?php echo base_url().$img; ?>" alt="imagem_original"  width="135" height="50">
          <!-- campo hidden com valor original. Se for selecionada uma nova imagem, processar para atualizar -->
          <input type="hidden" name="img_orig" class="form-control" id = "img_orig" value="<?php echo $img; ?>"/>
          <input name = "img_path" type="file" class="form-control" id = "img_path" />
          <?php echo form_error('img_path'); ?>
        </div>

        <div class="form-group">
          <label for="mobile_img_path">Imagem mobile (360x360)</label></br>
          <!-- exibir aqui a imagem -->
          <img class="mini_img_mobile" src="<?php echo base_url().$img_mobile; ?>" alt="imagem_mobile_original" width="50" height="50">
          <!-- campo hidden com valor original. Se for selecionada uma nova imagem, processar para atualizar -->
          <input type="hidden" name="img_mobile_orig" class="form-control" id = "img_mobile_orig" value="<?php echo $img_mobile; ?>"/>
          <input name = "mobile_img_path" type="file" class="form-control" id = "mobile_img_path" />
          <?php echo form_error('mobile_img_path'); ?>
        </div>
        <?php echo form_submit('submit', 'Salvar', 'class="btn btn-primary btn-lg btn-block"');?>
    <?php echo form_close();?>
  </div>
</div>
</div>
