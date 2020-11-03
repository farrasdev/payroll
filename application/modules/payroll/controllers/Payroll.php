<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll extends MY_Controller
{

  var $menu_id, $menu, $cookie;

  function __construct()
  {
    parent::__construct();

    $this->load->model(array(
      'config/m_config',
      'm_payroll'
    ));

    $this->menu_id = '32';
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
    authorize($this->menu, '_read');
    //cookie
    $this->cookie['cur_page'] = $this->uri->segment(3, 0);
    $this->cookie['total_rows'] = $this->m_payroll->all_rows($this->cookie);
    set_cookie_menu($this->menu_id, $this->cookie);
    //main data
    $data['menu'] = $this->menu;
    $data['cookie'] = $this->cookie;
    $data['main'] = $this->m_payroll->list_data($this->cookie);
    $data['pagination_info'] = pagination_info(count($data['main']), $this->cookie);
    //set pagination
    set_pagination($this->menu, $this->cookie);
    //render
    $this->render('index', $data);
  }

  public function form($id = null)
  {
    ($id == null) ? authorize($this->menu, '_create') : authorize($this->menu, '_update');
    if ($id == null) {
      create_log(2, $this->menu['menu_name']);
      $data['main'] = null;
    } else {
      create_log(3, $this->menu['menu_name']);
      $data['main'] = $this->m_payroll->by_field('payroll_id', $id);
    }
    $data['id'] = $id;
    $data['menu'] = $this->menu;
    $this->render('form', $data);
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
    $config['total_rows'] = $this->m_payroll->detail_total($id, $data['search'])['total'];
    $this->pagination->initialize($config);

    $data['cur_page'] = $this->uri->segment(4, 0);
    $data['main'] = $this->m_payroll->detail($id, $data['cur_page'], $config['per_page'], $data['search']);
    $data['payroll'] = $this->m_payroll->by_field('payroll_id', $id);
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

  public function save($id = null)
  {
    ($id == null) ? authorize($this->menu, '_create') : authorize($this->menu, '_update');
    html_escape($data = $this->input->post(null, true));
    if (!isset($data['is_active'])) {
      $data['is_active'] = 0;
    }
    $data['start_date'] = reverse_date($data['start_date']);
    $data['end_date'] = reverse_date($data['end_date']);
    $cek = $this->m_payroll->by_field('payroll_id', $data['payroll_id']);

    $diff = date_difference($data['end_date'], $data['start_date']);
    if ($diff <= 31) {
      if ($id == null) {
        if ($cek != null) {
          $this->session->set_flashdata('flash_error', 'Data sudah ada di sistem.');
          redirect(site_url() . '/' .  $this->menu['controller']  . '/form/');
        }
        $data['payroll_id'] = $this->uuid->v4();
        unset($data['old']);
        $this->m_payroll->save($data, $id);
        create_log(2, $this->menu['menu_name']);
        $this->session->set_flashdata('flash_success', 'Data berhasil ditambahkan.');
      } else {
        if ($data['old'] != $data['payroll_id'] && $cek != null) {
          $this->session->set_flashdata('flash_error', 'Data sudah ada di sistem.');
          redirect(site_url() . '/' . $this->menu['controller'] . '/form/' . $id);
        }
        unset($data['old']);
        $this->m_payroll->save($data, $id);
        create_log(3, $this->menu['menu_name']);
        $this->session->set_flashdata('flash_success', 'Data berhasil diubah.');
      }
      redirect(site_url() . '/' . $this->menu['controller'] . '/' . $this->menu['url'] . '/' . $this->cookie['cur_page']);
    } else {
      $this->session->set_flashdata('flash_error', 'Tanggal tidak boleh lebih dari 31.');
      redirect(site_url() . '/' .  $this->menu['controller']  . '/form/');
    }
  }

  public function delete($id = null)
  {
    ($id == null) ? authorize($this->menu, '_create') : authorize($this->menu, '_update');
    $this->m_payroll->delete($id);
    create_log(4, $this->menu['menu_name']);
    $this->session->set_flashdata('flash_success', 'Data berhasil dihapus.');
    redirect(site_url() . '/' . $this->menu['controller'] . '/' . $this->menu['url'] . '/' . $this->cookie['cur_page']);
  }

  public function status($type = null, $id = null)
  {
    authorize($this->menu, '_update');
    if ($type == 'enable') {
      $this->m_payroll->update($id, array('is_active' => 1));
    } else {
      $this->m_payroll->update($id, array('is_active' => 0));
    }
    create_log(3, $this->this->menu['menu_name']);
    redirect(site_url() . '/' . $this->menu['controller'] . '/' . $this->menu['url'] . '/' . $this->cookie['cur_page']);
  }

  public function multiple($type = null)
  {
    $data = $this->input->post(null, true);
    if (isset($data['checkitem'])) {
      foreach ($data['checkitem'] as $key) {
        switch ($type) {
          case 'delete':
            authorize($this->menu, '_delete');
            $this->m_payroll->delete($key);
            $flash = 'Data berhasil dihapus.';
            $t = 4;
            break;

          case 'enable':
            authorize($this->menu, '_update');
            $this->m_payroll->update($key, array('is_active' => 1));
            $flash = 'Data berhasil diaktifkan.';
            $t = 3;
            break;

          case 'disable':
            authorize($this->menu, '_update');
            $this->m_payroll->update($key, array('is_active' => 0));
            $flash = 'Data berhasil dinonaktifkan.';
            $t = 3;
            break;
        }
      }
    }
    create_log($t, $this->menu['menu_name']);
    $this->session->set_flashdata('flash_success', $flash);
    redirect(site_url() . '/' . $this->menu['controller'] . '/' . $this->menu['url'] . '/' . $this->cookie['cur_page']);
  }

  public function ajax($type = null, $id = null)
  {
    if ($type == 'check_id') {
      $data = $this->input->post();
      $cek = $this->m_payroll->by_field('payroll_id', $data['payroll_id']);
      if ($id == null) {
        echo ($cek != null) ? 'false' : 'true';
      } else {
        echo ($id != $data['payroll_id'] && $cek != null) ? 'false' : 'true';
      }
    }
  }

  public function pdf($id)
  {
    $main = $this->m_payroll->detail_all($id);
    $payroll = $this->m_payroll->by_field('payroll_id', $id);
    $profile = $this->m_profile->get_first();
    $this->load->library('pdf');
    $pdf = new Pdf('l', 'mm', array(297, 420)); //A3
    $pdf->AliasNbPages();
    $pdf->SetTitle('Pengupahan ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])));
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
    $pdf->Line(10, 23.5, 410, 23.5);

    //TITLE
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'BU', 12);
    $pdf->Cell(0, 5, 'REKAP PENGUPAHAN', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])), 0, 1, 'C');

    //TABLE HEADER
    $pdf->Cell(0, 8, '', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(15, 10, 'NIK', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Nama Pegawai', 1, 0, 'C');
    $pdf->Cell(8, 10, 'Dept', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Divisi', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Posisi', 1, 0, 'C');
    $pdf->Cell(15, 10, 'NPWP', 1, 1, 'C');

    //TABLE ROW
    $pdf->SetWidths(array(10, 15, 45, 8, 25, 30, 30, 30, 30, 30));
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetAligns(array('C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
    $i = 1;
    foreach ($main as $row) {
      $pdf->Row(array(
        $i++,
        $row['employee_id'],
        $row['employee_name'],
        $row['department_name'],
        $row['division_name'],
        $row['position_name'],
        $row['tax_number'],
        // num_id($row['payroll_salary']),
        // num_id($row['payroll_employee']),
        // num_id($row['payroll_company']),
        // num_id($row['payroll_premi']),
      ));
    }
    $pdf->Output('I', 'Pengupahan ' . date_id(($payroll['start_date'])) . ' s/d ' . date_id(($payroll['end_date'])) . '-' . date('Ymdhis') . '.pdf');
  }
}
