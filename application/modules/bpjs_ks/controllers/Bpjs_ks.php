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

  public function pdf($id)
  {
    $main = $this->m_bpjs_ks->detail_all($id);
    $payroll = $this->m_payroll->by_field('payroll_id', $id);
    $profile = $this->m_profile->get_first();
    $this->load->library('pdf');
    $pdf = new Pdf('l', 'mm', array(330, 210)); //A5
    $pdf->AliasNbPages();
    $pdf->SetTitle('BPJS Kesehatan ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])));
    $pdf->AddPage();

    //HEADER
    $pdf->Image(FCPATH . 'images/logos/' . $profile['logo'], 12, 9, 12, 12);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(15, 5, '', 0, 0, 'L');
    $pdf->Cell(0, 5, $profile['company_name'], 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(15, 6, '', 0, 0, 'L');
    $pdf->Cell(0, 6, $profile['address'], 0, 1, 'L');
    $pdf->Cell(2, 6, '', 0, 0, 'L');
    $pdf->Line(10, 23.5, 320, 23.5);

    //TITLE
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'BU', 12);
    $pdf->Cell(0, 5, 'REKAP BPJS KESEHATAN', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])), 0, 1, 'C');

    //TABLE HEADER
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetWidths(array(10, 18, 65, 15, 32, 50, 30, 30, 30, 30));
    $pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
    $pdf->Row(array('No.', 'NIK', 'Nama Pegawai', 'Dept', 'Divisi', 'Posisi', 'Upah', 'Pegawai 1%', 'Perusahaan 4%', 'Total Iuran'));
    $i = 1;
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetAligns(array('C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
    foreach ($main as $row) {
      $pdf->Row(array(
        $i++,
        $row['employee_id'],
        $row['employee_name'],
        $row['department_name'],
        $row['division_name'],
        $row['position_name'],
        num_id($row['bpjs_ks_salary']),
        num_id($row['bpjs_ks_employee']),
        num_id($row['bpjs_ks_company']),
        num_id($row['bpjs_ks_premi']),
      ));
    }
    $pdf->Output('I', 'BPJS Kesehatan ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])) . '-' . date('Ymdhis') . '.pdf');
  }
}
