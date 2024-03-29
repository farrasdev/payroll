<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-0">
        <div class="col-sm-6">
          <h5 class="m-0 text-dark"><i class="<?= @$menu['icon'] ?>"></i> <?= @$menu['menu_name'] ?></h5>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Payroll</li>
            <li class="breadcrumb-item active"><?= @$menu['menu_name'] ?></li>
            <li class="breadcrumb-item active"><?= ($id == null) ? 'Tambah' : 'Ubah'; ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div><!-- /.content-header -->
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Detail <?= $menu['menu_name'] ?></h3>
            </div>
            <div class="card-body">
              <!-- <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-download"></i> Unduh
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" target="_blank" href="<?= site_url() . '/' . $menu['controller'] . '/pdf/' . $id ?>"><i class="far fa-file-pdf"></i> Berkas PDF</a>
                </div>
              </div> -->
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm">
                      <tbody>
                        <tr>
                          <td>Tanggal Awal</td>
                          <td class="text-center" width="30">:</td>
                          <td><?= date_id($payroll['start_date']) ?></td>
                        </tr>
                        <tr>
                          <td>Tanggal Akhir</td>
                          <td class="text-center" width="30">:</td>
                          <td><?= date_id($payroll['end_date']) ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-3 offset-md-3">
                  <form action="<?= site_url() . '/' . $this->menu['controller'] . '/search_detail/' . $id  ?>" method="post" autocomplete="off">
                    <div class="input-group input-group-sm">
                      <input class="form-control" type="text" name="search" value="<?= @$search ?>" placeholder="Pencarian">
                      <span class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        <a class="btn btn-default" href="<?= site_url() . '/' . $this->menu['controller'] . '/reset_detail/' . $id  ?>"><i class="fas fa-sync-alt"></i></a>
                      </span>
                    </div>
                  </form>
                </div>
              </div><!-- /.row -->
              <div class="table-responsive mt-3">
                <table id="table-detail" class="table table-head-fixed text-nowrap table-striped table-bordered table-sm" style="font-size:11px">
                  <thead>
                    <tr>
                      <th class="text-center text-middle" width="30" rowspan="2">No</th>
                      <th class="text-center text-middle" width="70" rowspan="2">NIK</th>
                      <th class="text-center text-middle" width="200" rowspan="2">Nama Pegawai</th>
                      <th class="text-center text-middle" width="30" rowspan="2">Dept</th>
                      <th class="text-center text-middle" width="120" rowspan="2">Divisi</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Posisi</th>
                      <th class="text-center text-middle" width="120" rowspan="2">NPWP</th>
                      <th class="text-center text-middle" width="70" rowspan="2">Entri Date</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Employee Status</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Salary Status</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Family Status</th>
                      <th class="text-center text-middle" width="70" rowspan="2">Date of Birth</th>
                      <th class="text-center text-middle" colspan="6">Absency</th>
                      <th class="text-center text-middle" colspan="2">Normal Work Days</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Total Normal Work Days</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Overtime Regular</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Overtime OFF</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Overtime Tanggal Merah</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Overtime Kelebihan Jam</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Total Overtime</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Total Hourmachine</th>
                      <th class="text-center text-middle" width="50" colspan="2">Salary</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Overttime Fee</th>
                      <th class="text-center text-middle" width="50" rowspan="2">THL</th>
                      <th class="text-center text-middle" width="50" rowspan="2">PKWT / PKWTT</th>
                      <th class="text-center text-middle" colspan="9">Upah & Tunjangan</th>
                      <th class="text-center text-middle" colspan="6">Deduction</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Total Salary <br>(A-B)</th>
                      <th class="text-center text-middle" width="50" rowspan="2">Total Salary <br>(A-B)<br> (Pembulatan)</th>
                    </tr>
                    <tr>
                      <th class="text-center text-middle" width="30">Total Alpa</th>
                      <th class="text-center text-middle" width="30">Total Izin</th>
                      <th class="text-center text-middle" width="30">Total Sakit</th>
                      <th class="text-center text-middle" width="30">Total OFF</th>
                      <th class="text-center text-middle" width="30">Total Cuti</th>
                      <th class="text-center text-middle" width="30">Total Work Days</th>
                      <th class="text-center text-middle" width="30">THL</th>
                      <th class="text-center text-middle" width="30">PKWT</th>
                      <th class="text-center text-middle" width="30">PKWT / PKWTT</th>
                      <th class="text-center text-middle" width="30">PMOK / THL</th>
                      <th class="text-center text-middle" width="30">Salary Received</th>
                      <th class="text-center text-middle" width="30">Meal All</th>
                      <th class="text-center text-middle" width="30">Position All</th>
                      <th class="text-center text-middle" width="30">Transportasi & Pulsa</th>
                      <th class="text-center text-middle" width="30">Koefisien</th>
                      <th class="text-center text-middle" width="30">Overtime</th>
                      <th class="text-center text-middle" width="30">Hourmachine</th>
                      <th class="text-center text-middle" width="30">Lain-lain</th>
                      <th class="text-center text-middle" width="30">Total (A)</th>
                      <th class="text-center text-middle" width="30">BPJS TK (JHT)</th>
                      <th class="text-center text-middle" width="30">BPJS TK (JP)</th>
                      <th class="text-center text-middle" width="30">BPJS KS</th>
                      <th class="text-center text-middle" width="30">Lain-lain</th>
                      <th class="text-center text-middle" width="30">Pph-21</th>
                      <th class="text-center text-middle" width="30">Total (B)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($main == null) : ?>
                      <tr>
                        <td class="text-center" colspan="99">Tidak ada data</td>
                      </tr>
                    <?php else : ?>
                      <?php $i = 1;
                      foreach ($main as $r) : ?>
                        <tr>
                          <td class="text-middle text-center"><?= $cur_page + ($i++) ?></td>
                          <td class="text-middle text-center"><?= $r['employee_id'] ?></td>
                          <td class="text-middle"><?= $r['employee_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['department_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['division_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['position_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['tax_number'] ?></td>
                          <td class="text-middle text-center"><?= reverse_date($r['entry_date']) ?></td>
                          <td class="text-middle text-center"><?= $r['employee_status_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['salary_status_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['family_status_name'] ?></td>
                          <td class="text-middle text-center"><?= reverse_date($r['dob']) ?></td>
                          <td class="text-middle text-center"><?= $r['alpa_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['izin_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['sakit_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['libur_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['cuti_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['work_days_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['normal_work_days_parttime'] ?></td>
                          <td class="text-middle text-center"><?= $r['normal_work_days_contract'] ?></td>
                          <td class="text-middle text-center"><?= $r['normal_work_days_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['overtime_regular'] ?></td>
                          <td class="text-middle text-center"><?= $r['overtime_off'] ?></td>
                          <td class="text-middle text-center"><?= $r['overtime_holiday'] ?></td>
                          <td class="text-middle text-center"><?= $r['overtime_over'] ?></td>
                          <td class="text-middle text-center"><?= $r['overtime_total'] ?></td>
                          <td class="text-middle text-center"><?= $r['hourmachine_total'] ?></td>
                          <td class="text-middle text-center"><?= num_id($r['contract_salary']) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['parttime_salary'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['overtime_salary'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['salary_parttime_sub'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['salary_contract_sub'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['salary_receive_sub'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['meal_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['position_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['comm_trans_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['coeficient_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['overtime_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['hourmachine_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['expense_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['salary_and_all'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['bpjs_tk_jht_employee'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['bpjs_tk_jp_employee'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['bpjs_ks_employee'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['punishment'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['tax'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['deduction_total'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['salary_receive_total'], 0)) ?></td>
                          <td class="text-middle text-center"><?= num_id(round($r['salary_receive_final'], 0)) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6 float-right">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->