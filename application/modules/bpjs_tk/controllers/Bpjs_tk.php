<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bpjs_tk extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_bpjs_tk',
      'payroll/m_payroll'
    ));

    $this->menu_id = '33.02';
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
    $config['total_rows'] = $this->m_bpjs_tk->detail_total($id, $data['search'])['total'];
    $this->pagination->initialize($config);

    $data['cur_page'] = $this->uri->segment(4, 0);
    $data['main'] = $this->m_bpjs_tk->detail($id, $data['cur_page'], $config['per_page'], $data['search']);
    $data['payroll'] = $this->m_bpjs_tk->by_field('payroll_id', $id);
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
    $main = $this->m_bpjs_tk->detail_all($id);
    $payroll = $this->m_payroll->by_field('payroll_id', $id);
    $profile = $this->m_profile->get_first();
    $this->load->library('pdf');
    $pdf = new Pdf('l', 'mm', array(330, 210)); //A5
    $pdf->AliasNbPages();
    $pdf->SetTitle('BPJS Tenaga Kerja ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])));
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
    $pdf->Cell(0, 5, 'REKAP BPJS TENAGA KERJA', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])), 0, 1, 'C');

    //TABLE HEADER
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(15, 10, 'NIK', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Nama Pegawai', 1, 0, 'C');
    $pdf->Cell(6, 10, 'JK', 1, 0, 'C');
    $pdf->Cell(8, 10, 'Dept', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Divisi', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Posisi', 1, 0, 'C');
    $pdf->Cell(18, 10, 'Tgl Lahir', 1, 0, 'C');
    $pdf->Cell(9, 10, 'Umur', 1, 0, 'C');
    $pdf->Cell(18, 10, 'Status', 1, 0, 'C');
    $pdf->Cell(15, 10, 'Upah', 1, 0, 'C');
    $pdf->Cell(28, 5, 'Karyawan', 1, 0, 'C');
    $pdf->Cell(56, 5, 'Perusahaan', 1, 0, 'C');
    $pdf->Cell(18, 10, 'Iuran', 1, 0, 'C');
    $pdf->Cell(56, 5, '', 0, 1, 'C');


    $pdf->Cell(209, 5, '', 0, 0, 'C');
    $pdf->Cell(14, 5, 'JHT 2%', 1, 0, 'C');
    $pdf->Cell(14, 5, 'JP 1%', 1, 0, 'C');
    $pdf->Cell(14, 5, 'JHT 3.7%', 1, 0, 'C');
    $pdf->Cell(14, 5, 'JP 2%', 1, 0, 'C');
    $pdf->Cell(14, 5, 'JKK 1.7%', 1, 0, 'C');
    $pdf->Cell(14, 5, 'JKM 0.3%', 1, 0, 'C');
    $pdf->Cell(13, 5, '', 0, 1, 'C');
    $i = 1;
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetWidths(array(10, 15, 50, 6, 8, 30, 30, 18, 9, 18, 15, 14, 14, 14, 14, 14, 14, 18));
    $pdf->SetAligns(array('C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
    foreach ($main as $row) {
      $pdf->Row(array(
        $i++,
        $row['employee_id'],
        $row['employee_name'],
        $row['sex'],
        $row['department_name'],
        $row['division_name'],
        $row['position_name'],
        reverse_date($row['dob']),
        date_difference($row['dob'], date('Y-m-d'), '%y'),
        $row['employee_status_name'],
        num_id($row['bpjs_tk_salary']),
        num_id($row['bpjs_tk_jht_employee']),
        num_id($row['bpjs_tk_jp_employee']),
        num_id($row['bpjs_tk_jht_company']),
        num_id($row['bpjs_tk_jp_company']),
        num_id($row['bpjs_tk_jkk_company']),
        num_id($row['bpjs_tk_jkm_company']),
        num_id($row['bpjs_tk_premi']),
      ));
    }
    $pdf->Output('I', 'BPJS Tenaga Kerja ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])) . '-' . date('Ymdhis') . '.pdf');
  }
}
