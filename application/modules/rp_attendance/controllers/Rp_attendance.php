<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rp_attendance extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_rp_attendance',
      'payroll/m_payroll',
      'employee/m_employee'
    ));

    $this->menu_id = '22';
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

    $this->render('form', $data);
  }

  public function action()
  {
    $data = $this->input->post();
    $diff = date_difference($data['start_date'], $data['end_date']) + 1;
    if ($diff > 31) {
      $this->session->set_flashdata('flash_error', 'Rentang tanggal tidak boleh lebih dari 31 hari.');
      redirect(site_url() . '/' . $this->menu['controller'] . '/form');
    }
    if (strtotime($data['end_date']) < strtotime($data['start_date'])) {
      $this->session->set_flashdata('flash_error', 'Tanggal akhir tidak boleh kurang dari tanggal awal.');
      redirect(site_url() . '/' . $this->menu['controller'] . '/form');
    }
    redirect(site_url() . '/' . $this->menu['controller'] . '/detail/' . $data['start_date'] . '/' . $data['end_date']);
  }

  public function detail($start_date = "", $end_date = "")
  {
    if ($start_date == "" || $end_date == "") {
      redirect(site_url() . '/' . $this->menu['controller'] . '/form');
    } else {
      $data['main'] = $this->m_rp_attendance->get_data($start_date, $end_date);
      if ($data['main'] == null) {
        redirect(site_url() . '/' . $this->menu['controller'] . '/form');
      } else {
        $data['menu'] = $this->menu;
        $diff = date_difference($end_date, $start_date);
        $data['date'] = array();
        for ($i = 0; $i <= $diff; $i++) {
          $cur_date = date('Y-m-d', strtotime($start_date . " + $i days"));
          $data['date'][] = $cur_date;
        }
        $this->render('detail', $data);
      }
    }
  }
}
