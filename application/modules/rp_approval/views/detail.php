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
            <li class="breadcrumb-item active">Master Data</li>
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
              <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-download"></i> Unduh
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" target="_blank" href="<?= site_url() . '/' . $menu['controller'] . '/pdf/' . $id ?>"><i class="far fa-file-pdf"></i> Berkas PDF</a>
                </div>
              </div>
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
                <table class="table table-head-fixed text-nowrap table-striped table-bordered table-sm" style="font-size:12px;">
                  <thead>
                    <tr>
                      <th class="text-center text-middle" width="30" rowspan="2">No</th>
                      <th class="text-center text-middle" rowspan="2">Divisi</th>
                      <th class="text-center text-middle" width="70" rowspan="2">Total Pegawai</th>
                      <th class="text-center text-middle" colspan="8">Pendapatan Kotor</th>
                      <th class="text-center text-middle" colspan="6">Potongan</th>
                      <th class="text-center text-middle" rowspan="2">Pendapatan Bersih</th>
                    </tr>
                    <tr>
                      <th class="text-center text-middle">Pendapatan Diterima <br>(A)</th>
                      <th class="text-center text-middle">Tunjangan Jabatan <br>(B)</th>
                      <th class="text-center text-middle">Uang Makan <br>(C)</th>
                      <th class="text-center text-middle">Hourmachine <br>(D)</th>
                      <th class="text-center text-middle">Overtime <br>(E)</th>
                      <th class="text-center text-middle">Tunjangan Koefisien <br>(F)</th>
                      <th class="text-center text-middle">Lain-lain <br>(G)</th>
                      <th class="text-center text-middle">Total <br>(A+B+C+D+E+F+G) = (H)</th>

                      <th class="text-center text-middle">BPJS-TK (JHT 2%) <br>(I)</th>
                      <th class="text-center text-middle">BPJS-TK (JP 1%) <br>(J)</th>
                      <th class="text-center text-middle">BPJS-KES (1%) <br>(K)</th>
                      <th class="text-center text-middle">Lain-lain <br>(L)</th>
                      <th class="text-center text-middle">PPh 21 <br>(M)</th>
                      <th class="text-center text-middle">Total <br>(H+I+J+K+L) = (N)</th>
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
                          <td class="text-middle text-center"><?= $i++ ?></td>
                          <td class="text-middle text-left"><?= $r['division_name'] ?></td>
                          <td class="text-middle text-center"><?= num_id($r['employee_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['salary_receive_sub_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['position_all_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['meal_all_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['hourmachine_all_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['overtime_all_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['coeficient_all_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['expense_all_total']) ?></td>
                          <?php $gross_salary = $r['salary_receive_sub_total'] + $r['position_all_total'] + $r['meal_all_total'] + $r['hourmachine_all_total'] + $r['overtime_all_total'] + $r['coeficient_all_total'] + $r['expense_all_total'] ?>
                          <td class="text-middle text-center"><?= num_id($gross_salary) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jht_employee_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jp_employee_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_ks_employee_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['punishment_total']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['tax_total']) ?></td>
                          <?php $deduction = $r['bpjs_tk_jht_employee_total'] + $r['bpjs_tk_jp_employee_total'] + $r['bpjs_ks_employee_total'] + $r['punishment_total'] + $r['tax_total'] ?>
                          <td class="text-middle text-center"><?= num_id($deduction) ?></td>
                          <td class="text-middle text-center"><?= num_id($gross_salary - $deduction) ?></td>
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
<script>

</script>