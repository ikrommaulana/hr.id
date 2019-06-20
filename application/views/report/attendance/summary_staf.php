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
                            <li><a href="javascript:void(0)">Absensi Karyawan</a></li>
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
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-3">
                        <div class="panel">
                            <div class="p-30">
                                <div class="row">
                                    <?php $gbr2 = $data_employee[0]->image ;?>
                                    <div class="col-xs-4 col-sm-4" style="overflow-y: hidden; overflow-x: hidden;"><img width="100px" height="100px" src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="profile"></div>
                                    <div class="col-xs-12 col-sm-8">
                                        <h2 class="m-b-0"><?=$data_employee[0]->firstname;?></h2>
                                        <h4><?=$jabatan.' '.$division_name;?></h4></div>
                                </div><hr>
                                <h4><b>Summary Izin Pertahun</b></h4><hr>
                                <div class="row m-t-10" style="height: 10px">
                                    <div class="col-xs-8 b-r">
                                        
                                    </div>
                                    <div class="col-xs-2">
                                        <p>used</p>
                                    </div>
                                    <div class="col-xs-2">
                                        <p>left</p>
                                    </div>
                                </div>
                                <?php if($data_hak_cuti){foreach($data_hak_cuti as $view){
                                    if($masa_kerja > 12 && $masa_kerja <25){
                                        $jumlah_hak_cuti = $view->jumlah * 2;    
                                    }else{
                                        $jumlah_hak_cuti = $view->jumlah;
                                    }
                                    
                                    $id_employee = $data_employee[0]->id_employee;
                                    $getCuti = $this->db->query("SELECT sum(total_days) as tot_hari FROM permit WHERE id_cuti='$view->id_cuti' AND id_employee='$id_employee' and status_batal='0'")->result();
                                    
                                    if($jumlah_hak_cuti==0){
                                        $sisa_cuti = '-';
                                        $jml_cuti = $getCuti[0]->tot_hari;    
                                    }else{
                                        $getCuti2 = $this->db->query("SELECT sum(total_days) as tot_hari FROM permit WHERE id_cuti='$view->id_cuti' AND id_employee='$id_employee' and status_batal='0'")->result();
                                        $jml_cuti = $getCuti2[0]->tot_hari;
                                        $sisa_cuti = $jumlah_hak_cuti - $jml_cuti;
                                    }
                                    
                                ?>
                                <div class="row m-t-10" style="height: 10px">
                                    <div class="col-xs-8 b-r">
                                        <p><?=$view->jenis_cuti;?><?php if($jumlah_hak_cuti!=0){echo ' ( '.$jumlah_hak_cuti.' )';}?></p>
                                    </div>
                                    <div class="col-xs-2 b-r">
                                        <h4><?=$jml_cuti;?></h4>
                                    </div>
                                    <div class="col-xs-2">
                                        <h4><?=$sisa_cuti;?></h4>
                                    </div>
                                </div><hr>
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-9 col-sm-12">
                        <div class="panel">
                            <div class="row" >
                                <div class="col-sm-4 panel-heading"></div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4" style="margin-top: 10px">
                                <form action="<?=base_url()?>report/filt_staf" method="post">
                                <input type="hidden" name="id_employee" value="<?=$id_employee;?>">
                                <div class="col-sm-8">
                                    <select name="tahun" class="form-control">
                                        <option value="2017" <?php if($tahun==2017){echo 'selected';} ;?>>2017</option>
                                        <option value="2018" <?php if($tahun==2018){echo 'selected';} ;?>>2018</option>    
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" name="save" class="btn btn-mini" title="Cari"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div> 
                                </form>
                                </div>
                            </div><br><br>
                            <?php
                                $kalender = CAL_GREGORIAN;

                            ?>
                            <div class="row" style="margin-left: 10px; ">
                                <div class="table-responsive col-sm-11">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Terlambat</th>
                                            <th>Total Jam</th>
                                            <th>Sebelum Jam Kerja</th>
                                            <th>Jam Kerja</th>
                                            <th>Lebih Jam</th>
                                            <th>Kurang Jam</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $no=1; foreach($data_employee as $view){
                                            $id_employee = $view->id_employee;
                                            for($b=1;$b<=12;$b++){
                                                if($b==1){
                                                    $bln = 'Januari';
                                                }elseif ($b==2) {
                                                    $bln = 'Februari';
                                                }elseif ($b==3) {
                                                    $bln = 'Maret';
                                                }elseif ($b==4) {
                                                    $bln = 'April';
                                                }elseif ($b==5) {
                                                    $bln = 'Mei';
                                                }elseif ($b==6) {
                                                    $bln = 'Juni';
                                                }elseif ($b==7) {
                                                    $bln = 'Juli';
                                                }elseif ($b==8) {
                                                    $bln = 'Agustus';
                                                }elseif ($b==9) {
                                                    $bln = 'September';
                                                }elseif ($b==10) {
                                                    $bln = 'Oktober';
                                                }elseif ($b==11) {
                                                    $bln = 'Nopember';
                                                }else{
                                                    $bln = 'Desember';
                                                }
                                                $tot_hari = cal_days_in_month($kalender,$b,$tahun);
                                                $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$b' AND YEAR(tanggal)='$tahun'")->num_rows();
                                                $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                                $jam_mulai_kerja = new DateTime('09:00:00');
                                                $data_izin = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$b' AND YEAR(b.start_date)='$tahun'")->result();
                                                $data_cuti_tahunan = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='6' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$b' AND YEAR(b.start_date)='$tahun'")->result();
                                                $data_sakit = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, permit b WHERE a.id_employee='$view->id_employee' AND b.id_cuti='5' AND a.id_employee=b.id_employee AND b.status_batal='0' AND MONTH(b.start_date)='$b' AND YEAR(b.start_date)='$tahun'")->result();
                                                $data_dinas = $this->db->query("SELECT sum(b.total_days) as tot_hari FROM employee a, dinas b WHERE a.id_employee='$view->id_employee' AND a.id_employee=b.id_employee AND b.status='0' AND MONTH(b.start_date)='$b' AND YEAR(b.start_date)='$tahun'")->result();
                                                $tot_data_izin = $data_izin[0]->tot_hari - $data_cuti_tahunan[0]->tot_hari - $data_sakit[0]->tot_hari;
                                                if($data_izin){
                                                    $total_izin = $data_izin[0]->tot_hari * 9;
                                                }else{
                                                    $total_izin = 0;
                                                }
                                                if($data_dinas){
                                                    $total_dinas = $data_dinas[0]->tot_hari * 9;
                                                }else{
                                                    $total_dinas = 0;
                                                }
                                                if($id_employee=='10044' && $b=='12' && $tahun=='2017'){ //hanif
                                                    $hari_kerja = 8;
                                                }elseif($id_employee=='10045'  && $b=='12' && $tahun=='2017'){
                                                    $hari_kerja = 3;
                                                }else{
                                                    $hari_kerja = $tot_hari - $cek_tgl_merah - 8;    
                                                }
                                                
                                                if($b=='05' && $tahun=='2018'){
                                                    $jumlah_jam_kerja = 166;    
                                                }else{
                                                    $jumlah_jam_kerja = $hari_kerja * 9;
                                                }

                                                for($a=1; $a<=$tot_hari; $a++){
                                                    $data_kehadiran[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$b' AND YEAR(b.absensi_date)='$tahun'")->result();
                                                    $data_keluar[$a] = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_employee='$view->id_employee' AND a.id_absensi=b.id_absensi AND DAY(b.absensi_date)='$a' AND MONTH(b.absensi_date)='$b' AND YEAR(b.absensi_date)='$tahun' ORDER BY b.id_employee_absensi DESC")->result();
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
                                                    $times_telat[$b] = array($telat[1],$telat[2],$telat[3],$telat[4],$telat[5],$telat[6],$telat[7],$telat[8],$telat[9],$telat[10],$telat[11],$telat[12],$telat[13],$telat[14],$telat[15],$telat[16],$telat[17],$telat[18],$telat[19],$telat[20],$telat[21],$telat[22],$telat[23],$telat[24],$telat[25],$telat[26],$telat[27],$telat[28],$telat[29],$telat[30],$telat[31]);
                                                    $times_kepagian[$b] = array($kepagian[1],$kepagian[2],$kepagian[3],$kepagian[4],$kepagian[5],$kepagian[6],$kepagian[7],$kepagian[8],$kepagian[9],$kepagian[10],$kepagian[11],$kepagian[12],$kepagian[13],$kepagian[14],$kepagian[15],$kepagian[16],$kepagian[17],$kepagian[18],$kepagian[19],$kepagian[20],$kepagian[21],$kepagian[22],$kepagian[23],$kepagian[24],$kepagian[25],$kepagian[26],$kepagian[27],$kepagian[28],$kepagian[29],$kepagian[30],$kepagian[31]);
                                                    $times_totaljam[$b] = array($totaljam[1],$totaljam[2],$totaljam[3],$totaljam[4],$totaljam[5],$totaljam[6],$totaljam[7],$totaljam[8],$totaljam[9],$totaljam[10],$totaljam[11],$totaljam[12],$totaljam[13],$totaljam[14],$totaljam[15],$totaljam[16],$totaljam[17],$totaljam[18],$totaljam[19],$totaljam[20],$totaljam[21],$totaljam[22],$totaljam[23],$totaljam[24],$totaljam[25],$totaljam[26],$totaljam[27],$totaljam[28],$totaljam[29],$totaljam[30],$totaljam[31],$total_izin,$total_dinas);

                                                    $seconds = 0; 
                                                    foreach ( $times_telat[$b] as $time ) 
                                                      {list( $g, $i, $s ) = explode( ':', $time ); 
                                                        $seconds += $g * 3600; 
                                                        $seconds += $i * 60; 
                                                        $seconds += $s; } 
                                                        $hours = floor( $seconds / 3600 ); 
                                                        $seconds -= $hours * 3600; 
                                                        $minutes = floor( $seconds / 60 ); 
                                                        $seconds -= $minutes * 60; 

                                                    $seconds2 = 0; 
                                                    foreach ( $times_kepagian[$b] as $time2 ) 
                                                      {list( $g2, $i2, $s2 ) = explode( ':', $time2 ); 
                                                        $seconds2 += $g2 * 3600; 
                                                        $seconds2 += $i2 * 60; 
                                                        $seconds2 += $s2; } 
                                                        $hours2 = floor( $seconds2 / 3600 ); 
                                                        $seconds2 -= $hours2 * 3600; 
                                                        $minutes2 = floor( $seconds2 / 60 ); 
                                                        $seconds2 -= $minutes2 * 60;

                                                    $seconds3 = 0; 
                                                    foreach ( $times_totaljam[$b] as $time3 ) 
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
                                            
                                        ?>
                                        <tr>
                                            <td class="text-center"><?=$no;?></td>
                                            <td><?=$bln;?></td>
                                            <td><?=$tahun;?></td>
                                            <td><?=$data_employee[0]->firstname;?></td>
                                            <td><?=$jabatan;?></td>
                                            <td class="text-center"><?="{$hours}:{$minutes}:{$seconds}";?></td>
                                            <td class="text-center"><?="{$hours3}:{$minutes3}:{$seconds3}";?></td>
                                            <td class="text-center"><?="{$hours2}:{$minutes2}:{$seconds2}";?></td>
                                            <td><?=$jumlah_jam_kerja;?> jam</td>
                                            <td><?=$lbh_jam;?></td>
                                            <td><?=$krg_jam;?></td>
                                        </tr>
                                        <?php $no++;}}?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="table-responsive">
                                <div class='contt' style="margin-top: 40px; width: 100%; height: 490px"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-3">
                        
                    </div>
                    <div class="col-md-6 col-lg-9 col-sm-12">
                        <div class="panel">
                            <div class="panel-heading" style="margin-left: -15px">Grafik Jam Kerja</div>
                            <div class="table-responsive">
                                <div class='contt2' style="margin-top: -10px; width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $('.contt').highcharts({
                     chart: {
                      type: 'column',
                      marginTop: 40
                     },
                     credits: {
                      enabled: false
                     }, 
                     tooltip: {
                            formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+
                                    'Jumlah : '+ this.y ;
                            }
                        },
                     title: {
                      text: ''
                     },
                     subtitle: {
                      text: ''
                     },
                     xAxis: {
                      categories: ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'],
                      labels: {
                       rotation: 0,
                       align: 'right',
                       style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                       }
                      }
                     },
                     legend: {
                      enabled: true
                     },
                     series: [
                     {"name":"Hari Kerja",
                      "data":[
                        <?php
                            for($a=1; $a<=12; $a++){
                                $cek_tgl_merah[$a] = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$a' AND YEAR(tanggal)='$tahun'")->num_rows();
                                $kalender = CAL_GREGORIAN;
                                $hari[$a] = cal_days_in_month($kalender,$a,$tahun);
                                $jml_hari[$a] = $hari[$a] - 8;
                                $jml_total_hari[$a] = $jml_hari[$a] - $cek_tgl_merah[$a];
                                echo $jml_total_hari[$a].',';
                            }
                        ;?>
                      ]
                      },
                     {"name":"Tidak Telat",
                      "data":[
                        <?php
                           for($a=1; $a<=12; $a++){
                                $cek_tidak_telat[$a] = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND MONTH(absensi_date)='$a' AND YEAR(absensi_date)='$tahun' AND absensi_time<'09:00:00' GROUP BY absensi_date")->num_rows();
                                echo $cek_tidak_telat[$a].',';
                            } 
                        ?>
                      ]
                     },
                     {"name":"Telat",
                      "data":[
                        <?php
                           for($a=1; $a<=12; $a++){
                                $cek_telat[$a] = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND MONTH(absensi_date)='$a' AND YEAR(absensi_date)='$tahun' AND absensi_time>'09:00:00' AND absensi_time<'18:00:00' GROUP BY absensi_date")->num_rows();
                                echo $cek_telat[$a].',';
                            } 
                        ?>
                      ]
                     },
                     {"name":"Dinas",
                      "data":[
                        <?php
                           for($a=1; $a<=12; $a++){
                                $cek_dinas = $this->db->query("SELECT sum(total_days) as tot FROM dinas WHERE id_employee='$id_employee' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                echo $cek_dinas[0]->tot.',';
                            } 
                        ?>
                      ]
                     },
                     {"name":"Cuti",
                      "data":[
                        <?php
                           for($a=1; $a<=12; $a++){
                                $cek_cuti = $this->db->query("SELECT sum(total_days) as tot FROM permit a, permit_approve b, cuti c WHERE a.id_cuti=C.id_cuti AND c.category_cuti='1' AND a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status='1' AND b.status_batal='0' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                echo $cek_cuti[0]->tot.',';
                            } 
                        ?>
                      ]
                     },
                     {"name":"Izin",
                      "data":[
                        <?php
                           for($a=1; $a<=12; $a++){
                                $cek_izin = $this->db->query("SELECT sum(total_days) as tot FROM permit a, permit_approve b, cuti c WHERE a.id_cuti=C.id_cuti AND c.category_cuti='2' AND a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status_batal='0' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                echo $cek_izin[0]->tot.',';
                            } 
                        ?>
                      ]
                     },
                     {"name":"Sakit",
                      "data":[
                        <?php
                           for($a=1; $a<=12; $a++){
                                $cek_sakit = $this->db->query("SELECT sum(total_days) as tot FROM permit a, permit_approve b, cuti c WHERE a.id_cuti='5' AND a.id_cuti=C.id_cuti AND a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status_batal='0' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                echo $cek_sakit[0]->tot.',';
                            } 
                        ?>
                      ]
                     },
                     {"name":"Abstain",
                      "data":[
                        <?php
                            for($a=1; $a<=12; $a++){
                                //hitung jumlah hari
                                $cek_tgl_merah[$a] = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal)='$a' AND YEAR(tanggal)='$tahun'")->num_rows();
                                $kalender = CAL_GREGORIAN;
                                $hari[$a] = cal_days_in_month($kalender,$a,$tahun);
                                $jml_hari[$a] = $hari[$a] - 8;
                                $jml_total_hari[$a] = $jml_hari[$a] - $cek_tgl_merah[$a];
                                $total_hari = $jml_total_hari[$a];

                                //hitung jumlah tidak telat
                                $cek_tidak_telat[$a] = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND MONTH(absensi_date)='$a' AND YEAR(absensi_date)='$tahun' AND absensi_time<'09:00:00' GROUP BY absensi_date")->num_rows();
                                $total_tidak_telat = $cek_tidak_telat[$a];

                                //hitung jumlah telat
                                $cek_telat[$a] = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND MONTH(absensi_date)='$a' AND YEAR(absensi_date)='$tahun' AND absensi_time>'09:00:00' AND absensi_time<'18:00:00' GROUP BY absensi_date")->num_rows();
                                $total_telat = $cek_telat[$a];

                                //hitung dinas
                                $cek_dinas = $this->db->query("SELECT sum(total_days) as tot FROM dinas WHERE id_employee='$id_employee' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                $total_dinas = $cek_dinas[0]->tot;

                                //hitung cuti
                                $cek_cuti = $this->db->query("SELECT sum(total_days) as tot FROM permit a, permit_approve b, cuti c WHERE a.id_cuti=C.id_cuti AND c.category_cuti='1' AND a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status='1' AND b.status_batal='0' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                $total_cuti = $cek_cuti[0]->tot;

                                //hitung izin
                                $cek_izin = $this->db->query("SELECT sum(total_days) as tot FROM permit a, permit_approve b, cuti c WHERE a.id_cuti=C.id_cuti AND c.category_cuti='2' AND a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status_batal='0' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                $total_izin = $cek_izin[0]->tot;

                                //hitung sakit
                                $cek_sakit = $this->db->query("SELECT sum(total_days) as tot FROM permit a, permit_approve b, cuti c WHERE a.id_cuti='5' AND a.id_cuti=C.id_cuti AND a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status_batal='0' AND MONTH(start_date)='$a' AND YEAR(start_date)='$tahun'")->result();
                                $total_sakit = $cek_sakit[0]->tot;

                                //jumlah izin dkk
                                $total_luar_kantor = $total_tidak_telat + $total_telat + $total_dinas + $total_cuti + $total_izin + $total_sakit;
                                $jumlah_abstain = $total_hari - $total_luar_kantor;
                                if($jumlah_abstain==$total_hari){
                                    echo '0,';
                                }else{
                                    echo $jumlah_abstain.',';
                                }
                            }
                        ;?>
                      ]
                     }
                     ]
                    });
                </script>
                <script type="text/javascript">
                    $('.contt2').highcharts({
                     chart: {
                      marginTop: 40
                     },
                     credits: {
                      enabled: false
                     }, 
                     tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        'Jumlah : '+ this.y +' Jam';
                }
            },
                     title: {
                      text: ''
                     },
                     subtitle: {
                      text: ''
                     },
                     xAxis: {
                      categories: ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'],
                      labels: {
                       rotation: 0,
                       align: 'right',
                       style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                       }
                      }
                     },
                     legend: {
                      enabled: true
                     },
                     series: [
                     {"name":"Lebih Kurang Jam Kerja",
                      "data":[20,2,-20,10,-15,30,0,10,-12,10,40,-20]
                      }
                     ]
                    });
                </script>
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
<?php }else{
    redirect('error');
}?>
                