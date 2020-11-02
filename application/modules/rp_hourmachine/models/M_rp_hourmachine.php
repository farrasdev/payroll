<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rp_hourmachine extends CI_Model
{

  public function detail($start_date, $end_date, $limit, $offset, $search)
  {
    $diff = date_difference($end_date, $start_date);
    $where = "WHERE is_active = 1 ";
    if ($search != '') {
      $where .= "AND a.employee_name LIKE '%$search%'";
    }
    $data = $this->db->query(
      "SELECT 
        a.employee_id, a.employee_name 
      FROM employee a 
      $where
      ORDER BY a.employee_id
      LIMIT $limit, $offset"
    )->result_array();
    foreach ($data as $k => $v) {
      $attendance = array();
      for ($i = 0; $i <= $diff; $i++) {
        $cur_date = date('Y-m-d', strtotime($start_date . " + $i days"));
        $attendance[$cur_date] = 0;
        $att = $this->db->query("SELECT hourmachine FROM attendance WHERE employee_id = '" . $v['employee_id'] . "' AND attendance_date = '" . $cur_date . "'")->row_array();
        if ($att != null) {
          $attendance[$cur_date] = $att['hourmachine'];
        }
      }
      $data[$k]['attendance'] = $attendance;
    }
    return $data;
  }

  public function detail_total($search)
  {
    $where = "WHERE is_active = 1 ";
    if ($search != '') {
      $where .= "AND a.employee_name LIKE '%$search%'";
    }
    return $this->db->query(
      "SELECT 
        COUNT(1) as total
      FROM employee a 
      $where
      ORDER BY a.employee_id"
    )->row_array();
  }

  public function detail_all($start_date, $end_date)
  {
    $diff = date_difference($end_date, $start_date);
    $data = $this->db->query(
      "SELECT 
        a.employee_id, a.employee_name 
      FROM employee a 
      ORDER BY a.employee_id"
    )->result_array();
    foreach ($data as $k => $v) {
      $attendance = array();
      for ($i = 0; $i <= $diff; $i++) {
        $cur_date = date('Y-m-d', strtotime($start_date . " + $i days"));
        $attendance[$cur_date] = 0;
        $att = $this->db->query("SELECT hourmachine FROM attendance WHERE employee_id = '" . $v['employee_id'] . "' AND attendance_date = '" . $cur_date . "'")->row_array();
        if ($att != null) {
          $attendance[$cur_date] = $att['hourmachine'];
        }
      }
      $data[$k]['attendance'] = $attendance;
    }
    return $data;
  }
}
