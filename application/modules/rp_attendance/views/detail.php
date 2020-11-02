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
            <li class="breadcrumb-item active">Kehadiran</li>
            <li class="breadcrumb-item active"><?= @$menu['menu_name'] ?></li>
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
                  <a class="dropdown-item" target="_blank" href="<?= site_url() . '/' . $menu['controller'] . '/pdf/' . $start_date . '/' . $end_date ?>"><i class="far fa-file-pdf"></i> Berkas PDF</a>
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
                          <td><?= date_id(reverse_date($start_date)) ?></td>
                        </tr>
                        <tr>
                          <td>Tanggal Akhir</td>
                          <td class="text-center" width="30">:</td>
                          <td><?= date_id(reverse_date($end_date)) ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-3 offset-md-3">
                  <form action="<?= site_url() . '/' . $this->menu['controller'] . '/search_detail/' . $start_date . '/' . $end_date  ?>" method="post" autocomplete="off">
                    <div class="input-group input-group-sm">
                      <input class="form-control" type="text" name="search" value="<?= @$search ?>" placeholder="Pencarian">
                      <span class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        <a class="btn btn-default" href="<?= site_url() . '/' . $this->menu['controller'] . '/reset_detail/' . $start_date . '/' . $end_date  ?>"><i class="fas fa-sync-alt"></i></a>
                      </span>
                    </div>
                  </form>
                </div>
              </div><!-- /.row -->
              <div class="table-responsive mt-3">
                <table class="table table-head-fixed text-nowrap table-striped table-bordered table-sm" style="font-size:12px; width:1500px">
                  <thead>
                    <tr>
                      <th class="text-center text-middle" rowspan="2" width="30">No</th>
                      <th class="text-center text-middle" rowspan="2" width="70">NIK</th>
                      <th class="text-center text-middle" rowspan="2" width="">Nama Pegawai</th>
                      <?php foreach ($date as $k => $v) : ?>
                        <th class="text-center" width="35"><?= date("D", strtotime($v)) ?></th>
                      <?php endforeach; ?>
                    </tr>
                    <tr>
                      <?php foreach ($date as $k => $v) : ?>
                        <th class="text-center"><?= date("d", strtotime($v)) ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($main as $r) : ?>
                      <tr>
                        <td class="text-middle text-center"><?= $i++ ?></td>
                        <td class="text-middle text-center"><?= $r['employee_id'] ?></td>
                        <td class="text-middle"><?= $r['employee_name'] ?></td>
                        <?php foreach ($r['attendance'] as $k => $v) : ?>
                          <td class="text-center"><?= $v ?></td>
                        <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>
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