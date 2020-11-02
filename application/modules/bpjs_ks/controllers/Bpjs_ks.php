<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bpjs_ks extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_bpjs_ks',
      'payroll/m_payroll'
    ));

    $this->menu_id = '33.01';
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
    $this->render('form', $data);
  }

  public function action()
  {
    $data = $this->input->post();
    redirect(site_url() . '/' . $this->menu['controller'] . '/detail/' . $data['payroll_id']);
  }

  public function detail($id = null)
  {
    ($id == null) ? authorize($this->menu, '_create') : authorize($this->menu, '_update');
    if ($id == null) {
      redirect(site_url() . '/' . $this->menu['controller'] . '/' . $this->menu['url'] . '/' . $this->cookie['cur_page']);
    }

    $data['search'] = @$this->session->userdata("search_" . $this->menu_id);

    $config['per_page'] = 10;
    $config['base_url'] = site_url() . '/' . $this->menu['controller'] . '/detail/' . $id . '/';
    $config['total_rows'] = $this->m_bpjs_ks->detail_total($id, $data['search'])['total'];
    $this->pagination->initialize($config);

    $data['cur_page'] = $this->uri->segment(4, 0);
    $data['main'] = $this->m_bpjs_ks->detail($id, $data['cur_page'], $config['per_page'], $data['search']);
    $data['payroll'] = $this->m_bpjs_ks->by_field('payroll_id', $id);
    $data['id'] = $id;
    $data['menu'] = $this->menu;
    $this->render('detail', $data);
  }

  public function search_detail($id)
  {
    $search = html_escape($this->input->post('search'));
    $this->session->set_userdata(array("search_" . $this->menu_id => $search));
    redirect(site_url() . '/' . $this->menu['controller'] . '/detail/' . $id . '/');
  }

  public function reset_detail($id)
  {
    $this->session->set_userdata(array("search_" . $this->menu_id => ""));
    redirect(site_url() . '/' . $this->menu['controller'] . '/detail/' . $id . '/');
  }
}
