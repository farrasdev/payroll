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
        );
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
