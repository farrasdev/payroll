<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_salary_slip extends CI_Model
{

  function get_data($payroll_id, $employee_id)
  {
    return $this->db->query(
      "SELECT a.*, b.employee_name, b.entry_date, b.bank_account
      FROM payroll_detail a 
      JOIN employee b ON a.employee_id = b.employee_id
      WHERE 
        a.payroll_id = '$payroll_id' AND a.employee_id = '$employee_id'"
    )->row_array();
  }

  public function get_payroll($payroll_id)
  {
    return $this->db->where('payroll_id', $payroll_id)->get('payroll')->row_array();
  }
}
