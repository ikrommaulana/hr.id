<style type="text/css">
    .dataTables_length {
        display: none;
    }
</style>
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
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div>
                                <div class="wizard-content">
                                    <div>
                                    <?php 
                                        $id_employee = $this->session->userdata('user_id');
                                        $data_user = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                                        if($data_user){
                                            $gbr = $data_user[0]->image;
                                        }else{
                                            $gbr = '';
                                        }
                                    ?>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <div class="col-md-2">
                                                            <div class="row">
                                                                <div><img src="<?=base_url()?>assets/images/<?php if($gbr!=''){echo $gbr;}else{echo 'admin.png';}?>" alt="user-img" width="180px" class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div>
                                                                    <a href="<?=base_url()?>piket/piket" style="width: 100%" class="btn btn-success btn-rounded waves-effect waves-light m-t-20">Ajukan Piket</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <style type="text/css">
                                                                .counter2{
                                                                    font-size: 14px;
                                                                    color: #f1f1f1
                                                                }
                                                            </style>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="white-box">
                                                                        <div class="row row-in">
                                                                            <div class="col-lg-2 col-sm-6 row-in-br">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-info"><i class="ti-ticket"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4>Total Piket</h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15"><?php if($data_piket){echo $jumlah_piket[0]->jml;}else{echo 0;}?></h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--row -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="row"> 
                                                    <div class="col-md-1 col-xs-12">
                                                    </div>
                                                    <div class="col-md-11 col-xs-12">
                                                        <div class="white-box">
                                                            <h3 class="box-title m-b-0">Summary</h3>
                                                            <div class="table-responsive" style="margin-top: -40px">
                                                                <table id="myTable" class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Tanggal</th>
                                                                            <th>Keperluan</th>
                                                                            <th>Jenis Piket</th>
                                                                            <th>Status</th>
                                                                            <th>Jam Masuk</th>
                                                                            <th>Jam Keluar</th>
                                                                            <th>Total</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php 
                                                                                $id_absensi = $user[0]->id_absensi;//29
                                                                                $no=1; foreach($data_piket as $view){
                                                                                $id_piket = $view->id_piket;
                                                                                $tgl_start = $view->start_date;//29
                                                                                $tgl_end = $view->end_date;//29
                                                                                $get_masuk = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_start'")->result();//29
                                                                                $get_keluar = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_start' ORDER BY id_employee_absensi DESC")->result();//29
                                                                                if($get_masuk){
                                                                                    $jam_masuk = $get_masuk[0]->absensi_time;//29    
                                                                                }else{
                                                                                    $jam_masuk = '00:00:00';
                                                                                }

                                                                                if($get_keluar){
                                                                                    $jam_keluar = $get_keluar[0]->absensi_time;//29    
                                                                                }else{
                                                                                    $jam_keluar = '00:00:00';
                                                                                }
                                                                                
                                                                                $datetime1 = new DateTime($jam_keluar);
                                                                                $datetime2 = new DateTime($jam_masuk);
                                                                                $interval = $datetime1->diff($datetime2);

                                                                                $status_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
                                                                                if($status_piket){
                                                                                    $jml_approver = count($status_piket);
                                                                                    $status_batal = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status_batal=1")->result();
                                                                                    $status_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=1")->result();
                                                                                    if($status_batal){
                                                                                        $data_batal = $status_batal[0]->batal_by;
                                                                                        $batal_by = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$data_batal'")->result();
                                                                                        $status = 'Telah dibatalkan oleh '.$batal_by[0]->nama;
                                                                                    }elseif($status_approve){
                                                                                        $jml_approve = count($status_approve);
                                                                                        if($jml_approver==$jml_approve){
                                                                                            $status = 'Telah Disetujui';
                                                                                        }else{
                                                                                            $status = 'Menunggu Persetujuan';
                                                                                        }
                                                                                    }else{
                                                                                        $status_not_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=2")->result();
                                                                                        if($status_not_approve){
                                                                                            $status = 'Tidak Disetujui';
                                                                                        }else{
                                                                                            $status = 'Menunggu Persetujuan';   
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                        <tr>
                                                                            <td><?=$no;?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $tanggal1 = strtotime($view->start_date); $dt = date("d F Y  ", $tanggal1);
                                                                                        $tanggal2 = strtotime($view->end_date); $dt2 = date("d F Y  ", $tanggal2);
                                                                                         echo $dt.' - '.$dt2 ;?>
                                                                                </td>
                                                                                <td><?=$view->keperluan;?></td>
                                                                                <td><?php if($view->jenis_piket==0){echo 'Dalam Kantor';}else{echo 'Luar Kantor';}?></td>
                                                                                <td><?=$status;?></td>
                                                                                <td><?=$jam_masuk;?></td>
                                                                                <td><?=$jam_keluar;?></td>
                                                                                <td><?=$interval->format('%h jam %i menit');?></td>
                                                                                <td>
                                                                                    <!--<?php $jm = $interval->format('%h'); 
                                                                                    if($jm>=5 && $view->report==''){?>
                                                                                    <a data-toggle="modal" data-target="#responsive-modal<?=$no;?>" title="Buat laporan"><i class="mdi mdi-book" style="font-size: 25px; color:#999; cursor: pointer"></i></a>
                                                                                    <?php }?>-->
                                                                                    <a href="<?=base_url()?>piket/print_surat/<?=$view->id_piket;?>" title="Cetak surat piket"><i class="mdi mdi-application" style="font-size: 25px; color:#999"></i></a>
                                                                                    <a href="<?=base_url()?>piket_approvel/print_dana/<?=$view->id_piket;?>" title="Pengajuan Dana"><i class="mdi mdi-coin" style="font-size: 25px; color:#999"></i></a>
                                                                                    <a href="<?=base_url()?>piket/detail/<?=$view->id_piket;?>" title="Lihat Detail"><i class="mdi mdi-eye" style="font-size: 25px; color:#999"></i></a>
                                                                                    <?php if($status=='Menunggu Persetujuan'){?>
                                                                                    <a href="<?=base_url()?>piket/edit/<?=$view->id_piket;?>" title="Edit"><i class="mdi mdi-pencil" style="font-size: 25px; color:#999"></i></a>
                                                                                    <?php }?>
                                                                                    <?php 
                                                                                    $tgl_skr = date('Y-m-d'); 
                                                                                    $mulai_piket = $view->start_date;
                                                                                    if(($status=='Menunggu Persetujuan') || ($status=='Telah Disetujui' && $tgl_skr<=$mulai_piket)){?>
                                                                                    <a href="<?=base_url()?>piket/batal/<?=$view->id_piket;?>" title="batalkan"><i class="mdi mdi-close" style="font-size: 25px; color:#999"></i></a>
                                                                                    <?php }?>
                                                                                </td>
                                                                        </tr>
                                                                        <!-- /.modal -->
                                                                            <div id="responsive-modal<?=$no;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header" style="margin: 30px 0px">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">Laporan piket tanggal <?=$dt.' - '.$dt2;?></h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form action="<?=base_url()?>piket/report/<?=$id_piket;?>" method="post">
                                                                                                <div class="form-group">
                                                                                                    <label for="message-text" class="control-label">Laporan </label>
                                                                                                    <textarea maxlength="300" class="form-control" id="message-text" required name="report"></textarea>
                                                                                                    <span style="color:#dedede">maksimal 300 karakter</span>
                                                                                                </div>
                                                                                            
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                                                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
                                                                                        </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php $no++;}?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--<div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <!-- .row 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="white-box">
                                                                <div class="table-responsive manage-table">
                                                                    <table class="table" cellspacing="14">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="150">No</th>
                                                                                <th>Tanggal</th>
                                                                                <th>Keperluan</th>
                                                                                <th>Laporan</th>
                                                                                <th>Status</th>
                                                                                <th>Jam Masuk</th>
                                                                                <th>Jam Keluar</th>
                                                                                <th>Total</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                $id_absensi = $user[0]->id_absensi;//29
                                                                                $no=1; foreach($data_piket as $view){
                                                                                $id_piket = $view->id_piket;
                                                                                $tgl_start = $view->start_date;//29
                                                                                $tgl_end = $view->end_date;//29
                                                                                $get_masuk = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_start'")->result();//29
                                                                                $get_keluar = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_start' ORDER BY id_employee_absensi DESC")->result();//29
                                                                                if($get_masuk){
                                                                                    $jam_masuk = $get_masuk[0]->absensi_time;//29    
                                                                                }else{
                                                                                    $jam_masuk = '00:00:00';
                                                                                }

                                                                                if($get_keluar){
                                                                                    $jam_keluar = $get_keluar[0]->absensi_time;//29    
                                                                                }else{
                                                                                    $jam_keluar = '00:00:00';
                                                                                }
                                                                                
                                                                                $datetime1 = new DateTime($jam_keluar);
                                                                                $datetime2 = new DateTime($jam_masuk);
                                                                                $interval = $datetime1->diff($datetime2);

                                                                                $status_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
                                                                                if($status_piket){
                                                                                    $jml_approver = count($status_piket);
                                                                                    $status_batal = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status_batal=1")->result();
                                                                                    $status_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=1")->result();
                                                                                    if($status_batal){
                                                                                        $data_batal = $status_batal[0]->batal_by;
                                                                                        $batal_by = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$data_batal'")->result();
                                                                                        $status = 'Telah dibatalkan oleh '.$batal_by[0]->nama;
                                                                                    }elseif($status_approve){
                                                                                        $jml_approve = count($status_approve);
                                                                                        if($jml_approver==$jml_approve){
                                                                                            $status = 'Telah Disetujui';
                                                                                        }else{
                                                                                            $status = 'Menunggu Persetujuan';
                                                                                        }
                                                                                    }else{
                                                                                        $status_not_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=2")->result();
                                                                                        if($status_not_approve){
                                                                                            $status = 'Tidak Disetujui';
                                                                                        }else{
                                                                                            $status = 'Menunggu Persetujuan';   
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            <tr class="advance-table-row">
                                                                                <td><?=$no;?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $tanggal1 = strtotime($view->start_date); $dt = date("d F Y  ", $tanggal1);
                                                                                        $tanggal2 = strtotime($view->end_date); $dt2 = date("d F Y  ", $tanggal2);
                                                                                         echo $dt.' - '.$dt2 ;?>
                                                                                </td>
                                                                                <td><?=$view->keperluan;?></td>
                                                                                <td><?=$view->report;?></td>
                                                                                <td><?=$status;?></td>
                                                                                <td><?=$jam_masuk;?></td>
                                                                                <td><?=$jam_keluar;?></td>
                                                                                <td><?=$interval->format('%h jam %i menit');?></td>
                                                                                <td>
                                                                                    <?php $jm = $interval->format('%h'); 
                                                                                    if($jm>=5 && $view->report==''){?>
                                                                                    <a data-toggle="modal" data-target="#responsive-modal<?=$no;?>" title="Buat laporan"><i class="mdi mdi-book" style="font-size: 25px; color:#999; cursor: pointer"></i></a>
                                                                                    <?php }?>
                                                                                    <a href="<?=base_url()?>piket/print_surat/<?=$view->id_piket;?>" title="Cetak surat piket"><i class="mdi mdi-application" style="font-size: 25px; color:#999"></i></a>
                                                                                    <a href="<?=base_url()?>piket_approvel/print_dana/<?=$view->id_piket;?>" title="Pengajuan Dana"><i class="mdi mdi-coin" style="font-size: 25px; color:#999"></i></a>
                                                                                    <a href="<?=base_url()?>piket/detail/<?=$view->id_piket;?>" title="Lihat Detail"><i class="mdi mdi-eye" style="font-size: 25px; color:#999"></i></a>
                                                                                    <?php if($status=='Menunggu Persetujuan'){?>
                                                                                    <a href="<?=base_url()?>piket/edit/<?=$view->id_piket;?>" title="Edit"><i class="mdi mdi-pencil" style="font-size: 25px; color:#999"></i></a>
                                                                                    <?php }?>
                                                                                    <?php 
                                                                                    $tgl_skr = date('Y-m-d'); 
                                                                                    $mulai_piket = $view->start_date;
                                                                                    if(($status=='Menunggu Persetujuan') || ($status=='Telah Disetujui' && $tgl_skr<=$mulai_piket)){?>
                                                                                    <a href="<?=base_url()?>piket/batal/<?=$view->id_piket;?>" title="batalkan"><i class="mdi mdi-close" style="font-size: 25px; color:#999"></i></a>
                                                                                    <?php }?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="7" class="sm-pd"></td>
                                                                            </tr>

                                                                            <!-- /.modal 
                                                                            <div id="responsive-modal<?=$no;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header" style="margin: 30px 0px">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">Laporan piket tanggal <?=$dt.' - '.$dt2;?></h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form action="<?=base_url()?>piket/report/<?=$id_piket;?>" method="post">
                                                                                                <div class="form-group">
                                                                                                    <label for="message-text" class="control-label">Laporan </label>
                                                                                                    <textarea maxlength="300" class="form-control" id="message-text" required name="report"></textarea>
                                                                                                    <span style="color:#dedede">maksimal 300 karakter</span>
                                                                                                </div>
                                                                                            
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                                                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
                                                                                        </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php $no++;}?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /row -->
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
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