<?php 
error_reporting(0);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=laporan kehadiran.xls");
header("Pragma: no-cache");
header("Expires: 0");
if($bulan==1){
    $bln = 'Januari';
}elseif($bulan==2){
    $bln = 'Februari';
}elseif($bulan==3){
    $bln = 'Maret';
}elseif($bulan==4){
    $bln = 'April';
}elseif($bulan==5){
    $bln = 'Mei';
}elseif($bulan==6){
    $bln = 'Juni';
}elseif($bulan==7){
    $bln = 'Juli';
}elseif($bulan==8){
    $bln = 'Agustus';
}elseif($bulan==9){
    $bln = 'September';
}elseif($bulan==10){
    $bln = 'Oktober';
}elseif($bulan==11){
    $bln = 'Nopember';
}else{
    $bln = 'Desember';
}
$now = date('d-m-Y');

if($bulan==6 && $tahun==2018){
    $lama_jam = 8;
}else{
    $lama_jam = 9;
}
?>
<style type="text/css">
    th{padding: 0px 10px }
</style>
<h3 style="margin-bottom: -30px"><?=$bln.' '.$tahun;?></h3>
<h5 style="font-size: 12px; color:#999;">printed <?=$now;?></h5>

<h4 style="margin-bottom: -20px">Digital Asset</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' AND id_division='7'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10046' && $bulan=='01' && $tahun=='2018'){ //hanif
                                                $hari_kerja = 2;
                                            }
            elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }

                if($id_employee=='10024' && $bulan=='12' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 1; //case hari libur masuk kantor dan absen
                }else{
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }
                 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Finance And Accounting</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='4'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($id_employee=='10050'  && $bulan=='6' && $tahun=='2018'){
                $hari_kerja = 6;
            }elseif($id_employee=='10053'  && $bulan=='09' && $tahun=='2018'){
                $hari_kerja = 12;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }

                if($id_employee=='10017' && $bulan=='12' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 2; //case hari libur masuk kantor dan absen
                }else{
                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday; 
                }
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">General Affair</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='9'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari; 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">HRD and GA</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='5'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($id_employee=='10051'  && $bulan=='06' && $tahun=='2018'){
                $hari_kerja = 0;
            }elseif($id_employee=='10051'  && $bulan=='07' && $tahun=='2018'){
                $hari_kerja = 16;
            }elseif($id_employee=='10051'  && $bulan=='07' && $tahun=='2018'){
                $hari_kerja = 16;
            }elseif($id_employee=='10052'  && $bulan=='08' && $tahun=='2018'){
                $hari_kerja = 17;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday; 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Inovation and Strategic</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' AND id_division='16'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10054' && $bulan=='10' && $tahun=='2018'){ //hanif
                $hari_kerja = 3;
            }elseif($id_employee=='10046' && $bulan=='01' && $tahun=='2018'){ //hanif
                                                $hari_kerja = 2;
                                            }
            elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday; 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">IT</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='2'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            
            if($data_izin){
                if($id_employee=='10005' && $bulan=='06' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 2) * 9;
                }if($id_employee=='10006' && $bulan=='08' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 3) * 9;
                }if($id_employee=='10006' && $bulan=='09' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 3) * 9;
                }else{
                    $total_izin = $data_izin[0]->tot_hari * 9;    
                }
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                
                if($id_employee=='10005' && $bulan=='06' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 2 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }elseif($id_employee=='10005' && $bulan=='07' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 1 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }elseif($id_employee=='10006' && $bulan=='08' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 3 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }elseif($id_employee=='10006' && $bulan=='09' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 3 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }else{
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }
                 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?php
        if($id_employee=='10005' && $bulan=='06' && $tahun=='2018'){ 
                echo $data_cuti_tahunan[0]->tot_hari + 2;
            }elseif($id_employee=='10005' && $bulan=='07' && $tahun=='2018'){ 
                echo $data_cuti_tahunan[0]->tot_hari + 1;
            }elseif($id_employee=='10006' && $bulan=='08' && $tahun=='2018'){ 
                echo $data_cuti_tahunan[0]->tot_hari + 3;
            }else{echo $data_cuti_tahunan[0]->tot_hari;}?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?php if($id_employee=='10005' && $bulan=='06' && $tahun=='2018'){ 
                echo $tidak_hadir - 2;
            }else{echo $tidak_hadir;}?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Competition Administration and Development</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='6'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }

                if($id_employee=='10012' && $bulan=='12' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 3; //case hari libur masuk kantor dan absen
                }else{
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday; 
                }
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Sponsorship Management</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='3'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday; 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center">
        <?php
        if($id_employee=='10011' && $bulan=='07' && $tahun=='2018'){ 
                echo $data_cuti_tahunan[0]->tot_hari - 1;
            }else{echo $data_cuti_tahunan[0]->tot_hari;}?>
    </td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Media Relation</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='10'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }


            if($data_dinas){
                if($id_employee=='10044' && $bulan=='07' && $tahun=='2018'){ //hanif
                    $total_dinas = ($data_dinas[0]->tot_hari * 9) - 288;
                }else{
                    $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7}
                }
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }

                if($id_employee=='10049' && $bulan=='12' && $tahun=='2018'){ 
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 1; //case hari libur masuk kantor dan absen
                }else{
                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday; 
                }
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?php
        if($id_employee=='10044' && $bulan=='07' && $tahun=='2018'){ 
                echo $data_dinas[0]->tot_hari - 32;
            }else{echo $data_dinas[0]->tot_hari;}?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Secretary Director</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='8'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            /*if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }*/

            if($data_izin){
                if($id_employee=='10029' && $bulan=='06' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 6) * 9;
                }elseif($id_employee=='10028' && $bulan=='07' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 22) * 9;
                }elseif($id_employee=='10028' && $bulan=='08' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 21) * 9;
                }elseif($id_employee=='10028' && $bulan=='09' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 14) * 9;
                }else{
                    $total_izin = $data_izin[0]->tot_hari * 9;    
                }
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                if($id_employee=='10028'  && $bulan=='06' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 6 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }elseif($id_employee=='10028'  && $bulan=='07' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 22 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }elseif($id_employee=='10028'  && $bulan=='08' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 21 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }elseif($id_employee=='10028'  && $bulan=='09' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 14 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }else{
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }
                 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Legal Department</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='11'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            /*if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }*/

            if($data_izin){
                if($id_employee=='10029' && $bulan=='06' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 6) * 9;
                }elseif($id_employee=='10028' && $bulan=='07' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 22) * 9;
                }else{
                    $total_izin = $data_izin[0]->tot_hari * 9;    
                }
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                if($id_employee=='10028'  && $bulan=='06' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 6 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }elseif($id_employee=='10028'  && $bulan=='07' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 22 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }else{
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }
                 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>

