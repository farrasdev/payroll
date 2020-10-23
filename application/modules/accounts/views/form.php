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
            <li class="breadcrumb-item active">Konsultasi</li>
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
              <h3 class="card-title">Form <?= $menu['menu_name'] ?></h3>
            </div>
            <form id="form" action="<?= site_url() . '/' . $menu['controller'] . '/save/' . $id ?>" method="post" autocomplete="off" enctype="multipart/form-data">
              <div class="card-body">
                <div class="flash-error" data-flasherror="<?= $this->session->flashdata('flash_error') ?>"></div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Kode Akun <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" name="account_id" id="account_id" value="<?= @$main['account_id'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Induk <span class="text-danger">*</span></label>
                  <div class="col-sm-4">
                    <select class="form-control form-control-sm select2" name="parent_id" id="parent_id">
                      <option value="">---</option>
                      <?php foreach ($all as $r) : ?>
                        <option value="<?= $r['account_id'] ?>" <?= (@$main['parent_id'] == $r['account_id']) ? 'selected' : '' ?>><?= $r['account_id'] ?> - <?= $r['account_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <?php if ($id != null) : ?>
                  <input type="hidden" class="form-control form-control-sm" name="old" id="old" value="<?= @$main['account_id'] ?>" required>
                <?php endif; ?>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Nama Akun <span class="text-danger">*</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" name="account_name" id="account_name" value="<?= @$main['account_name'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Tipe Akun <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <select class="form-control form-control-sm select2" name="account_type" id="account_type">
                      <option value="G" <?= (@$main['account_type'] == 'G') ? 'selected' : '' ?>>Grup</option>
                      <option value="D" <?= (@$main['account_type'] == 'D') ? 'selected' : '' ?>>Detail</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Tipe Akun <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <select class="form-control form-control-sm select2" name="balance_type" id="balance_type">
                      <option value="D" <?= (@$main['balance_type'] == 'D') ? 'selected' : '' ?>>Debit</option>
                      <option value="C" <?= (@$main['balance_type'] == 'C') ? 'selected' : '' ?>>Kredit</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Tipe Laporan <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <select class="form-control form-control-sm select2" name="report_type" id="report_type">
                      <option value="PL" <?= (@$main['report_type'] == 'PL') ? 'selected' : '' ?>>Laba Rugi</option>
                      <option value="BS" <?= (@$main['report_type'] == 'BS') ? 'selected' : '' ?>>Neraca</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Tipe Sub Laporan <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <select class="form-control form-control-sm select2" name="sub_report_type" id="sub_report_type">
                      <option value="INC" <?= (@$main['report_type'] == 'INC') ? 'selected' : '' ?>>Pendapatan</option>
                      <option value="SPN" <?= (@$main['report_type'] == 'SPN') ? 'selected' : '' ?>>Pengeluaran</option>
                      <option value="ACT" <?= (@$main['report_type'] == 'ACT') ? 'selected' : '' ?>>Aktiva</option>
                      <option value="PSV" <?= (@$main['report_type'] == 'PSV') ? 'selected' : '' ?>>Pasiva</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="url" class="col-sm-2 col-form-label text-right">Aktif</label>
                  <div class="col-sm-3">
                    <div class="pretty p-icon">
                      <input class="icheckbox" type="checkbox" name="is_active" id="is_active" value="1" <?= (@$main['is_active'] == 1) ? 'checked' : '' ?>>
                      <div class="state">
                        <i class="icon fas fa-check"></i><label></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-sm btn-primary btn-submit"><i class="fas fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-default btn-cancel" href="<?= site_url() . '/' . $menu['controller'] . '/' . $menu['url'] ?>"><i class="fas fa-times"></i> Batal</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $("#form").validate({
      rules: {

      },
      messages: {

      },
      errorElement: "em",
      errorPlacement: function(error, element) {
        error.addClass("invalid-feedback");
        if (element.prop("type") === "checkbox") {
          error.insertAfter(element.next("label"));
        } else if ($(element).hasClass('select2')) {
          error.insertAfter(element.next(".select2-container")).addClass('mt-1');
        } else {
          error.insertAfter(element);
        }
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).addClass("is-valid").removeClass("is-invalid");
      },
      submitHandler: function(form) {
        $(".btn-submit").html('<i class="fas fa-spin fa-spinner"></i> Proses');
        $(".btn-submit").addClass('disabled');
        $(".btn-cancel").addClass('disabled');
        form.submit();
      }
    });
  })
</script>