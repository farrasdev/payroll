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
                    <h6><i class="fas fa-copy"></i> Surat Perjanjian</h6>
                    <?php if ($id != null) : ?>
                      <input type="hidden" class="form-control form-control-sm" name="old" id="old" value="<?= @$main['agreement_number'] ?>" required>
                    <?php endif; ?>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Nomor Perjanjian <span class="text-danger">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="agreement_number" id="agreement_number" value="<?= @$main['agreement_number'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Tanggal Surat <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm datepicker" name="agreement_date" id="agreement_date" value="<?= reverse_date(@$main['agreement_date']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Sejak Tanggal <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm datepicker" name="start_date" id="start_date" value="<?= reverse_date(@$main['start_date']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Sampai Tanggal <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm datepicker" name="end_date" id="end_date" value="<?= reverse_date(@$main['end_date']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Periode (Selama) <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" name="period" id="period" value="<?= (@$main['period']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">TTD HRD <span class="text-danger">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm " name="signature_name" id="signature_name" value="<?= (@$main['signature_name']) ?>" required>
                      </div>
                    </div>
                    <h6><i class="fas fa-user mt-3"></i> Data Pegawai</h6>
                    <div class="flash-error" data-flasherror="<?= $this->session->flashdata('flash_error') ?>"></div>

                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Nama Lengkap <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" name="employee_name" id="employee_name" value="<?= @$main['employee_name'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">TTL <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" name="pob" id="pob" value="<?= (@$main['pob']) ?>" required>
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm datepicker" name="dob" id="dob" value="<?= reverse_date(@$main['dob']) ?>" required>
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
                            <option value="<?= $r['family_status_id'] ?>" <?= (@$main['family_status_id'] == $r['family_status_id']) ? 'selected' : '' ?>><?= $r['family_status_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <h6><i class="fas fa-map-marker-alt mt-3"></i> Alamat</h6>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Provinsi <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="province_name" id="province_name" value="<?= @$main['province_name'] ?>" required>
                        <!-- <select class="form-control form-control-sm select2" name="province_id" id="province_id">
                          <option value="">--</option>
                          <?php foreach ($province as $r) : ?>
                            <option value="<?= $r['area_id'] ?>"><?= $r['area_name'] ?></option>
                          <?php endforeach; ?>
                        </select> -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Kabupaten <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="regency_name" id="regency_name" value="<?= @$main['regency_name'] ?>" required>
                        <!-- <select class="form-control form-control-sm select2" name="regency_id" id="regency_id">
                          <option value="">--</option>
                        </select> -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Kecamatan <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="district_name" id="district_name" value="<?= @$main['district_name'] ?>" required>
                        <!-- <select class="form-control form-control-sm select2" name="district_id" id="district_id">
                          <option value="">--</option>
                        </select> -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-3 col-form-label text-right">Kelurahan / Desa <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="village_name" id="village_name" value="<?= @$main['village_name'] ?>" required>
                        <!-- <select class="form-control form-control-sm select2" name="village_id" id="village_id">
                          <option value="">--</option>
                        </select> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <h6><i class="fas fa-suitcase"></i> Kepegawaian</h6>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Status Penerimaan <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm " name="reqruitment_status" id="reqruitment_status" value="<?= (@$main['reqruitment_status']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Departemen <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="department_id" id="department_id" required>
                          <option value="">--</option>
                          <?php foreach ($department as $r) : ?>
                            <option value="<?= $r['department_id'] ?>" <?= (@$main['department_id'] == $r['department_id']) ? 'selected' : '' ?>><?= $r['department_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Divisi <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="division_id" id="division_id" required>
                          <option value="">--</option>
                          <?php foreach ($division as $r) : ?>
                            <option value="<?= $r['division_id'] ?>" <?= (@$main['division_id'] == $r['division_id']) ? 'selected' : '' ?>><?= $r['division_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Posisi <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <select class="form-control form-control-sm select2" name="position_id" id="position_id" required>
                          <option value="">--</option>
                          <?php foreach ($position as $r) : ?>
                            <option value="<?= $r['position_id'] ?>" <?= (@$main['position_id'] == $r['position_id']) ? 'selected' : '' ?>><?= $r['position_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Mulai Bekerja <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm datepicker" name="entry_date" id="entry_date" value="<?= reverse_date(@$main['entry_date']) ?>" required>
                      </div>
                    </div>
                    <h6><i class="fas fa-money-bill-wave mt-3"></i> Pengupahan</h6>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Upah Pokok <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm num-int" name="salary" id="salary" value="<?= (@$main['salary']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Uang Makan <span class="text-danger">*</span></label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm num-int" name="meal_allowance" id="meal_allowance" value="<?= (@$main['meal_allowance']) ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Overtime</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="overtime_status" id="overtime_status" value="<?= (@$main['overtime_status']) ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">Nama Bank</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" name="bank_name" id="bank_name" value="<?= @$main['bank_name'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="menu" class="col-sm-4 col-form-label text-right">No Rekening Bank</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm" name="bank_account" id="bank_account" value="<?= @$main['bank_account'] ?>">
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
    var form = $("#form").validate({
      rules: {
        agreement_number: {
          remote: {
            type: 'post',
            url: "<?= site_url() . '/' . $menu['controller'] . '/ajax/check_id/' . $id ?>",
            data: {
              'agreement_number': function() {
                return $('#agreement_number').val();
              }
            },
            dataType: 'json'
          }
        }
      },
      messages: {
        agreement_number: {
          remote: "Nomor sudah digunakan"
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

    <?php if ($id != null) : ?>
      setTimeout(function() {
        $("#province_id").val('<?= @$main['province_id'] ?>').trigger('change');
        setTimeout(function() {
          $("#regency_id").val('<?= @$main['regency_id'] ?>').trigger('change');
          setTimeout(function() {
            $("#district_id").val('<?= @$main['district_id'] ?>').trigger('change');
            setTimeout(function() {
              $("#village_id").val('<?= @$main['village_id'] ?>').trigger('change');
            }, 500);
          }, 500);
        }, 500);
      }, 500);

    <?php endif; ?>

    $("#province_id").val('').trigger('change');

    $(".select2").on('change', function() {
      form.element($(this));
    })
  })
</script>