<h4 style="margin-bottom: -20px">Procurement</h4>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
    <th>No</th>
    <th>NIK</th>
    <th>Name</th>
    <th>Jabatan</th>
    <th>Hari Kerja</th>
    <th>Realisasi Hari Kerja</th>
    <th>Jumlah Jam Kerja</th>
    <th>Realisasi Jam Kerja</th>
    <th>Datang Lebih Awal</th>
    <th>Terlambat</th>
    <th>Melebihi Jam Kerja</th>
    <th>Kurang Dari Jam Kerja</th>
    <th>Cuti Tahunan</th>
    <th>Izin</th>
    <th>Dinas</th>
    <th>Piket</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
<?php 
    $data_employee = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' AND id_division='12'")->result();
    $no=1;
        $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
        foreach($data_employee as $view){
            $id_jabatan = $data_employee[0]->id_position;
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            if($data_jabatan){
                $jabatan = $data_jabatan[0]->nama_jabatan;
            }else{
                $jabatan = '-';
            }
            $kalender = CAL_GREGORIAN;
            $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
            $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
            $id_employee = $view->id_employee;
            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
            $jam_mulai_kerja = new DateTime('09:00:00');
            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            //$data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
            $jml_izin_all += $tot_data_izin;
            $jml_dinas_all += $data_dinas[0]->tot_hari;
            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
            $jml_sakit_all += $data_sakit[0]->tot_hari;
            /*if($data_izin){
                $total_izin = $data_izin[0]->tot_hari * 9;
            }else{
                $total_izin = 0;
            }*/

            if($data_izin){
                if($id_employee=='10029' && $bulan=='06' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 6) * 9;
                }elseif($id_employee=='10028' && $bulan=='07' && $tahun=='2018'){
                    $total_izin = ($data_izin[0]->tot_hari + 22) * 9;
                }else{
                    $total_izin = $data_izin[0]->tot_hari * 9;    
                }
            }else{
                $total_izin = 0;
            }
            if($data_dinas){
                $total_dinas = $data_dinas[0]->tot_hari * 9;  //4.7
            }else{
                $total_dinas = 0;
            }
            if($id_employee=='10044' && $bulan=='12' && $tahun=='2017'){ //hanif
                $hari_kerja = 8;
            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                $hari_kerja = 3;
                $hari_ini = 3;
            }elseif($bulan=='12' && $tahun=='2017'){
                $hari_kerja = $tot_hari - $cek_tgl_merah;
                $hari_ini = 8;    
            }else{
                $hari_kerja = $tot_hari - $cek_tgl_merah;
            }
                                            
            $jumlah_jam_kerja = $hari_kerja * $lama_jam;
            for($a=1; $a<=$tot_hari; $a++){
                $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun'")->result();

                $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
                if($data_kehadiran[$a]){
                    ${'masuk'.$a}= $data_kehadiran[$a][0]->absensi_time;
                    ${'jam_masuk'.$a}= new DateTime($data_kehadiran[$a][0]->absensi_time);
                    ${'jam_keluar'.$a} = new DateTime($data_keluar[$a][0]->absensi_time);
                    ${'jumlah_jam'.$a} = ${'jam_keluar'.$a}->diff(${'jam_masuk'.$a});
                    $totaljam[$a] = ${'jumlah_jam'.$a}->format('%h:%i:%s');
                    if(${'masuk'.$a}>'09:00:00'){
                        ${'jumlah_telat'.$a} = ${'jam_masuk'.$a}->diff($jam_mulai_kerja);
                        $telat[$a] = ${'jumlah_telat'.$a}->format('%h:%i:%s');
                        $kepagian[$a] = '00:00:00';
                    }elseif(${'masuk'.$a}<'09:00:00'){
                        ${'jumlah_kepagian'.$a} = $jam_mulai_kerja->diff(${'jam_masuk'.$a});
                        $kepagian[$a] = ${'jumlah_kepagian'.$a}->format('%h:%i:%s');
                    }else{
                        $telat[$a] = '00:00:00';
                        $kepagian[$a] = '00:00:00';
                    }
                }else{
                    $telat[$a] = '00:00:00';
                    $kepagian[$a] = '00:00:00';
                    $totaljam[$a] = '00:00:00';
                }
                $times_telat = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                $times_kepagian = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                $times_totaljam = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                $seconds = 0; 
                foreach ( $times_telat as $time ) 
                {list( $g, $i, $s ) = explode( ':', $time ); 
                    $seconds += $g * 3600; 
                    $seconds += $i * 60; 
                    $seconds += $s; } 
                    $hours = floor( $seconds / 3600 ); 
                    $seconds -= $hours * 3600; 
                    $minutes = floor( $seconds / 60 ); 
                    $seconds -= $minutes * 60; 

                $seconds2 = 0; 
                foreach ( $times_kepagian as $time2 ) 
                {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                    $seconds2 += $g2 * 3600; 
                    $seconds2 += $i2 * 60; 
                    $seconds2 += $s2; } 
                    $hours2 = floor( $seconds2 / 3600 ); 
                    $seconds2 -= $hours2 * 3600; 
                    $minutes2 = floor( $seconds2 / 60 ); 
                    $seconds2 -= $minutes2 * 60;

                $seconds3 = 0; 
                foreach ( $times_totaljam as $time3 ) 
                {list( $g3, $i3, $s3 ) = explode( ':', $time3 ); 
                    $seconds3 += $g3 * 3600; 
                    $seconds3 += $i3 * 60; 
                    $seconds3 += $s3; } 
                    $hours3 = floor( $seconds3 / 3600 ); 
                    $seconds3 -= $hours3 * 3600; 
                    $minutes3 = floor( $seconds3 / 60 ); 
                    $seconds3 -= $minutes3 * 60;

                $lebih_jam = $hours3 - $jumlah_jam_kerja;
                if($lebih_jam>=0){
                    $lbh_jam = $lebih_jam.':'.$minutes3.':'.$seconds3;
                    $krg_jam = "00:00:00";
                }else{
                    $lbh_jam = "00:00:00";
                    $kurang_jam = $jumlah_jam_kerja - $hours3;
                    $krg_jam = $kurang_jam.':'.$minutes3.':'.$seconds3;
                }

                }
                if($id_employee=='10028'  && $bulan=='06' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 6 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }elseif($id_employee=='10028'  && $bulan=='07' && $tahun=='2018'){
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 22 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;    
                }else{
                    $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                }
                 
                if($bulan_ini==$bulan && $tahun_ini==$tahun){
                    if($hari_ini<$tot_hari){
                        $abstain = $hari_ini - $absen - $cek_tgl_merah1;    
                    }else{
                        $abstain = $tot_hari - $absen - $cek_tgl_merah;
                    }    
                }else{
                    $abstain = $hari_kerja - $absen;
                }
                                            
                if($abstain<0){
                    $tidak_hadir = 0;
                }else{
                    $tidak_hadir = $abstain;
                }
    ?>
 <tr>
    <td style="text-align:center"><?=$no;?></td>
    <td><?=$view->nik;?></td>
    <td><?=$view->firstname;?></td>
    <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
    <td class="text-center"><?=$hari_kerja;?></td>
    <td class="text-center"><?php if($absen>$hari_kerja){echo $hari_kerja;}else{echo $absen;};?></td>
    <td class="text-center"><?=$jumlah_jam_kerja;?> jam</td>
    <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
    <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
    <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
    <td class="text-center"><?=$lbh_jam;?></td>
    <td class="text-center"><?=$krg_jam;?></td>
    <td class="text-center"><?=$data_cuti_tahunan[0]->tot_hari;?></td>
    <td class="text-center"><?=$tot_data_izin;?></td>
    <td class="text-center"><?=$data_dinas[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_piket[0]->tot_hari;?></td>
    <td class="text-center"><?=$data_sakit[0]->tot_hari;?></td>
    <td class="text-center"><?=$tidak_hadir;?></td>
</tr>
<?php $no++;}?>
</table><br>