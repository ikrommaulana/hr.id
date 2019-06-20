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
                            <!--<div class="row">
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
                            </div>-->
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
                                            $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                                            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                                            $id_division = $data_employee[0]->id_division;
                                            $id_jabatan = $data_employee[0]->id_position;
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
                                            $join_date = $data_employee[0]->join_date;
                                            $dtback = $month - 1;
                                            for($a=1; $a<=$d; $a++){
                                                $dt = $year.'-'.$month.'-'.$a;
                                                $dt2 = $year.'-'.$dtback.'-'.$a;
                                                $data_kehadiran = $this->db->query("SELECT a.nik as nk,a.firstname as fn,b.absensi_time as at,b.absensi_date as ad FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date='$dt'")->result();
                                                $data_keluar = $this->db->query("SELECT a.nik as nk,a.firstname as fn,b.absensi_time as at,b.absensi_date as ad FROM employee a, employee_absensi b WHERE a.id_employee='$id_employee' AND a.id_absensi=b.id_absensi AND b.absensi_date='$dt' ORDER BY b.id_employee_absensi DESC")->result();
                                                if($data_kehadiran){
                                                    $jam_masuk = $data_kehadiran[0]->at;
                                                    $jam_keluar = $data_keluar[0]->at;
                                                    $ket ='Hadir';

                                                    
                                                }else{
                                                    $cek_permit = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND ((start_date>='$dt2' AND end_date='$dt') OR (start_date='$dt') OR (start_date<'$dt' AND end_date>'$dt'))")->result();
                                                    if($cek_permit){
                                                        $id_cuti = $cek_permit[0]->id_cuti;
                                                        $jenis_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
                                                        $ket = $jenis_cuti[0]->jenis_cuti;
                                                    }else{
                                                        $cek_holiday = $this->db->query("select * from hari_libur WHERE tanggal='$dt'")->result();
                                                        if($cek_holiday){
                                                            $ket = $cek_holiday[0]->keterangan;
                                                        }else{
                                                            $cek_dinas = $this->db->query("SELECT * FROM dinas WHERE id_employee='$id_employee' AND ((start_date>='$dt2' AND end_date='$dt') OR (start_date='$dt') OR (start_date<'$dt' AND end_date>'$dt'))")->result();
                                                            if($cek_dinas){
                                                                $ket = 'Dinas';
                                                            }else{
                                                                $ket = 'Abstain';    
                                                            }
                                                                
                                                        }
                                                        
                                                    }
                                                    $jam_masuk = '';
                                                    $jam_keluar = '';
                                                }   
                                                if($dt=='2018-05-16'){
                                                        $jml_jam_kerja = 5;
                                                        $jml_jam_kerja2 = '05:00:00';
                                                        $jam_msk = '09:00:00';
                                                    }elseif($dt>'2018-05-16' and $dt<'2018-06-21'){
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
                                                    $datetime1 = new DateTime($jam_keluar);
                                                    $datetime2 = new DateTime($jam_masuk);
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
                                            ?>
                                        <tr style="background-color: #<?php if($ket=='sabtu' || $ket=='minggu'){echo '#DF0101';}?>">
                                            <td style="text-align:center"><?=$data_employee[0]->nik;?></td>
                                            <td><?=$data_employee[0]->firstname;?></td> 
                                            <td><?=$data_division[0]->division_name;?></td>
                                            <td><?=$data_jabatan[0]->nama_jabatan;?></td>
                                            <td><?php $tanggal = strtotime($dt); $dt2 = date("d F Y  ", $tanggal); echo $dt2;?></td>
                                            <td><?=$jam_masuk;?></td>
                                            <td style="background-color: <?php if($jam_masuk<$jam_msk && $jam_masuk!=''){echo '#2EFE64';}?>; color:#fff"><?php if($jam_masuk<$jam_msk && $jam_masuk!=''){echo $interval2->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td style="background-color: <?php if($jam_masuk>$jam_msk && $jam_masuk!=''){echo '#F78181';}?>; color:#fff"><?php if($jam_masuk>$jam_msk && $jam_masuk!=''){echo $interval3->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td><?=$jam_keluar;?></td>
                                            <td style="background-color: <?php if($jam_masuk!=''){if($interval->format('%h')<$jml_jam_kerja){echo '#F78181';}else{echo '#2EFE64';}}?>; color:#fff"><?php if($jam_masuk!=''){echo $interval->format('%h:%i:%s');}?></td>
                                            <td class="text-center"><?php if($jam_masuk!=''){echo $jml_jam_kerja.' Jam';}?></td>
                                            <td style="background-color: <?php if($interval->format('%h')>=$jml_jam_kerja){echo '#2EFE64';}?>; color:#fff"><?php if($interval->format('%h')>=$jml_jam_kerja){echo $interval4->format('%h:%i:%s');}else{echo '-';}?></td>
                                            <td style="background-color: <?php if($jam_masuk!=''){if($interval->format('%h')<$jml_jam_kerja){echo '#F78181';}}?>; color:#fff"><?php if($jam_masuk!=''){if($interval->format('%h')<$jml_jam_kerja){echo $interval5->format('%h:%i:%s');}else{echo '-';}}?></td>
                                            <td style="color:<?php if($ket=='sabtu' || $ket=='minggu'){echo 'red';}?>"><?=$ket;?></td>
                                        </tr>
                                        <?php $no++;}?>
                                        
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