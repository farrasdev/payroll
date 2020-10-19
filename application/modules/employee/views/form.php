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
              <h3 class="card-title">Form <?= $menu['menu_name'] ?></h3>
            </div>
            <form id="form" action="<?= site_url() . '/' . $menu['controller'] . '/save/' . $id ?>" method="post" autocomplete="off" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <h6><i class="fas fa-user"></i> Data Dasar</h6>
                    <div class="flash-error" data-flasherror="<?= $this->session->flashdata('flash_error') ?>"></div>
                    <?php if ($id != null) : ?>
                      <input type="hidden" class="form-control form-control-sm" name="old" id="old" value="<?= @$main['employee_id'] ?>" required>
                    <?php endif; ?>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Nomor Induk <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" name="employee_id" id="employee_id" value="<?= @$main['employee_id'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Nama Lengkap <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" name="employee_name" id="employee_name" value="<?= @$main['employee_name'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Jenis Kelamin <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select class="form-control form-control-sm select2" name="sex" id="sex">
                          <option value="M" <?= (@$main['sex'] == 'M') ? 'selected' : '' ?>>Laki-laki</option>
                          <option value="F" <?= (@$main['sex'] == 'F') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Tanggal Lahir <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm datepicker" name="dob" id="dob" value="<?= @$main['dob'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Nomor KTP <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="id_number" id="id_number" value="<?= @$main['id_number'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Nomor NPWP</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="tax_number" id="tax_number" value="<?= @$main['tax_number'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Status Keluarga <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select class="form-control form-control-sm select2" name="family_status_id" id="family_status_id">
                          <?php foreach ($family_status as $r) : ?>
                            <option value="<?= $r['family_status_id'] ?>"><?= $r['family_status_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <h6><i class="fas fa-map-marker-alt"></i> Alamat</h6>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Provinsi <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="province_id" id="province_id">
                          <option value="">--</option>
                          <?php foreach ($province as $r) : ?>
                            <option value="<?= $r['area_id'] ?>"><?= $r['area_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Kabupaten <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="regency_id" id="regency_id">
                          <option value="">--</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Kecamatan <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="district_id" id="district_id">
                          <option value="">--</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Kelurahan / Desa <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="village_id" id="village_id">
                          <option value="">--</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <h6><i class="fas fa-suitcase"></i> Kepegawaian</h6>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Departemen <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="department_id" id="department_id">
                          <?php foreach ($department as $r) : ?>
                            <option value="<?= $r['department_id'] ?>" <?= (@$main['department_id'] == $r['department_id']) ? 'selected' : '' ?>><?= $r['department_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Divisi <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="division_id" id="division_id">
                          <?php foreach ($division as $r) : ?>
                            <option value="<?= $r['division_id'] ?>" <?= (@$main['division_id'] == $r['division_id']) ? 'selected' : '' ?>><?= $r['division_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Posisi <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="position_id" id="position_id">
                          <?php foreach ($position as $r) : ?>
                            <option value="<?= $r['position_id'] ?>" <?= (@$main['position_id'] == $r['position_id']) ? 'selected' : '' ?>><?= $r['position_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Status Pegawai <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="employee_status_id" id="employee_status_id">
                          <?php foreach ($employee_status as $r) : ?>
                            <option value="<?= $r['employee_status_id'] ?>" <?= (@$main['employee_status_id'] == $r['employee_status_id']) ? 'selected' : '' ?>><?= $r['employee_status_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Status Upah <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="salary_status_id" id="salary_status_id">
                          <?php foreach ($salary_status as $r) : ?>
                            <option value="<?= $r['salary_status_id'] ?>" <?= (@$main['salary_status_id'] == $r['salary_status_id']) ? 'selected' : '' ?>><?= $r['salary_status_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-2 offset-md-10">
                    <div class="float-right">
                      <button type="submit" class="btn btn-sm btn-primary btn-submit"><i class="fas fa-save"></i> Simpan</button>
                      <a class="btn btn-sm btn-default btn-cancel" href="<?= site_url() . '/' . $menu['controller'] . '/' . $menu['url'] ?>"><i class="fas fa-times"></i> Batal</a>
                    </div>
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
        employee_id: {
          remote: {
            type: 'post',
            url: "<?= site_url() . '/' . $menu['controller'] . '/ajax/check_id/' . $id ?>",
            data: {
              'employee_id': function() {
                return $('#employee_id').val();
              }
            },
            dataType: 'json'
          }
        }
      },
      messages: {
        employee_id: {
          remote: "Kode sudah digunakan"
        }
      },
      errorElement: "em",
      errorPlacement: function(error, element) {
        error.addClass("invalid-feedback");
        if (element.prop("type") === "checkbox") {
          error.insertAfter(element.next("label"));
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



    $("#regency_id").remoteChained({
      parents: "#province_id",
      url: "<?= site_url() . '/' . $menu['controller'] . '/ajax/regency' ?>"
    });

    $("#district_id").remoteChained({
      parents: "#regency_id",
      url: "<?= site_url() . '/' . $menu['controller'] . '/ajax/district' ?>"
    });

    $("#village_id").remoteChained({
      parents: "#district_id",
      url: "<?= site_url() . '/' . $menu['controller'] . '/ajax/village' ?>"
    });

    $("#province_id").val('').trigger('change');
  })
</script>