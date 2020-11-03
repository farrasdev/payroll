<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bpjs_tk extends CI_Model
{

  public function where($cookie)
  {
    $where = "WHERE a.is_deleted = 0 ";
    if (@$cookie['search']['term'] != '') {
      $where .= "AND a.payroll_name LIKE '%" . $this->db->escape_like_str($cookie['search']['term']) . "%' ";
    }
    return $where;
  }

  public function list_data($cookie)
  {
    $where = $this->where($cookie);
    $sql = "SELECT * FROM payroll a 
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

    $sql = "SELECT * FROM payroll a $where ORDER BY created_at";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_rows($cookie)
  {
    $where = $this->where($cookie);

    $sql = "SELECT COUNT(1) as total FROM payroll a $where";
    $query = $this->db->query($sql);
    return $query->row_array()['total'];
  }

  function by_field($field, $val)
  {
    $sql = "SELECT * FROM payroll WHERE $field = ?";
    $query = $this->db->query($sql, array($val));
    $row = $query->row_array();
    return $row;
  }

  public function detail($id, $limit, $offset, $search = "")
  {
    $search = $this->db->escape_like_str($search);
    $where = "WHERE payroll_id = '$id' ";
    if ($search != '') {
      $where = "AND b.employee_name LIKE '%$search%'";
    }
    $data = $this->db->query(
      "SELECT 
        a.*, b.id_number, b.sex, b.employee_name, b.tax_number, b.entry_date, b.dob 
      FROM payroll_detail a
      JOIN employee b ON a.employee_id = b.employee_id
      $where
      ORDER BY a.employee_id ASC LIMIT $limit, $offset
      "
    )->result_array();

    return $data;
  }

  public function detail_total($id, $search = "")
  {
    $search = $this->db->escape_like_str($search);
    $where = "WHERE payroll_id = '$id' ";
    if ($search != '') {
      $where = "AND b.employee_name LIKE '%$search%'";
    }
    $data = $this->db->query(
      "SELECT 
        COUNT(1) as total
      FROM payroll_detail a 
      JOIN employee b ON a.employee_id = b.employee_id
      $where"
    )->row_array();

    return $data;
  }
}
