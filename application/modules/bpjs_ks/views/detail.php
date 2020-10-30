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
              <div class="table-responsive" style="height:50vh">
                <table class="table table-head-fixed text-nowrap table-striped table-bordered table-sm" style="font-size:12px;">
                  <thead>
                    <tr>
                      <th class="text-center text-middle" width="30" rowspan="2">No</th>
                      <th class="text-center text-middle" width="70" rowspan="2">NIK</th>
                      <th class="text-center text-middle" width="" rowspan="2">Nama Pegawai</th>
                      <th class="text-center text-middle" width="30" rowspan="2">Dept</th>
                      <th class="text-center text-middle" width="120" rowspan="2">Divisi</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Posisi</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Salary</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Pegawai (1%)</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Perusahaan (4%)</th>
                      <th class="text-center text-middle" width="150" rowspan="2">Total Iuran</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($main['detail'] as $r) : ?>
                      <tr>
                        <td class="text-middle text-center"><?= $i++ ?></td>
                        <td class="text-middle text-center"><?= $r['employee_id'] ?></td>
                        <td class="text-middle"><?= $r['employee_name'] ?></td>
                        <td class="text-middle text-center"><?= $r['department_name'] ?></td>
                        <td class="text-middle text-center"><?= $r['division_name'] ?></td>
                        <td class="text-middle text-center"><?= $r['position_name'] ?></td>
                        <td class="text-middle text-center"><?= num_id($r['bpjs_ks_salary']) ?></td>
                        <td class="text-middle text-center"><?= num_id($r['bpjs_ks_employee']) ?></td>
                        <td class="text-middle text-center"><?= num_id($r['bpjs_ks_company']) ?></td>
                        <td class="text-middle text-center"><?= num_id($r['bpjs_ks_premi']) ?></td>
                      </tr>
                    <?php endforeach; ?>
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