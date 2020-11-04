<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rp_approval extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_rp_approval',
      'payroll/m_payroll'
    ));

    $this->menu_id = '33.05';
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

    $config['per_page'] = 50;
    $config['base_url'] = site_url() . '/' . $this->menu['controller'] . '/detail/' . $id . '/';
    $config['total_rows'] = $this->m_rp_approval->detail_total($id, $data['search'])['total'];
    $this->pagination->initialize($config);

    $data['cur_page'] = $this->uri->segment(4, 0);
    $data['main'] = $this->m_rp_approval->detail($id, $data['cur_page'], $config['per_page'], $data['search']);
    $data['payroll'] = $this->m_rp_approval->by_field('payroll_id', $id);
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
    $main = $this->m_rp_approval->detail_all($id);
    $payroll = $this->m_payroll->by_field('payroll_id', $id);
    $profile = $this->m_profile->get_first();
    $this->load->library('pdf');
    $pdf = new Pdf('l', 'mm', array(297, 420)); //f4
    $pdf->AliasNbPages();
    $pdf->SetTitle('Rekapitulasi Upah Karyawan ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])));
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
    $pdf->Line(10, 23.5, 413, 23.5);

    //TITLE
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'BU', 12);
    $pdf->Cell(0, 5, 'REKAPITULASI UPAH KARYAWAN', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])), 0, 1, 'C');

    //TABLE HEADER
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, 'No.', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Divisi', 1, 0, 'C');
    $pdf->Cell(21, 10, 'Total Pegawai', 1, 0, 'C');
    $pdf->Cell(169, 5, 'Pendapatan Kotor', 1, 0, 'C');
    $pdf->Cell(137, 5, 'Potongan', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Pend. Bersih', 1, 0, 'C');
    $pdf->Cell(2, 5, '', 0, 1, 'C');

    $pdf->Cell(71, 5, '', 0, 0, 'C');
    $pdf->Cell(22, 5, 'Pend. Diterima', 1, 0, 'C');
    $pdf->Cell(21, 5, 'T. Jabatan', 1, 0, 'C');
    $pdf->Cell(21, 5, 'Uang Makan', 1, 0, 'C');
    $pdf->Cell(21, 5, 'Hourmachine', 1, 0, 'C');
    $pdf->Cell(21, 5, 'Overtime', 1, 0, 'C');
    $pdf->Cell(21, 5, 'T. Koefisien', 1, 0, 'C');
    $pdf->Cell(21, 5, 'Lain-lain', 1, 0, 'C');
    $pdf->Cell(21, 5, 'Total Pend.', 1, 0, 'C');
    $pdf->Cell(25, 5, 'BPJS TK JHT 2%', 1, 0, 'C');
    $pdf->Cell(25, 5, 'BPJS TK JP 1%', 1, 0, 'C');
    $pdf->Cell(25, 5, 'BPJS KS 1%', 1, 0, 'C');
    $pdf->Cell(20, 5, 'Lain-lain', 1, 0, 'C');
    $pdf->Cell(20, 5, 'PPh 21', 1, 0, 'C');
    $pdf->Cell(22, 5, 'Total Pot.', 1, 1, 'C');

    $pdf->SetWidths(array(10, 40, 22, 21, 21, 21, 21, 21, 21, 21, 21, 25, 25, 25, 20, 20, 22, 25));
    $i = 1;
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
    foreach ($main as $r) {
      $gross_salary = $r['salary_receive_sub_total'] + $r['position_all_total'] + $r['meal_all_total'] + $r['hourmachine_all_total'] + $r['overtime_all_total'] + $r['coeficient_all_total'] + $r['expense_all_total'];
      $deduction = $r['bpjs_tk_jht_employee_total'] + $r['bpjs_tk_jp_employee_total'] + $r['bpjs_ks_employee_total'] + $r['punishment_total'] + $r['tax_total'];
      $pdf->Row(array(
        $i++,
        $r['division_name'],
        $r['employee_total'],
        num_id(1000000000 + $r['salary_receive_sub_total']),
        num_id($r['position_all_total']),
        num_id($r['meal_all_total']),
        num_id($r['hourmachine_all_total']),
        num_id($r['overtime_all_total']),
        num_id($r['coeficient_all_total']),
        num_id($r['expense_all_total']),
        num_id($gross_salary),
        num_id($r['bpjs_tk_jht_employee_total']),
        num_id($r['bpjs_tk_jp_employee_total']),
        num_id($r['bpjs_ks_employee_total']),
        num_id($r['punishment_total']),
        num_id($r['tax_total']),
        num_id($deduction),
        num_id($gross_salary - $deduction)
      ));
    }
    $pdf->Output('I', 'Rekapitulasi Upah Karyawan ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])) . '-' . date('Ymdhis') . '.pdf');
  }
}
