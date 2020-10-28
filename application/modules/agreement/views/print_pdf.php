<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SURAT PERJANJIAN KERJA</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-size: 14px;
    }

    td {
      padding-bottom: 5px;
    }
  </style>
</head>

<body>
  <!-- KOP SURAT -->

  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="100">
          <img src="<?= FCPATH . 'images/logos/' . $profile['logo'] ?>" alt="" srcset="" width="80">
        </td>
        <td width="540">
          <p style="text-align:center;font-size:28px;font-weight:bold; margin-top:15px;"><?= strtoupper($profile['company_name']) ?></p>
          <p style="text-align:center"><?= $profile['address'] ?></p>
        </td>
        <td width="100"></td>
      </tr>
    </table>
  </div>
  <br>
  <div style="border-bottom:1px solid black;margin-left:40px;margin-right:40px; "></div>
  <p style="text-align:center;font-weight:bold;font-size:16;text-decoration:underline;">PERJANJIAN KERJA WAKTU TERTENTU</p>
  <p style="text-align:center;font-weight:bold;font-size:16;">No.<?= $main['agreement_number'] ?></p>
  <!-- Nama Karyawan -->
  <br><br>
  <p style="margin-left:40px;margin-right:40px;text-align:justify;line-height:1.3;">Perjanjian Kerja Waktu Tertentu ini (untuk selanjutnya disebut <b>”Perjanjian Kerja”</b>), dibuat dan ditandatangani oleh dan antara: </p>
  <br>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">I</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;"><b><?= strtoupper($profile['company_name']) ?></b>, yang berkedudukan di Jakarta (untuk selanjutnya disebut sebagai <b>”PERUSAHAAN”</b>); dan</p>
        </td>
      </tr>
      <tr>
        <td width="25">II</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            <b><?= strtoupper($main['employee_name']) ?></b>, <?= ($main['sex'] == "M") ? 'Laki-laki' : 'Perempuan' ?>, <?= $main['family_status_description'] ?>, dalam hal ini mewakili dirinya sendiri,
            beralamat di Desa. <?= strtoupper($main['village_name']) ?>, Kec. <?= strtoupper($main['district_name']) ?>, Kab. <?= strtoupper($main['regency_name']) ?>,
            No KTP : <?= $main['id_number'] ?>, masa berlaku seumur hidup (untuk selanjutnya disebut sebagai <b>”PEKERJA”</b>).
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <p style="margin-left:40px;margin-right:40px;text-align:justify;line-height:1.3;">
    <b>PERUSAHAAN</b> dan <b>PEKERJA</b> masing-masing disebut sebagai <b>“Pihak”</b> dan bersama-sama disebut sebagai <b>“Para Pihak”</b>.
  </p>
  <br>
  <p style="margin-left:40px;margin-right:40px;text-align:justify;line-height:1.3;">
    Terlebih dahulu Para Pihak menerangkan sebagai berikut:
  </p>
  <br>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">-</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Bahwa PERUSAHAAN adalah sebuah badan hukum yang didirikan berdasarkan hukum Republik Indonesia.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">-</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Bahwa PEKERJA melamar di PERUSAHAAN dan bersedia bekerja dengan baik, penuh tanggung jawab serta mematuhi segala kondisi kerja dan peraturan-peraturan serta instruksi dari PERUSAHAAN.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">-</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Bahwa PERUSAHAAN menerima lamaran kerja yang diajukan oleh PEKERJA untuk dipekerjakan di lokasi proyek PERUSAHAAN atau tempat lain sesuai kebutuhan PERUSAHAAN.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">-</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Bahwa Para Pihak telah sepakat dan karenanya mengikatkan diri pada Perjanjian Kerja ini sesuai dengan syarat dan ketentuan-ketentuan sebagai berikut:
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <!-- Pasal 1 -->
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 1<br>RUANG LINGKUP
  </p>
  <p style="margin-left:40px;margin-right:40px;text-align:left;line-height:1.3;">
    Perjanjian Kerja ini melingkupi segala sesuatu yang berkaitan dengan pekerjaan yang diberikan oleh PERUSAHAAN kepada PEKERJA.
  </p>
  <br>
  <!-- Pasal 2 -->
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 2<br>JABATAN DAN LOKASI KERJA
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PERUSAHAAN mempekerjakan PEKERJA sebagai HOUSE KEEPER dengan syarat dasar bahwa PEKERJA bersedia untuk:
          </p>
        </td>
      </tr>
      <tr>
        <td width="25"></td>
        <td width="645">
          <table>
            <tr>
              <td width="25">a.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  mematuhi segala instruksi baik lisan maupun tertulis yang diberikan oleh PERUSAHAAN.
                </p>
              </td>
            </tr>
            <tr>
              <td width="25">b.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  dimutasi/dirotasi/ditempatkan ke lokasi kerja yang lain sesuai dengan kebutuhan PERUSAHAAN.
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td width="25">2</td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Desa Bunta, Kabupaten Morowali Utara, Sulawesi Tengah ditetapkan sebagai lokasi kerja PEKERJA. Jika dibutuhkan oleh PERUSAHAAN, PEKERJA dengan ini setuju untuk ditempatkan/ditugaskan/dimutasi ke lokasi kerja lain dan/atau di departemen/divisi lain sebagaimana ditentukan oleh PERUSAHAAN. Sebagai rujukan, Desa Bunta, Kabupaten Morowali Utara, Sulawesi Tengah akan menjadi tempat penerimaan kerja PEKERJA.
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br><br><br><br><br><br><br><br><br><br>
  <!-- Page 2 -->
  <!-- Pasal 3 -->
  <br><br><br>
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 3<br>JANGKA WAKTU
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Perjanjian Kerja ini berlaku untuk jangka waktu selama <?= $main['period'] ?>,
            terhitung sejak tanggal, 08 Agustus 2020 dan berakhir secara hukum pada tanggal 08 Februari 2021
            <b>(”Jangka Waktu Kerja”)</b>.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">2. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Dalam hal Jangka Waktu Kerja ingin diperpanjang, maka PERUSAHAAN akan memberitahukan kepada PEKERJA sekurang-kurangnya 7 (tujuh) hari sebelum Perjanjian Kerja ini berakhir.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">3. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Jangka waktu Perjanjian Kerja ini dapat berakhir sebelum berakhirnya masa Perjanjian bila :
          </p>
        </td>
      </tr>
      <tr>
        <td width="25"></td>
        <td width="645">
          <table>
            <tr>
              <td width="25">a.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  Atas kehendak PEKERJA dengan memberitahukan secara tertulis kepada PERUSAHAAN minimal 30 (tiga puluh) hari sebelum tanggal rencana berakhirnya Perjanjian Kerja ini.
                </p>
              </td>
            </tr>
            <tr>
              <td width="25">b.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  Atas kehendak PERUSAHAAN kepada PEKERJA dalam hal PEKERJA melakukan pelanggaran dalam Pasal 9 dalam Perjanjian Kerja ini dengan tunduk pada prosedur pemutusan hubungan kerja sesuai dengan peraturan perundang-undangan.
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 4<br>WAKTU DAN HARI KERJA
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PEKERJA diwajibkan mematuhi Waktu Kerja yang telah ditentukan oleh PERUSAHAAN.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">2. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Untuk posisi pekerjaan yang memberlakukan hari dan jam kerja khusus akan ditentukan sesuai dengan ketentuan perundangan yang berlaku.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">3. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PERUSAHAAN berhak untuk mengubah hari dan jam kerja berdasarkan sifat pekerjaan, kebutuhan dan kondisi Perusahaan, dengan tetap mengacu pada ketentuan perundang-undangan yang berlaku.
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <!-- pasal 5 -->
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 5<br>WAKTU DAN HARI KERJA
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PEKERJA dengan ini menyatakan kesanggupan dan kemampuannya untuk melakukan kewajiban-kewajiban yang diberikan oleh PERUSAHAAN kepadanya dan oleh karenanya PERUSAHAAN akan memberikan upah secara bulanan kepada PEKERJA.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">2. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Fasilitas & Benefit : Terlampir (Halaman 7)
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <!-- pasal 6 -->
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 6<br>KETENTUAN PEKERJAAN
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Apabila PEKERJA melakukan pelanggaran terhadap peraturan Perjanjian Kerja ini dan/atau ketentuan-ketentuan lainnya, maka PERUSAHAAN berhak untuk mengambil/memutuskan langkah-langkah tegas berupa teguran lisan, pemberian Surat Peringatan (SP) sampai pemutusan hubungan kerja (<b>“PHK”</b>).
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">2. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PEKERJA menyetujui untuk meningkatkan disiplin kerja, apabila PEKERJA tidak masuk kerja tanpa keterangan (mangkir), ijin (diluar dari ijin yang diatur oleh peraturan perundang-undangan yang
            berlaku) atau sakit dengan tidak disertai bukti tertulis yang sah, meninggalkan pekerjaan tanpa seijin atasan dan <i>Human Resouce Department</i> (HRD), maka Upah tidak dibayarkan dengan perhitungan 1 (satu) hari upah adalah gaji dan tunjangan tetap dibagi jumlah hari kerja dalam 1 (satu) bulan (30 hari untuk 7 hari kerja seminggu atau 21 hari untuk 5 hari kerja seminggu).
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- Page 14 -->
  <!-- Pasal  -->
  <br><br><br><br><br><br>
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 14<br>KERAHASIAAN
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PEKERJA wajib menjaga segala rahasia, informasi, data dan hal-hal lain yang dikategorikan sebagai informasi penting Perusahaan, baik selama masa kerja maupun tidak.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">2. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PEKERJA dilarang untuk membuka atau memberitahukan rahasia tersebut kepada pihak manapun, baik sendiri-sendiri maupun bersama-sama, atau kepada perusahaan lain, secara langsung maupun tidak langsung.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">3. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Apabila PERUSAHAAN menemukan adanya kebocoran informasi dan/atau rahasia, maka PERUSAHAAN memiliki hak untuk setiap saat mengajukan tuntutan, gugatan dan/atau permohonan ganti rugi atau kompensasi sesuai dengan ketentuan hukum yang berlaku.
          </p>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <p style="margin-left:40px;margin-right:40px;text-align:center;line-height:1.3;font-weight:bold;">
    PASAL 15<br>ATURAN TAMBAHAN
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="25">1. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            PERJANJIAN ini tunduk kepada peraturan perundang-undangan Republik Indonesia.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">2. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Para Pihak dengan ini mengesampingkan Pasal 1266 dan Pasal 1267 dari Kitab Undang-Undang Hukum Perdata sepanjang pasal tersebut mensyaratkan persetujuan pengadilan untuk pemutusan PERJANJIAN ini.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">3. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Segala perselisihan hubungan industrial yang timbul dari atau sehubungan dengan PERJANJIAN ini akan diselesaikan oleh Para Pihak menurut ketentuan peraturan perundang-undangan yang berlaku.
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">4. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Segala sesuatu yang belum diatur dalam Perjanjian Kerja ini akan diatur dalam peraturan dan perintah kerja/instruksi dari PERUSAHAAN yang merupakan bagian yang tidak dapat dipisahkan dari Perjanjian Kerja ini, antara lain sebagai berikut:
          </p>
        </td>
      </tr>
      <tr>
        <td width="25"></td>
        <td width="645">
          <table>
            <tr>
              <td width="25">a.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  Peraturan Perusahaan;
                </p>
              </td>
            </tr>
            <tr>
              <td width="25">b.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  Surat Keputusan Direksi; dan
                </p>
              </td>
            </tr>
            <tr>
              <td width="25">c.</td>
              <td width="610">
                <p style="text-align:justify;line-height:1.3;">
                  Surat Keputusan Human Resources Department yang diterbitkan sesuai dengan Keputusan Direksi dan/atau telah mendapat persetujuan tertulis dari Direksi.
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td width="25">5. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Perjanjian Kerja ini merupakan kesepakatan final dan menyeluruh antara PERUSAHAAN dan PEKERJA serta menggantikan seluruh kesepakatan atau pemahaman sebelumnya baik secara lisan maupun tulisan
          </p>
        </td>
      </tr>
      <tr>
        <td width="25">6. </td>
        <td width="645">
          <p style="text-align:justify;line-height:1.3;">
            Perjanjian Kerja ini dibuat dalam 2 (dua) rangkap, yang masing-masing ditandatangani secara sah dan patut, sehingga memiliki kedudukan dan kekuatan hukum yang sama. Perjanjian Kerja ini dinyatakan berlaku sejak ditandatanganinya Perjanjian Kerja ini, oleh Para Pihak dan Para Pihak dengan ini menyatakan bahwa keduanya telah membaca dan mengerti sepenuhnya dan sepakat untuk mengikatkan diri dengan syarat-syarat sebagaimana tercantum diatas.
          </p>
        </td>
      </tr>
    </table>
  </div>
  <p style="margin-left:40px;margin-right:40px;text-align:justify;line-height:1.3;">
    Demikian Perjanjian Kerja ini dibuat dalam keadaan sehat jasmani dan rohani dan tanpa ada paksaan dari pihak manapun dan mulai berlaku sejak tanggal <?= @date_id($main['start_date']) ?>
  </p>
  <br><br>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="250">PEKERJA / WORKER </td>
        <td width="150"></td>
        <td width="300"><?= strtoupper($profile['company_name']) ?></td>
      </tr>
      <tr>
        <td width="250"><br><br><br><br></td>
        <td width="150"><br><br><br><br></td>
        <td width="300"><br><br><br><br></td>
      </tr>
      <tr>
        <td width="250"><?= $main['employee_name'] ?> </td>
        <td width="150"></td>
        <td width="300"><u><?= strtoupper($main['signature_name']) ?></u></td>
      </tr>
      <tr>
        <td width="250"></td>
        <td width="150"></td>
        <td width="300">HRD MANAGER</td>
      </tr>
    </table>
  </div>
  <br><br><br><br><br><br><br><br><br><br>
  <!-- PAGE LAMPIRAN -->
  <br><br><br>
  <p style="margin-left:40px;margin-right:40px;text-align:justify;line-height:1.3;">
    Lampiran Perjanjian Kerja <br>
    No. <?= $main['agreement_number'] ?> Tertanggal <?= date_id($main['agreement_date']) ?>
  </p>
  <br><br><br>
  <p style="margin-left:40px;margin-right:40px;text-align:justify;line-height:1.3;font-size:20px">
    FASILITAS DAN BENEFIT
  </p>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="20">1. </td>
        <td width="200">Nama Karyawan </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['employee_name']) ?></td>
      </tr>
      <tr>
        <td width="20">2. </td>
        <td width="200">Tempat, Tanggal Lahir </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['pob']) . ', ' . date_id($main['dob']) ?></td>
      </tr>
      <tr>
        <td width="20">3. </td>
        <td width="200">Alamat (KTP) </td>
        <td width="10">:</td>
        <td width="450"><?= 'Desa. ' . strtoupper($main['village_name']) . ', Kecamatan. ' . strtoupper($main['district_name']) . ', Kabupaten. ' . strtoupper($main['regency_name']) ?></td>
      </tr>
      <tr>
        <td width="20">4. </td>
        <td width="200">Jenis Kelamin </td>
        <td width="10">:</td>
        <td width="450"><?= ($main['sex'] == "M") ? 'Laki-laki' : 'Perempuan' ?></td>
      </tr>
      <tr>
        <td width="20">5. </td>
        <td width="200">Mulai Bekerja </td>
        <td width="10">:</td>
        <td width="450"><?= date_id($main['start_date']) ?></td>
      </tr>
      <tr>
        <td width="20">6. </td>
        <td width="200">Status Tanggungan </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['family_status_name']) ?></td>
      </tr>
      <tr>
        <td width="20">7. </td>
        <td width="200">Jabatan/Posisi </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['position_name']) ?></td>
      </tr>
      <tr>
        <td width="20">8. </td>
        <td width="200">Department </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['department_name']) ?></td>
      </tr>
      <tr>
        <td width="20">9. </td>
        <td width="200">Status Penerimaan </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['reqruitment_status']) ?></td>
      </tr>
      <tr>
        <td width="20">10. </td>
        <td width="200">Lokasi Kerja </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['department_name']) ?></td>
      </tr>
      <tr>
        <td width="20">11. </td>
        <td width="200">Upah Pokok Sebulan </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['salary']) ?></td>
      </tr>
      <tr>
        <td width="20">12. </td>
        <td width="200">Overtime </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['overtime_status']) ?></td>
      </tr>
      <tr>
        <td width="20">13. </td>
        <td width="200">Uang makan </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['meal_allowance']) ?></td>
      </tr>
      <tr>
        <td width="20">14. </td>
        <td width="200">HM </td>
        <td width="10">:</td>
        <td width="450"><?= @strtoupper($main['hourmachine']) ?></td>
      </tr>
      <tr>
        <td width="20">15. </td>
        <td width="200">Npwp </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['tax_number']) ?></td>
      </tr>
      <tr>
        <td width="20">16. </td>
        <td width="200">No. Rekening Bank </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['bank_name']) ?></td>
      </tr>
      <tr>
        <td width="20">17. </td>
        <td width="200">Pajak Penghasilan </td>
        <td width="10">:</td>
        <td width="450"><?= strtoupper($main['bank_account']) ?></td>
      </tr>
    </table>
  </div>
  <br><br><br>
  <div style="margin-left:40px;margin-right:40px;">
    <table>
      <tr>
        <td width="250">PEKERJA / WORKER </td>
        <td width="150"></td>
        <td width="300"><?= strtoupper($profile['company_name']) ?></td>
      </tr>
      <tr>
        <td width="250"><br><br><br><br></td>
        <td width="150"><br><br><br><br></td>
        <td width="300"><br><br><br><br></td>
      </tr>
      <tr>
        <td width="250"><?= $main['employee_name'] ?> </td>
        <td width="150"></td>
        <td width="300"><u><?= strtoupper($main['signature_name']) ?></u></td>
      </tr>
      <tr>
        <td width="250"></td>
        <td width="150"></td>
        <td width="300">HRD MANAGER</td>
      </tr>
    </table>
  </div>
</body>

</html>