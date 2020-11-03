<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rp_overtime extends CI_Model
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
    $where = "WHERE 1 = 1 ";
    if ($search != '') {
      $where .= "AND z.division_name LIKE '%$search%'";
    }
    $data = $this->db->query(
      "SELECT z.* FROM (SELECT 
        a.division_name,
        b.employee_total,
        c.overtime_regular_total, c.overtime_off_total, c.overtime_holiday_total, c.overtime_over_total, c.overtime_total_total, c.overtime_all_total
      FROM division a
      LEFT JOIN (
        SELECT division_id, COUNT(employee_id) as employee_total FROM employee GROUP BY division_id
      ) as b ON b.division_id = a.division_id
      LEFT JOIN (
        SELECT 
          division_id,
          SUM(overtime_regular) as overtime_regular_total,
          SUM(overtime_off) as overtime_off_total,
          SUM(overtime_holiday) as overtime_holiday_total,
          SUM(overtime_over) as overtime_over_total,
          SUM(overtime_total) as overtime_total_total,
          SUM(overtime_all) as overtime_all_total
        FROM payroll_detail WHERE payroll_id = '$id' GROUP BY division_id
      ) as c ON c.division_id = a.division_id
      ORDER BY a.division_name ASC LIMIT $limit, $offset) as z $where
      "
    )->result_array();

    return $data;
  }

  public function detail_total($id, $search = "")
  {
    $search = $this->db->escape_like_str($search);
    $where = "WHERE 1 = 1 ";
    if ($search != '') {
      $where .= "AND a.division_name LIKE '%$search%'";
    }
    $data = $this->db->query(
      "SELECT 
        COUNT(1) as total
      FROM division a $where"
    )->row_array();

    return $data;
  }

  public function detail_all($id)
  {
    $data = $this->db->query(
      "SELECT z.* FROM (SELECT 
        a.division_name,
        b.employee_total,
        c.overtime_regular_total, c.overtime_off_total, c.overtime_holiday_total, c.overtime_over_total, c.overtime_total_total, c.overtime_all_total
      FROM division a
      LEFT JOIN (
        SELECT division_id, COUNT(employee_id) as employee_total FROM employee GROUP BY division_id
      ) as b ON b.division_id = a.division_id
      LEFT JOIN (
        SELECT 
          division_id,
          SUM(overtime_regular) as overtime_regular_total,
          SUM(overtime_off) as overtime_off_total,
          SUM(overtime_holiday) as overtime_holiday_total,
          SUM(overtime_over) as overtime_over_total,
          SUM(overtime_total) as overtime_total_total,
          SUM(overtime_all) as overtime_all_total
        FROM payroll_detail WHERE payroll_id = '$id' GROUP BY division_id
      ) as c ON c.division_id = a.division_id
      ORDER BY a.division_name ASC) as z
      "
    )->result_array();

    return $data;
  }
}
