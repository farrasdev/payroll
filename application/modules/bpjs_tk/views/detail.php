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
                      <th class="text-center text-middle" width="70" rowspan="2">NIK</th>
                      <th class="text-center text-middle" width="70" rowspan="2">No KTP</th>
                      <th class="text-center text-middle" width="" rowspan="2">Nama Pegawai</th>
                      <th class="text-center text-middle" width="20" rowspan="2">JK</th>
                      <th class="text-center text-middle" width="30" rowspan="2">Dept</th>
                      <th class="text-center text-middle" width="120" rowspan="2">Divisi</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Posisi</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Tanggal Lahir</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Umur</th>
                      <th class="text-center text-middle" width="80" rowspan="2">Status Pegawai</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Salary</th>
                      <th class="text-center text-middle" width="150" colspan="2">BPJS Ketenagakerjaan (Karyawan)</th>
                      <th class="text-center text-middle" width="150" colspan="4">BPJS Ketenagakerjaan (Perusahaan)</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Iuran</th>
                    </tr>
                    <tr>
                      <th class="text-center text-middle">JHT (2%)</th>
                      <th class="text-center text-middle">JP (1%)</th>
                      <th class="text-center text-middle">JHT (3.7%)</th>
                      <th class="text-center text-middle">JP (2%)</th>
                      <th class="text-center text-middle">JKK (1.74%)</th>
                      <th class="text-center text-middle">JKM (0.3%)</th>
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
                          <td class="text-middle text-center"><?= $r['employee_id'] ?></td>
                          <td class="text-middle text-center"><?= $r['id_number'] ?></td>
                          <td class="text-middle"><?= $r['employee_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['sex'] ?></td>
                          <td class="text-middle text-center"><?= $r['department_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['division_name'] ?></td>
                          <td class="text-middle text-center"><?= $r['position_name'] ?></td>
                          <td class="text-middle text-center"><?= reverse_date($r['dob']) ?></td>
                          <td class="text-middle text-center"><?= date_difference($r['dob'], date('Y-m-d'), '%y') ?> Tahun</td>
                          <td class="text-middle text-center"><?= $r['employee_status_name'] ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_salary']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jht_employee']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jp_employee']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jht_company']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jp_company']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jkk_company']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_tk_jkm_company']) ?></td>
                          <td class="text-middle text-center"><?= num_id($r['bpjs_ks_premi']) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
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