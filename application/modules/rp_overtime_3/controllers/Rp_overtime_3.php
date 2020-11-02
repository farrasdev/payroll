<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rp_overtime_3 extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_rp_overtime_3',
      'payroll/m_payroll',
      'employee/m_employee'
    ));

    $this->menu_id = '22.05';
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
      $data['search'] = @$this->session->userdata("search_" . $this->menu_id);

      $config['per_page'] = 10;
      $config['base_url'] = site_url() . '/' . $this->menu['controller'] . '/detail/' . $start_date . '/' . $end_date . '/';
      $config['total_rows'] = $this->m_payroll->detail_total($data['search'])['total'];
      $this->pagination->initialize($config);

      $data['cur_page'] = $this->uri->segment(5, 0);
      $data['main'] = $this->m_rp_overtime_3->detail($start_date, $end_date, $data['cur_page'], $config['per_page'], $data['search']);
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;

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

  public function search_detail($start_date, $end_date)
  {
    $search = html_escape($this->input->post('search'));
    $this->session->set_userdata(array("search_" . $this->menu_id => $search));
    redirect(site_url() . '/' . $this->menu['controller'] . '/detail/' . $start_date . '/' . $end_date . '/');
  }

  public function reset_detail($start_date, $end_date)
  {
    $this->session->set_userdata(array("search_" . $this->menu_id => ""));
    redirect(site_url() . '/' . $this->menu['controller'] . '/detail/' . $start_date . '/' . $end_date . '/');
  }

  public function pdf($start_date, $end_date)
  {
    $diff = date_difference($end_date, $start_date);
    $date = array();
    for ($i = 0; $i <= $diff; $i++) {
      $cur_date = date('Y-m-d', strtotime($start_date . " + $i days"));
      $date[] = $cur_date;
    }
    $main = $this->m_rp_overtime_3->detail_all($start_date, $end_date);
    $profile = $this->m_profile->get_first();
    $this->load->library('pdf');
    $pdf = new Pdf('l', 'mm', array(330, 210)); //A5
    $pdf->AliasNbPages();
    $pdf->SetTitle('Overtime 3 ' . date_id(reverse_date($start_date)) . ' s/d ' . date_id(reverse_date($end_date)));
    $pdf->AddPage();

    //HEADER
    $pdf->Image(FCPATH . 'images/logos/' . $profile['logo'], 12, 9, 12, 12);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(3, 5, '', 0, 0, 'L');
    $pdf->Cell(0, 5, $profile['company_name'], 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 6, '', 0, 0, 'L');
    $pdf->Cell(0, 6, $profile['address'], 0, 1, 'L');
    $pdf->Cell(3, 6, '', 0, 0, 'L');
    $pdf->Line(10, 23.5, 320, 23.5);

    //TITLE
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'BU', 12);
    $pdf->Cell(0, 5, 'REKAP OVERTIME 3', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, date_id(reverse_date($start_date)) . ' s/d ' . date_id(reverse_date($end_date)), 0, 1, 'C');

    //TABLE HEADER
    $pdf->Cell(0, 5, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 7.5);
    $pdf->Cell(8, 10, 'No', 1, 0, 'C');
    $pdf->Cell(14, 10, 'NIK', 1, 0, 'C');
    $pdf->Cell(55, 10, 'Nama Pegawai', 1, 0, 'C');
    foreach ($date as $k => $v) {
      $pdf->Cell(7.5, 5, date("D", strtotime($v)), 1, ($k == count($date) - 1) ? 1 : 0, 'C');
    }
    $pdf->Cell(77, 5, '', 0, 0, 'C');
    foreach ($date as $k => $v) {
      $pdf->Cell(7.5, 5, date("d", strtotime($v)), 1, ($k == count($date) - 1) ? 1 : 0, 'C');
    }

    //TABLE ROW
    $pdf->SetFont('Arial', '', 7.5);
    $width = [8, 14, 55];
    $align = ['C', 'C', 'L'];
    foreach ($date as $k => $v) {
      array_push($width, 7.5);
      array_push($align, 'C');
    }
    $pdf->SetWidths($width);
    $pdf->SetAligns($align);
    $i = 1;
    foreach ($main as $k => $v) {
      $row = [
        $i++,
        $v['employee_id'],
        $v['employee_name'],
      ];
      foreach ($v['attendance'] as $k2 => $v2) {
        array_push($row, $v2);
      }
      $pdf->Row($row);
    }

    $pdf->Output('I', 'Overtime 3_' . $start_date . '_' . $end_date . '-' . date('Ymdhis') . '.pdf');
  }
}
