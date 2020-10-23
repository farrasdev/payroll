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
      'employee/m_employee'
    ));

    $this->menu_id = '22';
    $this->menu = $this->m_config->get_menu($this->menu_id);
    if ($this->menu == null) redirect(site_url() . '/error/error_403');

    //cookie 
    $this->cookie = get_cookie_menu($this->menu_id);
    if ($this->cookie['search'] == null) $this->cookie['search'] = array('term' => '', 'start_date' => '', 'end_date' => '');
    if ($this->cookie['order'] == null) $this->cookie['order'] = array('field' => 'employee_id', 'type' => 'asc');
    if ($this->cookie['per_page'] == null) $this->cookie['per_page'] = 10;
    if ($this->cookie['cur_page'] == null) 0;
  }

  public function index()
  {
    authorize($this->menu, '_read');
    //cookie
    $this->cookie['cur_page'] = $this->uri->segment(3, 0);
    $this->cookie['total_rows'] = $this->m_rp_attendance->all_rows($this->cookie);
    set_cookie_menu($this->menu_id, $this->cookie);
    //main data
    $data['menu'] = $this->menu;
    $data['cookie'] = $this->cookie;
    $start_date = @reverse_date($data['cookie']['search']['start_date']);
    $end_date = @reverse_date($data['cookie']['search']['end_date']);
    $data['error'] = "";
    if ($start_date == '' || $end_date == '') {
      $data['main'] = null;
    } else {
      $data['main'] = null;
      $diff = date_difference($end_date, $start_date);
      if ($diff < 0) {
        $data['error'] = "Tanggal Awal tidak boleh lebih baru dari Tanggal Akhir";
      } else if ($diff + 1 > 31) {
        $data['error'] = "Rentang tanggal tidak boleh lebih dari 31 hari.";
      } else {
        
      }
    }
    $data['pagination_info'] = pagination_info(count($data['main']), $this->cookie);
    //set pagination
    set_pagination($this->menu, $this->cookie);
    //render
    $this->render('index', $data);
  }
}
