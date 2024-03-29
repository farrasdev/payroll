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
                <input type="hidden" class="form-control form-control-sm" name="attendance_id" id="attendance_id" value="<?= @$main['attendance_id'] ?>" required>
                <?php if ($id != null) : ?>
                  <input type="hidden" class="form-control form-control-sm" name="old" id="old" value="<?= @$main['attendance_id'] ?>" required>
                <?php endif; ?>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm datepicker" name="attendance_date" id="attendance_date" value="<?= @reverse_date($main['attendance_date']) ?>" required>
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
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Shift <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <select class="form-control form-control-sm select2" name="shift_id" id="shift_id" onchange="get_shift(this)" required>
                      <option value="">-- Pilih --</option>
                      <?php foreach ($shift as $r) : ?>
                        <option value="<?= $r['shift_id'] ?>" <?= (@$main['shift_id'] == $r['shift_id']) ? 'selected' : '' ?>><?= $r['shift_id'] . ' - ' . $r['shift_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Regular Time <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="regulartime" id="regulartime" value="<?= @$main['regulartime'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Hour Machine <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="hourmachine" id="hourmachine" value="<?= @$main['hourmachine'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Overtime 1,5 <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="overtime_15" id="overtime_15" value="<?= @$main['overtime_15'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Overtime 2 <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="overtime_2" id="overtime_2" value="<?= @$main['overtime_2'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Overtime 3 <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="overtime_3" id="overtime_3" value="<?= @$main['overtime_3'] ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Overtime 4 <span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm num-int" name="overtime_4" id="overtime_4" value="<?= @$main['overtime_4'] ?>" required>
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