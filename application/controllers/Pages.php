<?php
class Pages extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('banners_model');
    $this->load->helper('url_helper');
  }

  public function index($page = 'home')
  {
    if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
    {
      show_404();
    }

    //title
    //$data['title'] = ucfirst($page); // Capitalize the first letter
    //banners
    $data['banners'] = $this->banners_model->get_banners();

    $this->load->view('templates/header', $data);
    $this->load->view('pages/'.$page, $data);
    $this->load->view('templates/footer', $data);
  }
}
