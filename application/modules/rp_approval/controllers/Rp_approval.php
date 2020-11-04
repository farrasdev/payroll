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
    $pdf = new Pdf('p', 'mm', array(330, 210)); //f4
    $pdf->AliasNbPages();
    $pdf->SetTitle('Overtime ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])));
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
    $pdf->Line(10, 23.5, 200, 23.5);

    //TITLE
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'BU', 12);
    $pdf->Cell(0, 5, 'REKAP OVERTIME', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])), 0, 1, 'C');

    //TABLE HEADER
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, 'No.', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Divisi', 1, 0, 'C');
    $pdf->Cell(22, 10, 'Total Pegawai', 1, 0, 'C');
    $pdf->Cell(108, 5, 'Divisi', 1, 1, 'C');

    $pdf->Cell(82, 5, '', 0, 0, 'C');
    $pdf->Cell(22, 5, 'Regular', 1, 0, 'C');
    $pdf->Cell(22, 5, 'OFF', 1, 0, 'C');
    $pdf->Cell(22, 5, 'Tgl Merah', 1, 0, 'C');
    $pdf->Cell(22, 5, 'Total (Hour)', 1, 0, 'C');
    $pdf->Cell(20, 5, 'Total (Rp)', 1, 1, 'C');



    $pdf->SetWidths(array(10, 50, 22, 22, 22, 22, 22, 20));
    $i = 1;
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C'));
    foreach ($main as $row) {
      $pdf->Row(array(
        $i++,
        $row['division_name'],
        $row['employee_total'],
        num_id($row['overtime_regular_total']),
        num_id($row['overtime_off_total']),
        num_id($row['overtime_holiday_total']),
        num_id($row['overtime_total_total']),
        num_id($row['overtime_all_total']),
      ));
    }
    $pdf->Output('I', 'Overtime ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])) . '-' . date('Ymdhis') . '.pdf');
  }
}
