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
            <li class="breadcrumb-item active">Master Data</li>
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
              <div class="alert alert-info alert-dismissible">
                <h6><i class="icon fas fa-info"></i> Informasi!</h6>
                Fitur ini adalah fitur untuk melihat data iuran BPJS Tenaga Kerja. Data ini muncul atas pembuatan data pengupahan terlebih dulu.
              </div>
              <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-3 offset-md-3">
                  <!-- <form action="<?= site_url() . '/app/search/' . $menu['menu_id'] ?>" method="post" autocomplete="off">
                    <div class="input-group input-group-sm">
                      <input class="form-control" type="text" name="term" value="<?= @$cookie['search']['term'] ?>" placeholder="Pencarian">
                      <span class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        <a class="btn btn-default" href="<?= site_url() . '/app/reset/' . $menu['menu_id'] ?>"><i class="fas fa-sync-alt"></i></a>
                      </span>
                    </div>
                  </form> -->
                </div>
              </div><!-- /.row -->
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
                          <th class="text-center" width="40">No.</th>
                          <th class="text-center" width="10">
                            <div class="pretty p-icon">
                              <input class="checkall" type="checkbox" name="checkall" onclick="checkAll(this);" />
                              <div class="state">
                                <i class="icon fas fa-check"></i><label></label>
                              </div>
                            </div>
                          </th>
                          <th class="text-center" width="50">Aksi</th>
                          <th class="text-center" width="150"><?= table_sort($menu['menu_id'], 'Tanggal Awal', 'start_date', $cookie['order']) ?></th>
                          <th class="text-center" width="150"><?= table_sort($menu['menu_id'], 'Tanggal Akhir', 'end_date', $cookie['order']) ?></th>
                          <th class="text-center" width="250">Dibuat pada</th>
                          <th class="text-center" width="">Dibuat oleh</th>
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
                                <td class="text-center">
                                  <div class="pretty p-icon">
                                    <input class="checkitem" type="checkbox" value="<?= $r['payroll_id'] ?>" name="checkitem[]" onclick="checkItem();" />
                                    <div class="state">
                                      <i class="icon fas fa-check"></i><label></label>
                                    </div>
                                  </div>
                                </td>
                                <td class="text-center">
                                  <?php if ($menu['_update'] == 1) : ?>
                                    <a class="text-success mr-1" href="<?= site_url() . '/' . $menu['controller'] . '/detail/' . $r['payroll_id'] ?>"><i class="fas fa-list"></i></a>
                                  <?php endif; ?>
                                </td>
                                <td class="text-center"><?= date_id($r['start_date']) ?></td>
                                <td class="text-center"><?= date_id($r['end_date']) ?></td>
                                <td class="text-center"><?= reverse_date($r['created_at'], '-', 'full_date', ' ') ?></td>
                                <td><?= $r['created_by'] ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </form>
                        </tbody>
                      <?php endif; ?>
                    </table>
                  </div>
                </div>
              </div><!-- /.row -->
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      Aksi
                    </button>
                    <div class="dropdown-menu">
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
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->