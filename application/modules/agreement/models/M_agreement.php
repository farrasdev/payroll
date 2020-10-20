<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_agreement extends CI_Model
{

  public function where($cookie)
  {
    $where = "WHERE a.is_deleted = 0 ";
    if (@$cookie['search']['term'] != '') {
      $where .= "AND a.agreement_name LIKE '%" . $this->db->escape_like_str($cookie['search']['term']) . "%' ";
    }
    return $where;
  }

  public function list_data($cookie)
  {
    $where = $this->where($cookie);
    $sql = "SELECT a.*, b.department_name, c.division_name, d.position_name FROM agreement a 
      LEFT JOIN department b ON a.department_id = b.department_id
      LEFT JOIN division c ON a.division_id = c.division_id
      LEFT JOIN position d ON a.position_id = d.position_id
      $where
      ORDER BY "
      . $cookie['order']['field'] . " " . $cookie['order']['type'] .
      " LIMIT " . $cookie['cur_page'] . "," . $cookie['per_page'];
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_data()
  {
    $where = "WHERE a.is_deleted = 0 ";

    $sql = "SELECT * FROM agreement a $where ORDER BY created_at";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_rows($cookie)
  {
    $where = $this->where($cookie);

    $sql = "SELECT COUNT(1) as total FROM agreement a $where";
    $query = $this->db->query($sql);
    return $query->row_array()['total'];
  }

  function by_field($field, $val)
  {
    $sql = "SELECT * FROM agreement WHERE $field = ?";
    $query = $this->db->query($sql, array($val));
    $row = $query->row_array();
    return $row;
  }

  public function save($data, $id = null)
  {
    if ($id == null) {
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['created_by'] = $this->session->userdata('user_fullname');
      $this->db->insert('agreement', $data);
    } else {
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('agreement_id', $id)->update('agreement', $data);
    }
  }

  public function update($id, $data)
  {
    $data['updated_at'] = date('Y-m-d H:i:s');
    $data['updated_by'] = $this->session->userdata('fullname');
    $this->db->where('agreement_id', $id)->update('agreement', $data);
  }

  public function delete($id, $permanent = true)
  {
    if ($permanent) {
      $this->db->where('agreement_id', $id)->delete('agreement');
    } else {
      $data['is_deleted'] = 1;
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('agreement_id', $id)->update('agreement', $data);
    }
  }

  public function province_data()
  {
    return $this->db->query("SELECT * FROM area WHERE LENGTH(area_id) = 2")->result_array();
  }

  public function regency_data($province_id)
  {
    $res = array("" => "--");
    if ($province_id != "") {
      $regency = $this->db->query("SELECT * FROM area WHERE area_id LIKE '$province_id%' AND LENGTH(area_id) = 5")->result_array();
      foreach ($regency as $k => $v) {
        $res[$v['area_id']] = $v['area_name'];
      }
    }
    return $res;
  }

  public function district_data($regency_id)
  {
    $res = array("" => "--");
    if ($regency_id != "") {
      $regency = $this->db->query("SELECT * FROM area WHERE area_id LIKE '$regency_id%' AND LENGTH(area_id) = 8")->result_array();
      foreach ($regency as $k => $v) {
        $res[$v['area_id']] = $v['area_name'];
      }
    }
    return $res;
  }

  public function village_data($district_id)
  {
    $res = array("" => "--");
    if ($district_id != "") {
      $regency = $this->db->query("SELECT * FROM area WHERE area_id LIKE '$district_id%' AND LENGTH(area_id) = 13")->result_array();
      foreach ($regency as $k => $v) {
        $res[$v['area_id']] = $v['area_name'];
      }
    }
    return $res;
  }
}
