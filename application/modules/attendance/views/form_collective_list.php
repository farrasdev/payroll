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
              <h3 class="card-title">Form <?= $menu['menu_name'] ?></h3>
            </div>
            <form id="form" action="<?= site_url() . '/' . $menu['controller'] . '/form_collective_action' ?>" method="post" autocomplete="off" enctype="multipart/form-data">
              <div class="card-body">
                <div class="flash-error" data-flasherror="<?= $this->session->flashdata('flash_error') ?>"></div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal Mulai<span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" name="start_date" id="start_date" value="<?= @$start_date ?>" required readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Tanggal Akhir<span class="text-danger">*</span></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm " name="end_date" id="end_date" value="<?= @$end_date ?>" required readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right">Nama Pegawai <span class="text-danger">*</span></label>
                  <div class="col-sm-5">
                    <input type="hidden" name="employee_id" value="<?= $employee['employee_id'] ?>">
                    <input type="text" class="form-control form-control-sm" name="employee_name" id="employee_name" value="<?= $employee['employee_id'] . ' - ' . $employee['employee_name'] ?>" required readonly>
                  </div>
                </div>
                <hr>
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                    <tr>
                      <th class="text-center" width="20">No</th>
                      <th class="text-center" width="150">Tanggal</th>
                      <th class="text-center">Shift</th>
                      <th class="text-center" width="100">Regular</th>
                      <th class="text-center" width="100">Hourmachine</th>
                      <th class="text-center" width="100">Overtime 1,5</th>
                      <th class="text-center" width="100">Overtime 2</th>
                      <th class="text-center" width="100">Overtime 3</th>
                      <th class="text-center" width="100">Overtime 4</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($attendance as $k => $v) : ?>
                      <tr>
                        <td class="text-center text-middle">
                          <input type="hidden" id="attendance_id_<?= $k ?>" name="attendance_id[]" value="<?= $v['attendance_id'] ?>">
                          <?= $k + 1 ?>
                        </td>
                        <td class="text-center text-middle">
                          <input type="hidden" id="attendance_date_<?= $k ?>" name="attendance_date_<?= $k ?>" value="<?= $v['attendance_date'] ?>">
                          <?= date_id($v['attendance_date']) ?>
                        </td>
                        <td>
                          <select class="form-control form-control-sm select2 mb-0 pb-0" id="shift_id_<?= $k ?>" onchange="get_shift(this, '<?= $k ?>')" name="shift_id_<?= $k ?>" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($shift as $r) : ?>
                              <option value="<?= $r['shift_id'] ?>" <?= (@$v['shift_id'] == $r['shift_id']) ? 'selected' : '' ?>><?= $r['shift_id'] . ' - ' . $r['shift_name'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                        <td>
                          <input class="form-control form-control-sm num-int text-center" id="regulartime_<?= $k ?>" type="text" name="regulartime_<?= $k ?>" value="<?= $v['regulartime'] ?>" required>
                        </td>
                        <td>
                          <input class="form-control form-control-sm num-int text-center" id="hourmachine_<?= $k ?>" type="text" name="hourmachine_<?= $k ?>" value="<?= $v['hourmachine'] ?>" required>
                        </td>
                        <td>
                          <input class="form-control form-control-sm num-int text-center" id="overtime_15_<?= $k ?>" type="text" name="overtime_15_<?= $k ?>" value="<?= $v['overtime_15'] ?>" required>
                        </td>
                        <td>
                          <input class="form-control form-control-sm num-int text-center" id="overtime_2_<?= $k ?>" type="text" name="overtime_2_<?= $k ?>" value="<?= $v['overtime_2'] ?>" required>
                        </td>
                        <td>
                          <input class="form-control form-control-sm num-int text-center" id="overtime_3_<?= $k ?>" type="text" name="overtime_3_<?= $k ?>" value="<?= $v['overtime_3'] ?>" required>
                        </td>
                        <td>
                          <input class="form-control form-control-sm num-int text-center" id="overtime_4_<?= $k ?>" type="text" name="overtime_4_<?= $k ?>" value="<?= $v['overtime_4'] ?>" required>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
        form.submit();
      }
    });
  })

  function get_shift(obj, index) {
    var shift_id = $(obj).val();
    $.ajax({
      type: 'post',
      url: '<?= site_url() . '/' . $menu['controller'] . '/ajax/get_shift' ?>',
      data: 'shift_id=' + shift_id,
      dataType: 'json',
      success: function(data) {
        $("#regulartime_" + index).val(data.regulartime);
        $("#overtime_15_" + index).val(data.overtime_15);
        $("#overtime_2_" + index).val(data.overtime_2);
        $("#overtime_3_" + index).val(data.overtime_3);
        $("#overtime_4_" + index).val(data.overtime_4);
      }
    });
  }
</script>