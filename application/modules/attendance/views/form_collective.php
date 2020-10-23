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
            <li class="breadcrumb-item active">Kolektif</li>
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
              <h3 class="card-title">Form Kehadiran Kolektif Pegawai</h3>
            </div>
            <form id="form" action="<?= site_url() . '/' . $menu['controller'] . '/form_collective_list/' ?>" method="post" autocomplete="off" enctype="multipart/form-data">
              <div class="card-body">
                <div class="flash-error" data-flasherror="<?= $this->session->flashdata('flash_error') ?>"></div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal Awal<span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm datepicker" name="start_date" id="start_date" value="" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal Akhir<span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm datepicker" name="end_date" id="end_date" value="" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Nama Pegawai <span class="text-danger">*</span></label>
                  <div class="col-sm-5">
                    <select class="form-control form-control-sm select2" name="employee_id" id="employee_id" required>
                      <option value="">-- Pilih --</option>
                      <?php foreach ($employee as $r) : ?>
                        <option value="<?= $r['employee_id'] ?>" <?= (@$main['employee_id'] == $r['employee_id']) ? 'selected' : '' ?>><?= $r['employee_id'] . ' - ' . $r['employee_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
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
        var a = moment($("#start_date").val(), 'D-M-YYYY');
        var b = moment($("#end_date").val(), 'D-M-YYYY');
        var diffDays = b.diff(a, 'days') + 1;
        if (diffDays < 0) {
          toastr.error("Tanggal awal tidak boleh lebih baru dari tanggal akhir");
        } else if (diffDays > 31) {
          toastr.error("Tanggal tidak boleh lebih dari 31 hari!");
        } else {
          form.submit();
        }
      }
    });
  })

  function get_shift(obj) {
    var shift_id = $(obj).val();
    $.ajax({
      type: 'post',
      url: '<?= site_url() . '/' . $menu['controller'] . '/ajax/get_shift' ?>',
      data: 'shift_id=' + shift_id,
      dataType: 'json',
      success: function(data) {
        $("#regulartime").val(data.regulartime);
        $("#overtime_15").val(data.overtime_15);
        $("#overtime_2").val(data.overtime_2);
        $("#overtime_3").val(data.overtime_3);
        $("#overtime_4").val(data.overtime_4);
      }
    });
  }
</script>