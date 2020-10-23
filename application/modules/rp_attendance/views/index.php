<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
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
              <h3 class="card-title">Daftar <?= $menu['menu_name'] ?></h3>
            </div>
            <div class="card-body">
              <form action="<?= site_url() . '/app/search/' . $menu['menu_id'] ?>" method="post" autocomplete="off">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal Awal <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input class="form-control form-control-sm datepicker" type="text" name="start_date" value="<?= @$cookie['search']['start_date'] ?>" placeholder="Tanggal Awal">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal Akhir <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input class="form-control form-control-sm datepicker" type="text" name="end_date" value="<?= @$cookie['search']['end_date'] ?>" placeholder="Tanggal Akhir">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-sm btn-primary btn-submit"><i class="fas fa-search"></i> Cari</button>
                    <a class="btn btn-sm btn-default btn-cancel" href="<?= site_url() . '/app/reset/' . $menu['menu_id'] ?>"><i class="fas fa-sync"></i> Reset</a>
                  </div>
                </div>
              </form>
              <hr>
              <?php if ($error != '') : ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my
                  entire
                  soul, like these sweet mornings of spring which I enjoy with my whole heart.
                </div>
              <?php endif; ?>
              <?php if ($main != null) : ?>
                <div class="row mb-2 mt-2">
                  <div class="col-md-6">
                    <div class="input-group-prepend">
                      <span class="mr-1 pt-1">Tampilkan </span>
                      <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?= @$cookie['per_page'] ?>
                      </button>
                      <span class="ml-1 pt-1">data.</span>
                      <div class="dropdown-menu">
                        <a class="dropdown-item <?= (@$cookie['per_page'] == 10) ? 'active' : '' ?>" href="<?= site_url() . '/app/per_page/' . $menu['menu_id'] . '/10' ?>">10</a>
                        <a class="dropdown-item <?= (@$cookie['per_page'] == 25) ? 'active' : '' ?>" href="<?= site_url() . '/app/per_page/' . $menu['menu_id'] . '/25' ?>">25</a>
                        <a class="dropdown-item <?= (@$cookie['per_page'] == 50) ? 'active' : '' ?>" href="<?= site_url() . '/app/per_page/' . $menu['menu_id'] . '/50' ?>">50</a>
                        <a class="dropdown-item <?= (@$cookie['per_page'] == 100) ? 'active' : '' ?>" href="<?= site_url() . '/app/per_page/' . $menu['menu_id'] . '/100' ?>">100</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 text-right">
                    <span class="pt-1"><?= @$pagination_info ?></span>
                  </div>
                </div><!-- /.row -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="flash-success" data-flashsuccess="<?= $this->session->flashdata('flash_success') ?>"></div>
                    <div class="table-responsive">
                      <table class="table table-bordered table-sm table-striped table-head-fixed">
                        <thead>
                          <tr>
                            <th class="text-center" width="40">No</th>
                            <th class="text-center" width="100">Nama Pegawai</th>
                            <th class="text-center" width="100">Jabatan</th>
                            <th class="text-center" width="100">Status</th>
                          </tr>
                        </thead>
                        <?php if (@$main == null) : ?>
                          <tbody>
                            <tr>
                              <td class="text-center" colspan="99"><i>Tidak ada data!</i></td>
                            </tr>
                          </tbody>
                        <?php else : ?>
                          <tbody>
                            <form id="form-multiple" action="" method="post">
                              <?php $i = 1;
                              foreach ($main as $r) : ?>
                                <tr>
                                  <td class="text-center"><?= $cookie['cur_page'] + ($i++) ?></td>
                                  <td class="text-left"><?= $r['employee_name'] ?></td>
                                  <td class="text-left"><?= $r['position_name'] ?></td>
                                  <td class="text-left"><?= $r['employee_status_name'] ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </form>
                          </tbody>
                        <?php endif; ?>
                      </table>
                    </div>
                  </div>
                </div><!-- /.row -->
              <?php endif; ?>
            </div>
            <div class="card-footer">
              <?php if ($main != null) : ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group-prepend">
                      <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Aksi
                      </button>
                      <div class="dropdown-menu">
                        <?php if ($menu['_update'] == 1) : ?>
                          <a class="dropdown-item" href="javascript:multipleAction('enable')">Aktif</a>
                          <a class="dropdown-item" href="javascript:multipleAction('disable')">Non Aktif</a>
                        <?php endif; ?>
                        <?php if ($menu['_delete'] == 1) : ?>
                          <a class="dropdown-item" href="javascript:multipleAction('delete')">Hapus</a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 float-right">
                    <?php echo $this->pagination->create_links(); ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->