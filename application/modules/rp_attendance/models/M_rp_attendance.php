<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rp_attendance extends CI_Model
{

  public function where($cookie)
  {
    $where = "WHERE a.is_deleted = 0 AND a.is_active = 1 ";
    // if (@$cookie['search']['term'] != '') {
    //   $where .= "AND a.division_name LIKE '%" . $this->db->escape_like_str($cookie['search']['term']) . "%' ";
    // }
    return $where;
  }

  public function list_data($cookie)
  {
    $where = $this->where($cookie);
    $sql = "SELECT 
        a.*, 
        b.department_name, 
        c.division_name, 
        d.position_name,
        e.employee_status_name 
      FROM employee a 
      LEFT JOIN department b ON a.department_id = b.department_id
      LEFT JOIN division c ON a.division_id = c.division_id
      LEFT JOIN position d ON a.position_id = d.position_id
      LEFT JOIN employee_status e ON a.employee_status_id = e.employee_status_id
      $where
      ORDER BY "
      . $cookie['order']['field'] . " " . $cookie['order']['type'] .
      " LIMIT " . $cookie['cur_page'] . "," . $cookie['per_page'];
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_rows($cookie)
  {
    $where = $this->where($cookie);

    $sql = "SELECT COUNT(1) as total FROM division a $where";
    $query = $this->db->query($sql);
    return $query->row_array()['total'];
  }
}
