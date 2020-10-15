<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_roles extends CI_Model
{

  public function where($cookie)
  {
    $where = "WHERE a.is_deleted = 0 ";
    if (@$cookie['search']['term'] != '') {
      $where .= "AND a.role_name LIKE '%" . $this->db->escape_like_str($cookie['search']['term']) . "%' ";
    }
    return $where;
  }

  public function list_data($cookie)
  {
    $where = $this->where($cookie);
    $sql = "SELECT * FROM roles a 
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

    $sql = "SELECT * FROM roles a $where ORDER BY created_at";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function all_rows($cookie)
  {
    $where = $this->where($cookie);

    $sql = "SELECT COUNT(1) as total FROM roles a $where";
    $query = $this->db->query($sql);
    return $query->row_array()['total'];
  }

  function by_field($field, $val)
  {
    $sql = "SELECT * FROM roles WHERE $field = ?";
    $query = $this->db->query($sql, array($val));
    $row = $query->row_array();
    return $row;
  }

  public function save($data, $id = null)
  {
    if ($id == null) {
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['created_by'] = $this->session->userdata('user_fullname');
      $this->db->insert('roles', $data);
    } else {
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('role_id', $id)->update('roles', $data);
    }
  }

  public function update($id, $data)
  {
    $data['updated_at'] = date('Y-m-d H:i:s');
    $data['updated_by'] = $this->session->userdata('fullname');
    $this->db->where('role_id', $id)->update('roles', $data);
  }

  public function delete($id, $permanent = true)
  {
    if ($permanent) {
      $this->db->where('role_id', $id)->delete('roles');
    } else {
      $data['is_deleted'] = 1;
      $data['updated_at'] = date('Y-m-d H:i:s');
      $data['updated_by'] = $this->session->userdata('user_fullname');
      $this->db->where('role_id', $id)->update('roles', $data);
    }
  }

  public function menu_list($id)
  {
    return $this->db->query(
      "SELECT 
      a.menu_id, a.parent_id, a.menu_name, 
      b._read, b._create, b._update, b._delete, b._report
    FROM menus a
    LEFT JOIN role_menu b ON b.menu_id = a.menu_id AND b.role_id = '$id'
    ORDER BY a.menu_id"
    )->result_array();
  }

  public function authorization_save($data, $id)
  {
    $this->db->where('role_id', $id)->delete('role_menu');
    //read
    foreach ($data['_read'] as $k => $v) {
      $this->db->insert('role_menu', array(
        'menu_id' => $v,
        'role_id' => $id,
        '_read' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => $this->session->userdata('user_fullname'),
      ));
    }

    //create
    foreach ($data['_create'] as $k => $v) {
      $this->db->where(array('menu_id' => $v, 'role_id' => $id))->update('role_menu', array(
        '_create' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => $this->session->userdata('user_fullname'),
      ));
    }

    //update
    foreach ($data['_update'] as $k => $v) {
      $this->db->where(array('menu_id' => $v, 'role_id' => $id))->update('role_menu', array(
        '_update' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => $this->session->userdata('user_fullname'),
      ));
    }

    //delete
    foreach ($data['_delete'] as $k => $v) {
      $this->db->where(array('menu_id' => $v, 'role_id' => $id))->update('role_menu', array(
        '_delete' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => $this->session->userdata('user_fullname'),
      ));
    }

    //report
    foreach ($data['_report'] as $k => $v) {
      $this->db->where(array('menu_id' => $v, 'role_id' => $id))->update('role_menu', array(
        '_report' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => $this->session->userdata('user_fullname'),
      ));
    }
  }
}
