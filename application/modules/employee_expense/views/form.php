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
            <li class="breadcrumb-item active">Pengupahan</li>
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
                <input type="hidden" class="form-control form-control-sm" name="employee_expense_id" id="employee_expense_id" value="<?= @$main['employee_expense_id'] ?>" required>
                <?php if ($id != null) : ?>
                  <input type="hidden" class="form-control form-control-sm" name="old" id="old" value="<?= @$main['employee_expense_id'] ?>" required>
                <?php endif; ?>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Nama Pegawai <span class="text-danger">*</span></label>
                  <div class="col-sm-4">
                    <select class="form-control form-control-sm select2" name="employee_id" id="employee_id" required>
                      <option value="">-- Pilih --</option>
                      <?php foreach ($employee as $r) : ?>
                        <option value="<?= $r['employee_id'] ?>" <?= (@$main['employee_id'] == $r['employee_id']) ? 'selected' : '' ?>><?= $r['employee_id'] . ' - ' . $r['employee_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="icon" class="col-sm-2 col-form-label text-right">Tanggal <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm datepicker" name="employee_expense_date" id="employee_expense_date" value="<?= @reverse_date($main['employee_expense_date']) ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="icon" class="col-sm-2 col-form-label text-right">Nominal <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="nominal" id="nominal" value="<?= @($main['nominal']) ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="icon" class="col-sm-2 col-form-label text-right">Keterangan</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-sm" name="description" id="description" value="<?= @$main['description'] ?>">
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
        employee_expense_id: {
          remote: {
            type: 'post',
            url: "<?= site_url() . '/' . $menu['controller'] . '/ajax/check_id/' . $id ?>",
            data: {
              'employee_expense_id': function() {
                return $('#employee_expense_id').val();
              }
            },
            dataType: 'json'
          }
        }
      },
      messages: {
        employee_expense_id: {
          remote: "Kode sudah digunakan"
        }
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