<?php if($role_id==1){?>
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
                <!-- /.row -->
                <?php $tahun = date('Y'); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <form method="post" action="<?=base_url()?>report">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <select class="form-control p-0" id="input15" name="departemen">
                                        <?php $get_dept = $this->db->query("SELECT * FROM division ORDER BY division_name ASC")->result();?>
                                        <option value="">- pilih departemen -</option>
                                        <?php foreach($get_dept as $view){?>
                                            <option value="<?=$view->id_division;?>" <?php if($departemen==$view->id_division){echo 'selected';}?>><?=$view->division_name;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input class="form-control input-daterange-datepicker" type="text" id="input12" required name="tanggal" value="<?=$tanggal_start2.' - '.$tanggal_end2;?>" style="width: 300px">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" name="filter" class="btn btn-mini" title="Filter"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            </form>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th style="text-align: center;">Masuk Sebelum <br>Jam Kerja</th>
                                            <th>Terlambat</th>
                                            <th>Jam Keluar</th>
                                            <th>Total Jam</th>
                                            <th>Jam Kerja</th>
                                            <th>Lebih Jam</th>
                                            <th>Kurang Jam</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1;
                                            if($departemen==''){
                                                $data_kehadiran = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_absensi=b.id_absensi AND b.absensi_date>='$tanggal_start' AND b.absensi_date<='$tanggal_end' GROUP BY CONCAT(a.firstname, '-', b.absensi_date) ASC")->result();
                                            }else{
                                                $data_kehadiran = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_division='$departemen' AND a.id_absensi=b.id_absensi AND b.absensi_date>='$tanggal_start' AND b.absensi_date<='$tanggal_end' GROUP BY CONCAT(a.firstname, '-', b.absensi_date) ASC")->result();
                                            }
                                            foreach($data_kehadiran as $view){
                                                $data_keluar = $this->db->query("SELECT * FROM employee_absensi  WHERE id_absensi='$view->id_absensi' AND absensi_date='$view->absensi_date' ORDER BY id_employee_absensi DESC")->result();
                                                $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                                $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                                $tgl_skrg = date('Y-m-d'); 

                                                $tgl_kerja = $view->absensi_date;
                                                if($tgl_kerja=='2018-05-16'){
                                                    $jml_jam_kerja = 5;
                                                    $jml_jam_kerja2 = '05:00:00';
                                                    $jam_msk = '09:00:00';
                                                }elseif($tgl_kerja>'2018-05-16' and $tgl_kerja<'2018-06-21'){
                                                    $jml_jam_kerja = 8;
                                                    $jml_jam_kerja2 = '08:00:00';
                                                    $jam_msk = '08:00:00';
                                                }else{
                                                    $jml_jam_kerja = 9;
                                                    $jml_jam_kerja2 = '09:00:00';
                                                    $jam_msk = '09:00:00';
                                                }

                                                $jam_mulai_kerja = new DateTime($jam_msk);
                                                $jam_total_kerja = new DateTime($jml_jam_kerja2);
                                                $datetime1 = new DateTime($data_keluar[0]->absensi_time);
                                                $datetime2 = new DateTime($view->absensi_time);
                                                $interval = $datetime1->diff($datetime2); //total jam kerja
                                                $tot_jam_kerja = $interval->format('%h:%i:%s');

                                                $datetime3 = new DateTime($tot_jam_kerja);
                                                $interval2 = $jam_mulai_kerja->diff($datetime2);//kepagian
                                                $interval3 = $datetime2->diff($jam_mulai_kerja);//kesiangan
                                                //$interval4 = $datetime3->diff($jam_mulai_kerja);//lebih jam
                                                $interval4 = $datetime3->diff($jam_total_kerja);//lebih jam
                                                //$interval5 = $jam_mulai_kerja->diff($datetime3);//kurang jam
                                                $interval5 = $jam_total_kerja->diff($datetime3);//kurang jam
                                                $data_jam_kerja = $this->db->query("SELECT * FROM jam_kerja")->result();

                                                if($data_jam_kerja){
                                                    $jam_kerja = new DateTime($data_jam_kerja[0]->jam_masuk);    
                                                }elseif($tgl_kerja>'2018-05-16' && $tgl_kerja <'2018-06-15'){
                                                    $jam_kerja = new DateTime('08:00:00');
                                                }else{
                                                    $jam_kerja = new DateTime('09:00:00');
                                                }      
                                            
                                                if($datetime2<=$jam_kerja){
                                                    $kepagian = $jam_kerja->diff($datetime2);
                                                }else{
                                                    $kepagian = '-';
                                                }   
                                                if($data_division){
                                                    $division_name = $data_division[0]->division_name;
                                                }else{
                                                    $division_name = '-';
                                                }                                
                                            ?>
                                        <tr>
                                            <td style="text-align:center"><?=$view->nik;?></td>
                                            <td><a href="<?=base_url()?>report/summary_staf/<?=$view->id_employee.'/'.$tahun;?>"><?=$view->firstname;?></a></td> 
                                            <td><?php if($division_name!='-'){?><a href="<?=base_url()?>report/summary_div/<?=$view->id_division;?>"><?=$division_name;?></a><?php }?></td>
                                            <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
                                            <td><?php $tanggal = strtotime($view->absensi_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td style="background-color: <?php if($view->absensi_time<=$jam_msk){echo '#2EFE64';}elseif($view->absensi_time>$jam_msk){echo '#F78181';}?>; color:#fff"><?=$view->absensi_time;?></td>
                                            <td style="background-color: <?php if($view->absensi_time<$jam_msk){echo '#2EFE64';}?>; color:#fff"><?php if($view->absensi_time<$jam_msk){echo $interval2->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td style="background-color: <?php if($view->absensi_time>$jam_msk){echo '#F78181';}?>; color:#fff"><?php if($view->absensi_time>$jam_msk){echo $interval3->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td class="text-center"><?php if($view->absensi_date<$tgl_skrg){echo $data_keluar[0]->absensi_time;}else{echo '-';}?></td>
                                            <td style="background-color: <?php if($interval->format('%h')<$jml_jam_kerja){echo '#F78181';}else{echo '#2EFE64';}?>; color:#fff"><?=$interval->format('%h:%i:%s');?></td>
                                            <td class="text-center"><?=$jml_jam_kerja;?> Jam</td>
                                            <td style="background-color: <?php if($interval->format('%h')>=$jml_jam_kerja){echo '#2EFE64';}?>; color:#fff"><?php if($interval->format('%h')>=$jml_jam_kerja){echo $interval4->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td style="background-color: <?php if($interval->format('%h')<$jml_jam_kerja){echo '#F78181';}?>; color:#fff"><?php if($interval->format('%h')<$jml_jam_kerja){echo $interval5->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td></td>
                                        </tr>
                                        <?php $no++;}?>
                                        <?php 
                                            if($departemen==''){
                                                $data_izin = $this->db->query("SELECT * FROM employee a, permit b WHERE a.id_employee=b.id_employee AND b.start_date>='$tanggal_start' AND b.end_date<='$tanggal_end'")->result();
                                            }else{
                                                $data_izin = $this->db->query("SELECT * FROM employee a, permit b WHERE a.id_division='$departemen' AND a.id_employee=b.id_employee AND b.start_date>='$tanggal_start' AND b.end_date<='$tanggal_end'")->result();
                                            }
                                            foreach($data_izin as $view){
                                            $get_jenis_izin = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$view->id_cuti'")->result();
                                            if($get_jenis_izin){
                                                $jenis_cuti = $get_jenis_izin[0]->jenis_cuti;
                                            }else{
                                                $jenis_cuti = '';
                                            }
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                            if($data_division){
                                                $division_name = $data_division[0]->division_name;
                                            }else{
                                                $division_name = '-';
                                            }                                         
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$view->nik;?></td>
                                            <td><a href="<?=base_url()?>report/summary_staf/<?=$view->id_employee.'/'.$tahun;?>"><?=$view->firstname;?></a></td>
                                            <td><a href="<?=base_url()?>report/summary_div/<?=$view->id_division;?>"><?=$division_name;?></a></td>
                                            <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
                                            <td><?php $tanggal = strtotime($view->start_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td></td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?=$jenis_cuti;?></td>
                                        </tr>
                                        <?php }?>
                                        <?php 
                                            if($departemen==''){
                                                $data_dinas = $this->db->query("SELECT * FROM employee a, dinas b,dinas_approve c WHERE a.id_employee=b.id_employee AND b.start_date>='$tanggal_start' AND b.end_date<='$tanggal_end' AND c.status='1' GROUP BY b.id_dinas")->result();
                                            }else{
                                                $data_dinas = $this->db->query("SELECT * FROM employee a, dinas b,dinas_approve c WHERE a.id_division='$departemen' AND a.id_employee=b.id_employee AND b.start_date>='$tanggal_start' AND b.end_date<='$tanggal_end' AND c.status='1' GROUP BY b.id_dinas")->result();
                                            }
                                            foreach($data_dinas as $view){
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();   
                                            $start_date = $view->start_date;
                                            $end_date = $view->end_date;
                                            $begin = new DateTime( $start_date );
                                            $end   = new DateTime( $end_date );

                                            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                                                $tgl = $i->format("Y-m-d");                                      
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$view->nik;?></td>
                                            <td><a href="<?=base_url()?>report/summary_staf/<?=$view->id_employee.'/'.$tahun;?>"><?=$view->firstname;?></a></td>
                                            <td><?php if($data_division){echo $data_division[0]->division_name;}else{echo '-';}?></td>
                                            <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
                                            <td><?php $tanggal = strtotime($tgl); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td></td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Dinas ke <?=$view->tujuan;?></td>
                                        </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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