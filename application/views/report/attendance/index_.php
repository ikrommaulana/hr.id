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
                            <form method="post" action="<?=base_url()?>report/index_">
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
                                        <?php 
                                            $begin = new DateTime("$tanggal_start");
                                            $end = new DateTime("$tanggal_end");
                                            $end_new = $end->modify('+1 day');

                                            $interval = DateInterval::createFromDateString('1 day');
                                            $period = new DatePeriod($begin, $interval, $end_new);

                                            foreach ($period as $dt) {
                                                $tgl = $dt->format("Y-m-d");
                                                
                                                if($departemen==''){
                                                    $data_kehadiran = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_absensi=b.id_absensi AND b.absensi_date='$tgl' GROUP BY CONCAT(a.firstname, '-', b.absensi_date) ASC")->result();
                                                }else{
                                                    $data_kehadiran = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_division='$departemen' AND a.id_absensi=b.id_absensi AND b.absensi_date='$tgl' GROUP BY CONCAT(a.firstname, '-', b.absensi_date) ASC")->result();
                                                }

                                                $jam_masuk     = (isset($data_kehadiran[0]->absensi_time))? $data_kehadiran[0]->absensi_time : '-';
                                                $no=1; 
                                                foreach($data_kehadiran as $view){                                
                                                ?>

                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td><a href="<?=base_url()?>report/summary_staf/"></a></td> 
                                                <td></td>
                                                <td></td>
                                                <td><?php $tanggal = strtotime($tgl); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                                <td style="background-color:#2EFE64; color:#fff"><?=$view->absensi_time;?></td>
                                                <td style="background-color:#2EFE64; color:#fff"></td>
                                                <td style="background-color:#F78181; color:#fff"></td>
                                                <td class="text-center"></td>
                                                <td style="background-color:#F78181"></td>
                                                <td class="text-center"></td>
                                                <td style="background-color:#2EFE64; color:#fff"></td>
                                                <td style="background-color:#F78181; color:#fff"></td>
                                                <td></td>
                                            </tr>
                                            <?php $no++;}}?>
                                            
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