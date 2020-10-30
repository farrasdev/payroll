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
            <div class="card-body">
              <h4 class="text-center">SLIP PEMBAYARAN GAJI BULAN
                <?= strtoupper(month_id(intval(date("m", strtotime($payroll['end_date']))))) . ' ' . date("Y", strtotime($payroll['end_date'])) ?>
              </h4>
              <div class="row mt-4">
                <div class="col-5">
                  <table class="table table-striped table-sm">
                    <tbody>
                      <tr>
                        <td width="150">NAMA</td>
                        <td width="10">:</td>
                        <td><?= $detail['employee_name'] ?></td>
                      </tr>
                      <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?= $detail['employee_id'] ?></td>
                      </tr>
                      <tr>
                        <td>DIVISI</td>
                        <td>:</td>
                        <td><?= $detail['division_name'] ?></td>
                      </tr>
                      <tr>
                        <td>JABATAN</td>
                        <td>:</td>
                        <td><?= $detail['position_name'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-2"></div>
                <div class="col-5">
                  <table class="table table-striped table-sm">
                    <tbody>
                      <tr>
                        <td width="150">TGL. MASUK</td>
                        <td width="10">:</td>
                        <td><?= date_id($detail['entry_date']) ?></td>
                      </tr>
                      <tr>
                        <td>STATUS KARYAWAN</td>
                        <td>:</td>
                        <td><?= $detail['employee_status_name'] ?></td>
                      </tr>
                      <tr>
                        <td>STATUS PERKAWINAN</td>
                        <td>:</td>
                        <td><?= $detail['family_status_name'] ?></td>
                      </tr>
                      <tr>
                        <td>NOMOR REKENING</td>
                        <td>:</td>
                        <td><?= $detail['bank_account'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-4">
                  <table class="">
                    <tbody>
                      <tr>
                        <td width="20"><b>A</b></td>
                        <td width="200">1. Jumlah Hari Kerja</td>
                        <td class="text-center" width="20">:</td>
                        <td><?= $detail['work_days_total'] ?></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>2. Gaji Pokok</td>
                        <td class="text-center">:</td>
                        <td><?= num_id($detail['contract_salary']) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-4">
                  <table class="">
                    <tbody>
                      <tr>
                        <td width="200">3. Jumlah jam lembur</td>
                        <td class="text-center" width="20">:</td>
                        <td><?= $detail['overtime_total'] ?></td>
                      </tr>
                      <tr>
                        <td>4. Upah Overtime / Jam</td>
                        <td class="text-center">:</td>
                        <td><?= num_id($detail['overtime_salary']) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-4">
                  <table class="">
                    <tbody>
                      <tr>
                        <td width="200">5. Jumlah HM</td>
                        <td class="text-center" width="20">:</td>
                        <td><?= $detail['hourmachine_total'] ?></td>
                      </tr>
                      <tr>
                        <td>6. Upah HM / Jam</td>
                        <td class="text-center">:</td>
                        <td><?= num_id($detail['hourmachine_salary']) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="text-bold mt-3">B. PERINCIAN PEMBAYARAN GAJI KARYAWAN</div>
              <div class="row">
                <div class="col-6">
                  <div class="text-bold">I. PENDAPATAN</div>
                  <table style="width:100%">
                    <tbody>
                      <tr>
                        <td>- Gaji Orientasi (THL)</td>
                        <td width="10">:</td>
                        <td class="text-right" width="120"><?= num_id($detail['salary_parttime_sub']) ?></td>
                        <td width="120"></td>
                      </tr>
                      <tr>
                        <td>- Gaji PKWT / PKWTT</td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['salary_contract_sub']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Tunjangan Jabatan</td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['position_all']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Tunjangan Koefisien</td>
                        <td>:</td>
                        <td class="text-right" style="border-bottom:1px solid black"><?= num_id($detail['coeficient_all']) ?></td>
                        <td></td>
                      </tr>
                      <?php $total_a = $detail['salary_parttime_sub'] + $detail['salary_contract_sub'] + $detail['position_all'] + $detail['coeficient_all'] ?>
                      <tr>
                        <td class="text-center text-bold" colspan="3">TOTAL A</td>
                        <td class="text-right text-bold"><?= num_id($total_a) ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <table style="width:100%">
                    <tbody>
                      <tr>
                        <td>- Uang Lembur</td>
                        <td width="10">:</td>
                        <td class="text-right" width="120"><?= num_id($detail['overtime_all']) ?></td>
                        <td width="120"></td>
                      </tr>
                      <tr>
                        <td>- Uang HM</td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['hourmachine_all']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Uang Makan</td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['meal_all']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Uang Transport & Komunikasi</td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['comm_trans_all']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Rapel</td>
                        <td>:</td>
                        <td class="text-right" style="border-bottom:1px solid black"><?= num_id($detail['expense_all']) ?></td>
                        <td></td>
                      </tr>
                      <?php $total_b = $detail['overtime_all'] + $detail['hourmachine_all'] + $detail['meal_all'] + $detail['comm_trans_all'] + $detail['expense_all'] ?>
                      <tr>
                        <td class="text-center text-bold" colspan="3">TOTAL B</td>
                        <td class="text-right text-bold"><?= num_id($total_b) ?></td>
                      </tr>
                      <?php $total_c = $total_a + $total_b; ?>
                      <tr>
                        <td class="text-center text-bold" colspan="3">TOTAL C (A+B)</td>
                        <td class="text-right text-bold" style="border-top:1px solid black"><?= num_id($total_c) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-6">
                  <div class="text-bold">II. POTONGAN</div>
                  <table style="width:100%">
                    <tbody>
                      <tr>
                        <td>- BPJS TK (JHT)</td>
                        <td width="10">:</td>
                        <td class="text-right" width="120"><?= num_id($detail['bpjs_tk_jht_employee']) ?></td>
                        <td width="120"></td>
                      </tr>
                      <tr>
                        <td>- BPJS TK (JP)</td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['bpjs_tk_jp_employee']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- BPJS Kesehatan </td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['bpjs_ks_employee']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- PPh 21 </td>
                        <td>:</td>
                        <td class="text-right"><?= num_id($detail['tax']) ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Mangkir, Izin TB </td>
                        <td>:</td>
                        <td class="text-right" style="border-bottom:1px solid black"><?= num_id($detail['punishment']) ?></td>
                        <td></td>
                      </tr>
                      <?php $total_d = $detail['bpjs_tk_jht_employee'] + $detail['bpjs_tk_jp_employee'] + $detail['bpjs_ks_employee'] + $detail['tax'] + $detail['punishment'] ?>
                      <tr>
                        <td class="text-center text-bold" colspan="3">TOTAL D</td>
                        <td class="text-right text-bold"><?= num_id($total_d) ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <br><br>
                  <table style="width:100%">
                    <tbody>
                      <tr>
                        <td class="text-bold">III. GAJI DITERIMA (C-D)</td>
                        <td width="10">:</td>
                        <td width="120"></td>
                        <td class="text-right text-bold" width="120" style="border-top:1px solid black"><?= num_id($total_c - $total_d) ?></td>
                      </tr>
                    </tbody>
                  </table>
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