<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_attendance extends CI_Model
{

  public function where($cookie)
  {
    $where = "WHERE a.is_deleted = 0 ";
    if (@$cookie['search']['term'] != '') {
      $where .= "AND b.employee_name LIKE '%" . $this->db->escape_like_str($cookie['search']['term']) . "%' ";
    }
    return $where;
  }

  public function list_data($cookie)
  {
    $where = $this->where($cookie);
    $sql = "SELECT 
        a.*, b.employee_name, c.department_name, d.division_name, e.position_name, 
        f.shift_id, f.shift_name
      FROM attendance a 
      JOIN employee b ON a.employee_id = b.employee_id
      LEFT JOIN department c ON b.department_id = c.department_id
      LEFT JOIN division d ON b.division_id = d.division_id
      LEFT JOIN position e ON b.position_id = e.position_id
      JOIN shift f ON a.shift_id = f.shift_id
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

    $sql = "SELECT 
              a.*, b.employee_name, c.department_name, d.division_name, e.position_name, 
              f.shift_id, f.shift_name
            FROM attendance a 
            JOIN employee b ON a.employee_id = b.employee_id
            LEFT JOIN department c ON b.department_id = c.department_id
            LEFT JOIN division d ON b.division_id = d.division_id
            LEFT JOIN position e ON b.position_id = e.position_id
            JOIN shift f ON a.shift_id = f.shift_id 
            ORDER BY created_at";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_rows($cookie)
  {
    $where = $this->where($cookie);

    $sql = "SELECT 
              COUNT(1) as total
            FROM attendance a 
            JOIN employee b ON a.employee_id = b.employee_id
            LEFT JOIN department c ON b.department_id = c.department_id
            LEFT JOIN division d ON b.division_id = d.division_id
            LEFT JOIN position e ON b.position_id = e.position_id
            JOIN shift f ON a.shift_id = f.shift_id
            $where";
    $query = $this->db->query($sql);
    return $query->row_array()['total'];
  }

  function by_field($field, $val)
  {
    $sql = "SELECT 
            a.*, b.employee_name, c.department_name, d.division_name, e.position_name, 
            f.shift_id, f.shift_name
          FROM attendance a 
          JOIN employee b ON a.employee_id = b.employee_id
          LEFT JOIN department c ON b.department_id = c.department_id
          LEFT JOIN division d ON b.division_id = d.division_id
          LEFT JOIN position e ON b.position_id = e.position_id
          JOIN shift f ON a.shift_id = f.shift_id WHERE $field = ?";
    $query = $this->db->query($sql, array($val));
    $row = $query->row_array();
    return $row;
  }

  public function save($data, $id = null)
  {
    if ($id == null) {
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['created_by'] = $this->session->userdata('user_fullname');
      $this->db->insert('attendance', $data);
    } else {
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('attendance_id', $id)->update('attendance', $data);
    }
  }

  public function update($id, $data)
  {
    $data['updated_at'] = date('Y-m-d H:i:s');
    $data['updated_by'] = $this->session->userdata('fullname');
    $this->db->where('attendance_id', $id)->update('attendance', $data);
  }

  public function delete($id, $permanent = true)
  {
    if ($permanent) {
      $this->db->where('attendance_id', $id)->delete('attendance');
    } else {
      $data['is_deleted'] = 1;
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('attendance_id', $id)->update('attendance', $data);
    }
  }

  public function get_collective($data)
  {
    $diff = date_difference($data['end_date'], $data['start_date']) + 1;
    $result = array();

    for ($i = 0; $i < $diff; $i++) {
      $cur_date = date('Y-m-d', strtotime($data['start_date'] . " + $i days"));
      $row = array(
        'attendance_id' => '',
        'shift_id' => '',
        'attendance_date' => $cur_date,
        'regulartime' => "0",
        'hourmachine' => "0",
        'overtime_15' => "0",
        'overtime_2' => "0",
        'overtime_3' => "0",
        'overtime_4' => "0",
      );
      $attendance = $this->db->query(
        "SELECT 
          attendance_id, shift_id, attendance_date, regulartime, hourmachine, 
          overtime_15, overtime_2, overtime_3, overtime_4 
        FROM attendance 
        WHERE 
          attendance_date = '$cur_date' 
          AND employee_id ='" . $data['employee_id'] . "'"
      )->row_array();
      if ($attendance != null) {
        array_push($result, $attendance);
      } else {
        array_push($result, $row);
      }
    }
    return $result;
  }

  public function save_collective($data)
  {
    foreach ($data['attendance_id'] as $k => $v) {
      $d = array(
        'attendance_id' => $data['attendance_id'][$k],
        'shift_id' => $data['shift_id_' . $k],
        'employee_id' => $data['employee_id'],
        'attendance_date' => $data['attendance_date_' . $k],
        'regulartime' => $data['regulartime_' . $k],
        'hourmachine' => $data['hourmachine_' . $k],
        'overtime_15' => $data['overtime_15_' . $k],
        'overtime_2' => $data['overtime_2_' . $k],
        'overtime_3' => $data['overtime_3_' . $k],
        'overtime_4' => $data['overtime_4_' . $k],
      );
      if ($data['attendance_id'][$k] == '') {
        //insert
        $d['attendance_id'] = $this->uuid->v4();
        $d['created_at'] = date('Y-m-d H:i:s');
        $d['created_by'] = $this->session->userdata('user_fullname');
        $this->db->insert('attendance', $d);
      } else {
        //update
        $d['updated_at'] = date('Y-m-d H:i:s');
        $d['updated_by'] = $this->session->userdata('user_fullname');
        $this->db->where('attendance_id', $data['attendance_id'][$k])->update('attendance', $d);
      }
    }
  }
}
