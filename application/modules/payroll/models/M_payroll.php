<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_payroll extends CI_Model
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

  public function save($data, $id = null)
  {
    if ($id == null) {
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['created_by'] = $this->session->userdata('user_fullname');
      $this->db->insert('payroll', $data);

      //insert detail
      $pegawai = $this->db->query(
        "SELECT 
            a.*, 
            b.department_name, 
            c.division_name, 
            d.position_name, 
            e.employee_status_name, 
            f.salary_status_name, 
            g.family_status_name
          FROM employee a 
          LEFT JOIN department b ON a.department_id = b.department_id
          LEFT JOIN division c ON a.division_id = c.division_id
          LEFT JOIN position d ON a.position_id = d.position_id
          LEFT JOIN employee_status e ON a.employee_status_id = e.employee_status_id
          LEFT JOIN salary_status f ON a.salary_status_id = f.salary_status_id
          LEFT JOIN family_status g ON a.family_status_id = g.family_status_id
          "
      )->result_array();
      foreach ($pegawai as $row) {
        $normal_work_days_parttime = $this->db->query(
          "SELECT 
            COUNT(attendance_id) as normal_work_days_parttime 
          FROM attendance 
          WHERE 
            (shift_id = 'TL' OR shift_id = 'TJ' OR shift_id = 'TL1' OR shift_id = 'TL2' OR shift_id = 'T1' OR shift_id = 'T2' OR shift_id = 'T3')
            AND attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' AND employee_id = '" . $row['employee_id'] . "' 
        ORDER BY attendance_date"
        )->row_array()['normal_work_days_parttime'];


        $normal_work_days_total = $this->db->query(
          "SELECT 
            COUNT(attendance_id) as normal_work_days_total 
          FROM attendance 
          WHERE 
            attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
        ORDER BY attendance_date"
        )->row_array()['normal_work_days_total'];

        $absent = $this->db->query(
          "SELECT 
            SUM(CASE WHEN shift_id = 'A' THEN 1 ELSE 0 END) as alpa,
            SUM(CASE WHEN shift_id = 'I' THEN 1 ELSE 0 END) as izin,
            SUM(CASE WHEN shift_id = 'S' THEN 1 ELSE 0 END) as sakit,
            SUM(CASE WHEN shift_id = 'OFF' THEN 1 ELSE 0 END) as libur,
            SUM(CASE WHEN shift_id = 'CT' OR shift_id = 'CR' THEN 1 ELSE 0 END) as cuti
            FROM attendance 
            WHERE 
              attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
              AND employee_id = '" . $row['employee_id'] . "' 
            ORDER BY attendance_date"
        )->row_array();

        $alpa = (@$absent['alpa'] == null) ? 0 : $absent['alpa'];
        $izin = (@$absent['izin'] == null) ? 0 : $absent['izin'];
        $sakit = (@$absent['sakit'] == null) ? 0 : $absent['sakit'];
        $libur = (@$absent['libur'] == null) ? 0 : $absent['libur'];
        $cuti = (@$absent['cuti'] == null) ? 0 : $absent['cuti'];

        $normal_work_days_contract = $normal_work_days_total + $normal_work_days_parttime;

        $work_days_total = $normal_work_days_total - $alpa - $izin - $sakit - $libur - $cuti;

        //OVERTIME
        $overtime_total_row = $this->db->query(
          "SELECT 
              (SUM(overtime_15 * 1.5)+SUM(overtime_2 * 2)+SUM(overtime_3 * 3)+SUM(overtime_4 * 4)) as overtime_total
            FROM attendance 
            WHERE 
              attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
              AND employee_id = '" . $row['employee_id'] . "' 
            ORDER BY attendance_date"
        )->row_array();

        $overtime_total = (@$overtime_total_row['overtime_total'] == null) ? 0 : $overtime_total_row['overtime_total'];

        $overtime_off_row = $this->db->query(
          "SELECT 
            SUM(CASE WHEN shift_id = 'HM' THEN 1 ELSE 0 END) as hm,
            SUM(CASE WHEN shift_id = 'HM1' THEN 1 ELSE 0 END) as hm1,
            SUM(CASE WHEN shift_id = 'HM2' THEN 1 ELSE 0 END) as hm2
            FROM attendance 
            WHERE 
              attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
              AND employee_id = '" . $row['employee_id'] . "' 
            ORDER BY attendance_date"
        )->row_array();

        $hm = (@$overtime_off_row['hm'] == null) ? 0 : $overtime_off_row['hm'];
        $hm1 = (@$overtime_off_row['hm1'] == null) ? 0 : $overtime_off_row['hm1'];
        $hm2 = (@$overtime_off_row['hm2'] == null) ? 0 : $overtime_off_row['hm2'];

        $overtime_off = $hm * 21 + $hm1 * 29 + $hm2 * 29;

        $overtime_holiday_row = $this->db->query(
          "SELECT 
            SUM(CASE WHEN shift_id = 'HB' THEN 1 ELSE 0 END) as hb,
            SUM(CASE WHEN shift_id = 'HB1' THEN 1 ELSE 0 END) as hb1,
            SUM(CASE WHEN shift_id = 'HB2' THEN 1 ELSE 0 END) as hb2
            FROM attendance 
            WHERE 
              attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
              AND employee_id = '" . $row['employee_id'] . "' 
            ORDER BY attendance_date"
        )->row_array();

        $hb = (@$overtime_off_row['hb'] == null) ? 0 : $overtime_off_row['hb'];
        $hb1 = (@$overtime_off_row['hb1'] == null) ? 0 : $overtime_off_row['hb1'];
        $hb2 = (@$overtime_off_row['hb2'] == null) ? 0 : $overtime_off_row['hb2'];

        $overtime_holiday = $hb * 25 + $hb1 * 25 + $hb2 * 25;

        //PENDING 
        $overtime_over = 0;

        $overtime_regular = $overtime_total - $overtime_off - $overtime_holiday - $overtime_over;

        $hourmachine_total_row = $this->db->query(
          "SELECT 
              SUM(hourmachine) as hourmachine_total
            FROM attendance 
            WHERE 
              attendance_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
              AND employee_id = '" . $row['employee_id'] . "' 
            ORDER BY attendance_date"
        )->row_array();

        $hourmachine_total = (@$hourmachine_total_row['hourmachine_total'] == null) ? 0 : $hourmachine_total_row['hourmachine_total'];

        //HITUNG UPAH SUB
        $days_total = date_difference($data['end_date'], $data['start_date']) + 1;
        $contract_salary = $row['contract_salary'];
        $parttime_salary = $contract_salary / 30;
        $overtime_salary = 1 / 173 * $contract_salary;

        $salary_parttime_sub = 0;
        if ($row['salary_status_name'] == 'PRORATA') {
          $salary_parttime_sub = ($row['contract_salary'] / $days_total) * $normal_work_days_parttime;
        }

        $salary_contract_sub = $row['contract_salary'];
        if ($row['salary_status_name'] == 'PRORATA') {
          $salary_contract_sub = ($normal_work_days_contract / $days_total) * $row['contract_salary'];
        }

        $salary_receive_sub = $salary_parttime_sub + $salary_contract_sub;

        //ALLOWANCE
        $meal_all = $work_days_total * 20000;
        $comm_trans_all = 0;
        $coeficient_all = 0;
        $overtime_all = $overtime_salary * $overtime_total;
        $hourmachine_all = $hourmachine_total * 3500;

        //RAPELAN
        $expense_total_row = $this->db->query(
          "SELECT 
              SUM(nominal) as expense_total
            FROM employee_expense 
            WHERE 
              employee_expense_date BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' 
              AND employee_id = '" . $row['employee_id'] . "' 
            ORDER BY employee_expense_date"
        )->row_array();

        $expense_all = (@$expense_total_row['expense_total'] == NULL) ? 0 : $expense_total_row['expense_total'];
        $all_total = $meal_all + $comm_trans_all + $coeficient_all + $overtime_all + $hourmachine_total + $expense_all;

        //BPJS KS
        $bpjs_ks_salary = $row['bpjs_ks_salary'];
        $bpjs_ks_employee = $bpjs_ks_salary * (1 / 100);
        $bpjs_ks_company = $bpjs_ks_salary * (4 / 100);
        $bpjs_ks_premi = $bpjs_ks_employee + $bpjs_ks_company;

        //BPJS TK
        $bpjs_tk_salary = $row['bpjs_tk_salary'];
        $bpjs_tk_jkk = $bpjs_tk_salary * (1.74 / 100);
        $bpjs_tk_jkm = $bpjs_tk_salary * (0.3 / 100);
        $bpjs_tk_jht_employee = $bpjs_tk_salary * (2 / 100);
        $bpjs_tk_jht_company = $bpjs_tk_salary * (3.7 / 100);
        $bpjs_tk_jp_employee = $bpjs_tk_salary * (1 / 100);
        $bpjs_tk_jp_company = $bpjs_tk_salary * (2 / 100);
        $bpjs_tk_premi = $bpjs_tk_jkk + $bpjs_tk_jkm + $bpjs_tk_jht_employee + $bpjs_tk_jht_company + $bpjs_tk_jp_employee + $bpjs_tk_jp_company;

        //PUNISHMENT
        $punishment = $contract_salary / 30 * $alpa;

        //TAX
        $tax = 0;

        $deduction_total = $bpjs_ks_employee + $bpjs_tk_jht_employee + $bpjs_tk_jp_employee + $punishment + $tax;

        //SALARY RECEIVE TOTAL
        $salary_receive_total = $salary_receive_sub - $deduction_total;
        $salary_receive_final = round($salary_receive_sub, -2);

        $d = array(
          'payroll_detail_id' => $this->uuid->v4(),
          'payroll_id' => $data['payroll_id'],
          'employee_id' => $row['employee_id'],
          'department_id' => $row['department_id'],
          'department_name' => $row['department_name'],
          'division_id' => $row['division_id'],
          'division_name' => $row['division_name'],
          'position_id' => $row['position_id'],
          'position_name' => $row['position_name'],
          'employee_status_id' => $row['employee_status_id'],
          'employee_status_name' => $row['employee_status_name'],
          'salary_status_id' => $row['salary_status_id'],
          'salary_status_name' => $row['salary_status_name'],
          'family_status_id' => $row['family_status_id'],
          'family_status_name' => $row['family_status_name'],
          'warning_letter_1' => $row['warning_letter_1'],
          'warning_letter_2' => $row['warning_letter_2'],
          'warning_letter_3' => $row['warning_letter_3'],
          'warning_letter_end' => $row['warning_letter_end'],
          'alpa_total' => $alpa,
          'izin_total' => $izin,
          'sakit_total' => $sakit,
          'libur_total' => $libur,
          'cuti_total' => $cuti,
          'work_days_total' => $work_days_total,
          'normal_work_days_contract' => $normal_work_days_contract,
          'normal_work_days_parttime' => $normal_work_days_parttime,
          'normal_work_days_total' => $normal_work_days_total,
          'overtime_regular' => $overtime_regular,
          'overtime_off' => $overtime_off,
          'overtime_holiday' => $overtime_holiday,
          'overtime_over' => $overtime_over,
          'overtime_total' => $overtime_total,
          'hourmachine_total' => $hourmachine_total,
          'contract_salary' => $contract_salary,
          'parttime_salary' => $parttime_salary,
          'overtime_salary' => $overtime_salary,
          'salary_parttime_sub' => $salary_parttime_sub,
          'salary_contract_sub' => $salary_contract_sub,
          'salary_receive_sub' => $salary_receive_sub,
          'meal_all' => $meal_all,
          'comm_trans_all' => $comm_trans_all,
          'coeficient_all' => $coeficient_all,
          'overtime_all' => $overtime_all,
          'hourmachine_all' => $hourmachine_all,
          'expense_all' => $expense_all,
          'all_total' => $all_total,
          'bpjs_ks_salary' => $bpjs_ks_salary,
          'bpjs_ks_employee' => $bpjs_ks_employee,
          'bpjs_ks_company' => $bpjs_ks_company,
          'bpjs_ks_premi' => $bpjs_ks_premi,
          'bpjs_tk_salary' => $bpjs_tk_salary,
          'bpjs_tk_jkk' => $bpjs_tk_jkk,
          'bpjs_tk_jkm' => $bpjs_tk_jkm,
          'bpjs_tk_jht_employee' => $bpjs_tk_jht_employee,
          'bpjs_tk_jht_company' => $bpjs_tk_jht_company,
          'bpjs_tk_jp_employee' => $bpjs_tk_jp_employee,
          'bpjs_tk_jp_company' => $bpjs_tk_jp_company,
          'bpjs_tk_premi' => $bpjs_tk_premi,
          'punishment' => $punishment,
          'tax' => $tax,
          'deduction_total' => $deduction_total,
          'salary_receive_total' => $salary_receive_total,
          'salary_receive_final' => $salary_receive_final
        );

        $d['created_at'] = date('Y-m-d H:i:s');
        $d['created_by'] = $this->session->userdata('user_fullname');

        $this->db->insert('payroll_detail', $d);
      }
    } else {
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('payroll_id', $id)->update('payroll', $data);
    }
  }

  public function update($id, $data)
  {
    $data['updated_at'] = date('Y-m-d H:i:s');
    $data['updated_by'] = $this->session->userdata('fullname');
    $this->db->where('payroll_id', $id)->update('payroll', $data);
  }

  public function delete($id, $permanent = true)
  {
    if ($permanent) {
      $this->db->where('payroll_id', $id)->delete('payroll_detail');
      $this->db->where('payroll_id', $id)->delete('payroll');
    } else {
      $data['is_deleted'] = 1;
      $data['deleted_at'] = date('Y-m-d H:i:s');
      $data['deleted_by'] = $this->session->userdata('user_fullname');
      $this->db->where('payroll_id', $id)->update('payroll', $data);
      $this->db->where('payroll_id', $id)->update('payroll_detail', $data);
    }
  }
}
