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
            <form id="form" action="<?= site_url() . '/' . $menu['controller'] . '/action/' ?>" method="post" autocomplete="off">
              <div class="card-body">
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Periode Upah <span class="text-danger">*</span></label>
                  <div class="col-sm-4">
                    <select class="form-control form-control-sm select2" name="payroll_id" id="payroll_id" required>
                      <option value="">-- Pilih --</option>
                      <?php foreach ($payroll as $r) : ?>
                        <option value="<?= $r['payroll_id'] ?>"><?= date_id($r['start_date']) . ' - ' . date_id($r['end_date']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="menu" class="col-sm-2 col-form-label text-right">Nama Pegawai <span class="text-danger">*</span></label>
                  <div class="col-sm-4">
                    <select class="form-control form-control-sm select2" name="employee_id" id="employee_id" required>
                      <option value="">-- Pilih --</option>
                      <?php foreach ($employee as $r) : ?>
                        <option value="<?= $r['employee_id'] ?>"><?= $r['employee_id'] . ' - ' . $r['employee_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-10 offset-md-2">
                    <button type="submit" class="btn btn-sm btn-primary btn-submit"><i class="fas fa-cogs"></i> Proses</button>
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