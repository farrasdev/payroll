<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rp_overtime_3 extends CI_Model
{

  public function get_data($start_date, $end_date)
  {
    $diff = date_difference($end_date, $start_date);
    $data = $this->db->query(
      "SELECT 
        a.employee_id, a.employee_name 
      FROM employee a 
      WHERE is_active = 1 ORDER BY a.employee_id"
    )->result_array();
    foreach ($data as $k => $v) {
      $attendance = array();
      for ($i = 0; $i <= $diff; $i++) {
        $cur_date = date('Y-m-d', strtotime($start_date . " + $i days"));
        $attendance[$cur_date] = "0";
        $att = $this->db->query("SELECT overtime_3 FROM attendance WHERE employee_id = '" . $v['employee_id'] . "' AND attendance_date = '" . $cur_date . "'")->row_array();
        if ($att != null) {
          $attendance[$cur_date] = $att['overtime_3'];
        }
      }
      $data[$k]['attendance'] = $attendance;
    }
    return $data;
  }
}
