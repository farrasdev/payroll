<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Salary_slip extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_salary_slip',
      'payroll/m_payroll',
      'employee/m_employee'
    ));

    $this->menu_id = '33.03';
    $this->menu = $this->m_config->get_menu($this->menu_id);
    if ($this->menu == null) redirect(site_url() . '/error/error_403');

    //cookie 
    $this->cookie = get_cookie_menu($this->menu_id);
    if ($this->cookie['search'] == null) $this->cookie['search'] = array('term' => '');
    if ($this->cookie['order'] == null) $this->cookie['order'] = array('field' => 'created_at', 'type' => 'desc');
    if ($this->cookie['per_page'] == null) $this->cookie['per_page'] = 10;
    if ($this->cookie['cur_page'] == null) 0;
  }

  public function index()
  {
    redirect(site_url() . '/' . $this->menu['controller'] . '/form');
  }

  public function form()
  {
    $data['menu'] = $this->menu;
    $data['payroll'] = $this->m_payroll->all_data();
    $data['employee'] = $this->m_employee->all_data();

    $this->render('form', $data);
  }

  public function action()
  {
    $data = $this->input->post();
    $check = $this->m_salary_slip->get_data($data['payroll_id'], $data['employee_id']);
    if ($check == null) {
      $this->session->set_flashdata('flash_error', 'Pegawai tidak ditemukan pada periode pengupahan.');
      redirect(site_url() . '/' . $this->menu['controller'] . '/form');
    } else {
      redirect(site_url() . '/' . $this->menu['controller'] . '/slip/' . $data['payroll_id'] . '/' . $data['employee_id']);
    }
  }

  public function slip($payroll_id = "", $employee_id = "")
  {
    if ($payroll_id == "" || $employee_id == "") {
      redirect(site_url() . '/' . $this->menu['controller'] . '/form');
    } else {
      $data['detail'] = $this->m_salary_slip->get_data($payroll_id, $employee_id);
      $data['payroll'] = $this->m_salary_slip->get_payroll($payroll_id);
      if ($data['detail'] == null) {
        redirect(site_url() . '/' . $this->menu['controller'] . '/form');
      } else {
        $data['menu'] = $this->menu;
        $this->render('slip', $data);
      }
    }
  }
}
