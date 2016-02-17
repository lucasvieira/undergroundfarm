<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container" style="margin-top: 60px;">
  <div class="row">
    <div class="col-lg-12">
      <a href="<?php echo site_url('admin/banners/create'); ?>" class="btn btn-primary">Criar novo banner</a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12" style="margin-top: 10px;">
    <?php
    //var_dump($banners);
    if(!empty($banners))
    {
      echo '<table class="table table-hover table-bordered table-condensed">';
      echo '<tr><td>ID</td><td>Titulo</td></td><td>Imagem</td><td>Imagem Mobile</td><td>Operações</td></tr>';
      foreach($banners as $banner)
      {
        echo '<tr>';
        echo '<td>'.$banner['id'].'</td><td>'.$banner['title'].'</td><td>'.$banner['img'].'</td><td>'.$banner['img_mobile'].'</td><td>';
        echo anchor('admin/banners/edit/'.$banner['id'],'<span class="glyphicon glyphicon-pencil"></span>').' '.anchor('admin/users/delete/'.$banner['id'],'<span class="glyphicon glyphicon-remove"></span>');
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
    }
    ?>
    </div>
  </div>
</div>
