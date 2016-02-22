<?php
class Banners_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function create_banner($data){
    $this->db->insert('banners', $data);
  }

  public function get_banners($id = FALSE)
  {
    if ($id === FALSE)
    {
      $query = $this->db->get('banners');
      return $query->result_array();
    }

    $query = $this->db->get_where('banners', array('id' => $id));
    return $query->row_array();
  }

  public function delete_banner($id = FALSE){
    $this->db->delete(banners, array('id' => $id));
    if ($this->db->affected_rows() == 0)
    {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

}
