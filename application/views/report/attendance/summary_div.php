<?php if($role_id==1){?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>


        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
                        <ol class="breadcrumb">
                            <li><a href="javascript:void(0)">Absensi Karyawan Per Departemen</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?=$this->session->flashdata('notifikasi')?>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                
                <!--row -->
                <!-- .row -->
                <style type="text/css">
                    .img-circle2{
                        max-width: 50px;
                        max-height: 50px;
                        padding: 5px 5px;
                        border: 1px solid #dedede;
                        margin-top: 5px;
                        margin-bottom: 5px;
                    }
                </style>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-3">
                        <div class="panel">
                            <div class="p-30">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <p><span style="font-size: 15px">Departemen</span><br> <span style="font-size: 24px"><b><?=$division_name;?></b></span></p>
                                    </div>
                                </div><hr> 
                                <div class="row text-center m-t-30">
                                    <div class="col-xs-12">
                                        <table>
                                        <?php $no=1; foreach($data_employee as $view){
                                            $gbr2 = $view->image;
                                            $id_employee = $view->id_employee;
                                        ?>
                                        <tr style="border-bottom: 1px solid #dedede;"><td class="text-left">
                                        <a href="<?=base_url()?>report/summary_staf/<?=$id_employee.'/'.$tahun;?>"><img width="50" src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle2" /> <?=$view->firstname;?></a></td></tr>
                                        <?php }?>
                                        </table>
                                    </div>
                                </div>
                                
                            </div> 
                            <hr class="m-t-10" />
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-9 col-sm-12"> 
                        <div class="panel">
                            <div class="row" >
                                <div class="col-sm-2 panel-heading">Kehadiran</div>
                                <div class="col-sm-10" style="margin-top: 10px">
                                <form action="<?=base_url()?>report/filt_div" method="post">
                                <div class="col-sm-3">
                                    <select name="id_division" class="form-control">
                                        <?php foreach($data_division_all as $view){?>
                                        <option value="<?=$view->id_division;?>" <?php if($id_division==$view->id_division){echo 'selected';} ;?>><?=$view->division_name;?></option>
                                        <?php }?>  
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select name="bulan" class="form-control">
                                        <option value="1" <?php if($bulan==1){echo 'selected';} ;?>>Januari</option>
                                        <option value="2" <?php if($bulan==2){echo 'selected';} ;?>>Februari</option>
                                        <option value="3" <?php if($bulan==3){echo 'selected';} ;?>>Maret</option>
                                        <option value="4" <?php if($bulan==4){echo 'selected';} ;?>>April</option>
                                        <option value="5" <?php if($bulan==5){echo 'selected';} ;?>>Mei</option>
                                        <option value="6" <?php if($bulan==6){echo 'selected';} ;?>>Juni</option>
                                        <option value="7" <?php if($bulan==7){echo 'selected';} ;?>>Juli</option>
                                        <option value="8" <?php if($bulan==8){echo 'selected';} ;?>>Agustus</option>
                                        <option value="9" <?php if($bulan==9){echo 'selected';} ;?>>September</option>
                                        <option value="10" <?php if($bulan==10){echo 'selected';} ;?>>Oktober</option>
                                        <option value="11" <?php if($bulan==11){echo 'selected';} ;?>>Nopember</option>
                                        <option value="12" <?php if($bulan==12){echo 'selected';} ;?>>Desember</option>    
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="tahun" class="form-control">
                                        <option value="2019" <?php if($tahun=='2019'){echo 'selected';} ;?>>2019</option>
                                        <option value="2018" <?php if($tahun=='2018'){echo 'selected';} ;?>>2018</option>
                                        <option value="2017" <?php if($tahun=='2017'){echo 'selected';} ;?>>2017</option>    
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" name="save" class="btn btn-mini" title="Cari"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div> 
                                <div class="col-sm-3">
                                    <a href="<?=base_url();?>report/to_excel/<?=$bulan.'/'.$tahun;?>" class="btn btn-success">Cetak Semua</a>    
                                </div>
                                
                                </form>
                                </div>
                            </div>
                            <?php
                                $kalender = CAL_GREGORIAN;
                                $tot_hari = cal_days_in_month($kalender,$bulan,$tahun);
                                $hari_ini = date('d');
                                $bulan_ini = date('m');
                                $tahun_ini = date('Y');
                                $cek_tgl_merah1 = $this->db->query("SELECT * FROM hari_libur WHERE DAY(tanggal)<='$hari_ini' AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
                                $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'")->num_rows();
                            ?>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
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
                                    </thead>
                                    <tbody>
                                        <?php $jml_izin_all=0; $jml_dinas_all=0; $jml_cuti_thn_all=0; $jml_sakit_all=0; $no=1; $jumlah_hadir=0; 
                                        foreach($data_employee as $view){
                                            $id_employee = $view->id_employee;
                                            $data_kehadiran_all = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
                                            $data_kehadiran_all_holiday = $this->db->query("SELECT * FROM employee a, employee_absensi b, hari_libur c WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date=c.tanggal AND MONTH(b.absensi_date)='$bulan' AND YEAR(b.absensi_date)='$tahun' GROUP BY b.absensi_date")->num_rows();
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                            $jam_mulai_kerja = new DateTime('09:00:00');
                                            $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
                                            $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
                                            $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND MONTH(b.end_date)='$bulan' AND YEAR(b.end_date)='$tahun'")->result();
                                            $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun'")->result();
                                            $data_piket = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, piket b, piket_approve c WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$bulan' AND YEAR(b.start_date)='$tahun' AND b.id_piket=c.id_piket AND c.status='1' AND c.status_batal='0'")->result();
                                            $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
                                            $jml_izin_all += $tot_data_izin;
                                            $jml_dinas_all += $data_dinas[0]->tot_hari;
                                            $jml_cuti_thn_all += $data_cuti_tahunan[0]->tot_hari;
                                            $jml_sakit_all += $data_sakit[0]->tot_hari;
                                            if($data_izin){
                                                if($id_employee=='10006' && $bulan=='09' && $tahun=='2018'){
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
                                            }elseif($id_employee=='10046' && $bulan=='01' && $tahun=='2018'){ //hanif
                                                $hari_kerja = 2;
                                            }elseif($id_employee=='10045'  && $bulan=='12' && $tahun=='2017'){
                                                $hari_kerja = 3;
                                                $hari_ini = 3;
                                            }elseif($id_employee=='10051'  && $bulan=='07' && $tahun=='2018'){
                                                $hari_kerja = 16;
                                            }elseif($id_employee=='10052'  && $bulan=='07' && $tahun=='2018'){
                                                $hari_kerja = 0;
                                            }elseif($id_employee=='10053'  && $bulan=='09' && $tahun=='2018'){
                                                $hari_kerja = 12;
                                            }elseif($bulan=='12' && $tahun=='2017'){
                                                $hari_kerja = $tot_hari - $cek_tgl_merah;
                                                $hari_ini = 8;    
                                            }else{
                                                $hari_kerja = $tot_hari - $cek_tgl_merah;
                                            }
                                            
                                            if($bulan=='05' && $tahun=='2018'){
                                                $jumlah_jam_kerja = 166;    
                                            }else{
                                                $jumlah_jam_kerja = $hari_kerja * 9;
                                            }
                                            
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
                                            //$absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            if($id_employee=='10005' && $bulan=='06' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 2 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10005' && $bulan=='07' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 1 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10006' && $bulan=='08' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 3 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10006' && $bulan=='08' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 3 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10006' && $bulan=='09' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 3 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10028' && $bulan=='09' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 13 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10028' && $bulan=='08' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 21 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10028' && $bulan=='07' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 22 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10028' && $bulan=='06' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + 6 + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday;
                                            }elseif($id_employee=='10017' && $bulan=='12' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 2;
                                            }elseif($id_employee=='10012' && $bulan=='12' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 3;
                                            }elseif($id_employee=='10049' && $bulan=='12' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 1;
                                            }elseif($id_employee=='10024' && $bulan=='12' && $tahun=='2018'){ 
                                                $absen = $data_kehadiran_all + $tot_data_izin + $data_cuti_tahunan[0]->tot_hari + $data_dinas[0]->tot_hari + $data_sakit[0]->tot_hari - $data_kehadiran_all_holiday + 1;
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
                                            <td><a target="1" href="<?=base_url()?>report/detail/<?=$view->id_employee.'/'.$bulan.'/'.$tahun;?>"><?=$view->firstname;?></a></td>
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
                                            <td><?=$data_piket[0]->tot_hari;?></td>
                                            <td class="text-center"><?php if($id_employee=='10000' && $bulan=='09' && $tahun=='2018'){ 
                echo $data_sakit[0]->tot_hari + 0;
            }else{echo $data_sakit[0]->tot_hari;}?></td>
                                            <td class="text-center"><?=$tidak_hadir;?></td>
                                        </tr>
                                        <?php $no++;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading" style="margin-left: -15px">Grafik Kehadiran</div>
                                    <div class="row">
                                    <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="white-box">
                                            <div id="cont" style="height: 285px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="white-box">
                                            <div id="cont2" style="height: 285px;"></div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- wallet, & manage users widgets -->
                <!-- ============================================================== -->
                <!-- .row -->
                <div class="row">
                    <!-- col-md-9 -->
                    <!-- /col-md-9 -->
                    <!-- col-md-3 -->
                    <div class="col-md-4 col-lg-3">
                        <div class="panel wallet-widgets"  style="height:0px; display: none">
                            <div class="panel-body">
                                
                            </div>
                            <div id="morris-area-chart2" style="height:0px; display: none"></div>
                            
                        </div>
                    </div>
                    <!-- /col-md-3 --> 
                </div>

            <script type="text/javascript">
    $(function () {
        $(document).ready(function() {
            Highcharts.chart('cont', {
            credits: {
                enabled: false
            },
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            series: [{
                name: 'Jumlah ',
                data: [
                    ['Izin', <?=$jml_izin_all;?>],
                    ['Dinas', <?=$jml_dinas_all;?>],
                    ['Cuti Tahunan',<?=$jml_cuti_thn_all;?>],
                    ['Sakit',<?=$jml_sakit_all;?>]
                ]
            }]
            });
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $(document).ready(function() {
            Highcharts.chart('cont2', {
            credits: {
                enabled: false
            },
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            series: [{
                name: 'Jumlah ',
                data: [
                    ['Sebelum Jam Kerja', 50],
                    ['Tepat Waktu', 10],
                    ['Terlambat', 40]
                ]
            }]
            });
        });
    });
</script>
<?php }else{
    redirect('error');
}?>