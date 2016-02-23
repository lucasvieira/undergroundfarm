<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends Admin_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('banners_model');
    $this->load->helper('url_helper');
    if(!$this->ion_auth->in_group('admin'))
    {
      $this->session->set_flashdata('message','You are not allowed to visit the Groups page');
      redirect('admin','refresh');
    }
  }

  public function index()
  {
    $this->data['page_title'] = 'Banners';
    //$this->data['users'] = $this->ion_auth->users($group_id)->result();
    $this->data['banners'] = $this->banners_model->get_banners();
    $this->render('admin/banners/list_banners_view');
  }

  public function create()
  {
    $this->data['page_title'] = 'Novo Banners';
    $this->load->library('form_validation');
    $this->form_validation->set_rules('title','Tírulo','trim');
    $this->form_validation->set_rules('img_path','Imagem principal','trim');
    $this->form_validation->set_rules('mobile_img_path','Imagem mobile','trim');

    if($this->form_validation->run()===FALSE)
    {
      $this->load->helper('form');
      $this->render('admin/banners/create_banners_view');
    }
    else{
      $real_path = 'images/banners/';
      $config['upload_path'] = './images/banners';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 1500;
      $config['overwrite'] = TRUE;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      //recupera título da imagem
      $title = $this->input->post('title');
      $error = array();
      //upload da imagem principal
      if (!$this->upload->do_upload('img_path'))
      {
        $error[] = $this->upload->display_errors();
      }
      else
      {
        $img_data = $this->upload->data();
        $img_path = $real_path.$img_data['orig_name'];
      }

      //upload da imagem na versão mobile
      if (!$this->upload->do_upload('mobile_img_path'))
      {
        $error[] = $this->upload->display_errors();
      }
      else {
        $mobile_img_data = $this->upload->data();
        $mobile_img_path = $real_path.$mobile_img_data['orig_name'];
      }

      //se não contém erros
      if(!count($error)){
        //método para gravar deve ser criado no Banner_model.php
        $data = array('title'=>$title,'img'=>$img_path,'img_mobile'=>$mobile_img_path);
        $this->banners_model->create_banner($data);
      }

      redirect('admin/banners','refresh');
    }

  }

  public function edit($banner_id = null)
  {
    $banner_id = $this->input->post('id') ? $this->input->post('id') : $banner_id;
    $this->data['page_title'] = 'Editar Banners';
    $this->load->library('form_validation');
    $this->form_validation->set_rules('title','Tírulo','trim');
    $this->form_validation->set_rules('img_path','Imagem principal','trim');
    $this->form_validation->set_rules('mobile_img_path','Imagem mobile','trim');

    if($this->form_validation->run()===FALSE)
    {
      $this->load->helper('form');
      //setar valores para preencher os campos
      $banner = $this->banners_model->get_banners($banner_id);
      $this->data['banner_id'] = $banner['id'];
      $this->data['banner_title'] = $banner['title'];
      $this->data['img'] = $banner['img'];
      $this->data['img_mobile'] = $banner['img_mobile'];
      $this->render('admin/banners/edit_banners_view');
    }
    else{
      $real_path = 'images/banners/';
      $config['upload_path'] = './images/banners';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 1500;
      $config['overwrite'] = TRUE;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      //recupera título da imagem
      $title = $this->input->post('title');
      $id = $this->input->post('id');
      $img_orig = $this->input->post('img_orig');
      $img_mobile_orgin = $this->input->post('img_mobile_orig');

      $error = array();
      //upload da imagem principal
      if (!$this->upload->do_upload('img_path'))
      {
        $error[] = $this->upload->display_errors();
          $img_path = $img_orig;
      }
      else
      {
        $img_data = $this->upload->data();
        $img_path = $real_path.$img_data['orig_name'];
      }

      //upload da imagem na versão mobile
      if (!$this->upload->do_upload('mobile_img_path'))
      {
        $error[] = $this->upload->display_errors();
        $mobile_img_path = $img_mobile_orgin;
      }
      else {
        $mobile_img_data = $this->upload->data();
        $mobile_img_path = $real_path.$mobile_img_data['orig_name'];
      }

      $data = array('title'=>$title,'img'=>$img_path,'img_mobile'=>$mobile_img_path);
      $this->banners_model->edit_banner($data,$banner_id);

      redirect('admin/banners','refresh');

    }
  }

  public function delete($banner_id = NULL)
  {
    if(is_null($banner_id))
    {
      $this->session->set_flashdata('message','There\'s no banner to delete');
    }
    else
    {
      $result = $this->banners_model->delete_banner($banner_id);
      if($result){
        $this->session->set_flashdata('flashSuccess','Banner removido com sucesso!');
      }
      else {
        $this->session->set_flashdata('flashError','Falha ao remover o Banner selecionado!');
      }
    }
    redirect('admin/banners','refresh');
  }
}
