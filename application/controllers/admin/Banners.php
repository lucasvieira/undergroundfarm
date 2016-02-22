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
      else{
        var_dump($error);
      }
      redirect('admin/banners','refresh');
    }

  }

  public function edit($banner_id = null)
  {
    $banner_id = $this->input->post('id') ? $this->input->post('id') : $banner_id;
    $this->data['page_title'] = 'Editar Banners';
    $this->render('admin/banners/edit_banners_view');
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


  /*
  public function create()
  {
  $this->data['page_title'] = 'Create user';
  $this->load->library('form_validation');
  $this->form_validation->set_rules('first_name','First name','trim');
  $this->form_validation->set_rules('last_name','Last name','trim');
  $this->form_validation->set_rules('company','Company','trim');
  $this->form_validation->set_rules('phone','Phone','trim');
  $this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
  $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
  $this->form_validation->set_rules('password','Password','required');
  $this->form_validation->set_rules('password_confirm','Password confirmation','required|matches[password]');
  $this->form_validation->set_rules('groups[]','Groups','required|integer');

  if($this->form_validation->run()===FALSE)
  {
  $this->data['groups'] = $this->ion_auth->groups()->result();
  $this->load->helper('form');
  $this->render('admin/users/create_user_view');
}
else
{
$username = $this->input->post('username');
$email = $this->input->post('email');
$password = $this->input->post('password');
$group_ids = $this->input->post('groups');

$additional_data = array(
'first_name' => $this->input->post('first_name'),
'last_name' => $this->input->post('last_name'),
'company' => $this->input->post('company'),
'phone' => $this->input->post('phone')
);
$this->ion_auth->register($username, $password, $email, $additional_data, $group_ids);
$this->session->set_flashdata('message',$this->ion_auth->messages());
redirect('admin/users','refresh');
}
}
*/

/*
public function edit()
{

$user_id = $this->input->post('user_id') ? $this->input->post('user_id') : $user_id;
$this->data['page_title'] = 'Edit user';
$this->load->library('form_validation');

$this->form_validation->set_rules('first_name','First name','trim');
$this->form_validation->set_rules('last_name','Last name','trim');
$this->form_validation->set_rules('company','Company','trim');
$this->form_validation->set_rules('phone','Phone','trim');
$this->form_validation->set_rules('username','Username','trim|required');
$this->form_validation->set_rules('email','Email','trim|required|valid_email');
$this->form_validation->set_rules('password','Password','min_length[6]');
$this->form_validation->set_rules('password_confirm','Password confirmation','matches[password]');
$this->form_validation->set_rules('groups[]','Groups','required|integer');
$this->form_validation->set_rules('user_id','User ID','trim|integer|required');

if($this->form_validation->run() === FALSE)
{
if($user = $this->ion_auth->user((int) $user_id)->row())
{
$this->data['user'] = $user;
}
else
{
$this->session->set_flashdata('message', 'The user doesn\'t exist.');
redirect('admin/users', 'refresh');
}
$this->data['groups'] = $this->ion_auth->groups()->result();
$this->data['usergroups'] = array();
if($usergroups = $this->ion_auth->get_users_groups($user->id)->result())
{
foreach($usergroups as $group)
{
$this->data['usergroups'][] = $group->id;
}
}
$this->load->helper('form');
$this->render('admin/users/edit_user_view');
}
else
{
$user_id = $this->input->post('user_id');
$new_data = array(
'username' => $this->input->post('username'),
'email' => $this->input->post('email'),
'first_name' => $this->input->post('first_name'),
'last_name' => $this->input->post('last_name'),
'company' => $this->input->post('company'),
'phone' => $this->input->post('phone')
);
if(strlen($this->input->post('password'))>=6) $new_data['password'] = $this->input->post('password');

$this->ion_auth->update($user_id, $new_data);

//Update the groups user belongs to
$groups = $this->input->post('groups');
if (isset($groups) && !empty($groups))
{
$this->ion_auth->remove_from_group('', $user_id);
foreach ($groups as $group)
{
$this->ion_auth->add_to_group($group, $user_id);
}
}

$this->session->set_flashdata('message',$this->ion_auth->messages());
redirect('admin/users','refresh');
}
}
*/
}
