<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_attendance extends CI_Model
{

  public function where($cookie)
  {
    $where = "WHERE a.is_deleted = 0 ";
    // if (@$cookie['search']['term'] != '') {
    //   $where .= "AND a.attendance_name LIKE '%" . $this->db->escape_like_str($cookie['search']['term']) . "%' ";
    // }
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

    $sql = "SELECT * FROM attendance a $where ORDER BY created_at";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_rows($cookie)
  {
    $where = $this->where($cookie);

    $sql = "SELECT COUNT(1) as total FROM attendance a $where";
    $query = $this->db->query($sql);
    return $query->row_array()['total'];
  }

  function by_field($field, $val)
  {
    $sql = "SELECT * FROM attendance WHERE $field = ?";
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
}
