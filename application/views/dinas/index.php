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
                                                                <div> <img src="<?=base_url()?>assets/images/<?php if($gbr!=''){echo $gbr;}else{echo 'admin.png';}?>" alt="user-img" width="180px" class="img-responsive">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div>
                                                                    <a href="<?=base_url()?>dinas/dinas" style="width: 100%" class="btn btn-success btn-rounded waves-effect waves-light m-t-20">Ajukan Dinas</a>
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
                                                                                        <span class="circle circle-md bg-info"><i class=" mdi mdi-airplane"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4>Total Perjalanan Dinas</h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15"><?php if($data_dinas){$jml = count($data_dinas); echo $jml;}else{echo 0;}?></h3>
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
                                                <!--?php $cek_holiday = $this->db->query("SELECT * FROM hari_libur WHERE tanggal>='2019-06-01' AND tanggal<='2019-07-01'")->result();
                                                print_r($cek_holiday);?-->
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
                                                                            <th>NO</th>
                                                                            <th>TANGGAL</th>
                                                                            <th>KEPERLUAN</th>
                                                                            <th>LOKASI TUJUAN</th>
                                                                            <th>STATUS PENGAJUAN</th>
                                                                            <th>STATUS APPROVEL DANA</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php $no=1; foreach($data_dinas as $view){
                                                                                $id_dinas = $view->id_dinas;
                                                                                $get_approvel_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas'")->result();
                                                                                $get_status_dinas = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
                                                                                $status_dinas = $get_status_dinas[0]->status;
                                                                                $dinas_updated_by = $get_status_dinas[0]->updated_by;
                                                                                if($dinas_updated_by > 0){
                                                                                    $get_updated_by = $this->db->query("SELECT * FROM employee WHERE id_employee='$dinas_updated_by'")->result();
                                                                                    $admin_cancel = $get_updated_by[0]->firstname;
                                                                                } else {
                                                                                   $admin_cancel = " "; 
                                                                                }

                                                                                $status_atasan = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
                                                                                $id_approver_pengajuan = (empty($status_atasan)) ? 0 : $status_atasan[0]->id_approver;

                                                                                $get_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver_pengajuan'")->result();
                                                                                $approver_name = (empty($get_approver)) ? 'No data' : $get_approver[0]->firstname;

                                                                                $status_a = $status_atasan[0]->status;

                                                                                 $status_dana_tolak = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='2'")->result();
                                                                                $status_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='0' AND status!='2'")->result();
                                                                                if($status_dana_tolak){
                                                                                    $appr = $status_dana_tolak[0]->id_approver;
                                                                                    $getapp = $this->db->query("SELECT * FROM employee WHERE id_employee='$appr'")->result();
                                                                                    $status_b = 'Ditolak oleh '.$getapp[0]->firstname;
                                                                                }elseif($status_dana){
                                                                                    $status_b = 'Menunggu Persetujuan';    
                                                                                }else{
                                                                                    $status_dana2 = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='2'")->result();
                                                                                    if($status_dana2){
                                                                                        $status_b = 'Ditolak';
                                                                                    }else{
                                                                                        $status_b = 'Telah Disetujui';
                                                                                    }
                                                                                    //$status_b = (isset($status_dana2))? 'Ditolak' : 'Telah Disetujui';
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
                                                                                <td><?=$view->tujuan;?></td>
                                                                                <td>
                                                                                <a data-toggle="modal" href="#myModala<?=$no;?>" class="btn btn-primary"><?php if($status_a==0){echo 'Menunggu Persetujuan';}elseif($status_a==1){echo 'Telah Disetujui';}else{echo 'Ditolak';};?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a data-toggle="modal" href="#myModal<?=$no;?>" class="btn btn-primary"><?=$status_b;?>
                                                                                </td>
                                                                                <td>
                                                                                <?php 
                                                                                if($status_dinas==3){
                                                                                    echo "Dinas dibatalkan oleh ".$admin_cancel;
                                                                                }else{
                                                                                    if($status_a==0){?>
                                                                                        <a href="<?=base_url()?>dinas/update_dinas/<?=$view->id_dinas;?>" title="Update Dinas"><i class="icon-pencil"></i></a><?php }?>

                                                                                        <?php if($status_a==1){?>
                                                                                        <a href="<?=base_url()?>dinas/print_surat/<?=$view->id_dinas;?>" title="Unduh Surat Perjalanan"><i class="icon-screen-tablet"> surat perjalanan</i></a><br>
                                                                                        <a href="<?=base_url()?>dinas/print_dana/<?=$view->id_dinas;?>" title="Unduh Surat Pengajuan Dana"><i class="icon-wallet"> surat pengajuan dana</i></a>
                                                                                        <?php 
                                                                                    }
                                                                                }?>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- start modal approvel budget -->
                                        <div id="myModal<?=$no;?>" class="modal fade in" >
                                            <style type="text/css">
                                                .wizard-next,.wizard-back{display: none};
                                            </style>
                                            <div class="modal-dialog" style="width:1000px; margin:100px auto">
                                                <div class="modal-content">
                                     
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Status Approvel Dana</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="exampleBasic2" >
                                                            <ul class="wizard-steps" role="tablist">
                                                                <?php $step=1; foreach($get_approvel_dana as $view){
                                                                    $data_approvel = $this->db->query("SELECT * FROM employee where id_employee='$view->id_approver'")->result();
                                                                    $nama_approver = (empty($data_approvel)) ? '' : $data_approvel[0]->firstname;
                                                                    $tgl_approver = strtotime($view->approve_date); 
                                                                    $dt = date("d F Y  ", $tgl_approver);
                                                                    $status_ap = $view->status;
                                                                    if($status_ap==1){
                                                                        $bg='#58FA82';
                                                                        $icon ='ti-check';
                                                                        $stt = 'telah disetujui';
                                                                        $tgl = $dt;
                                                                    }elseif($status_ap==0){
                                                                        $bg='#F3F781';
                                                                        $icon ='ti-minus';
                                                                        $stt = 'menunggu persetujuan';
                                                                        $tgl = '';
                                                                    }else{
                                                                        $bg='#FF0040';
                                                                        $icon ='ti-close';
                                                                        $stt = 'ditolak';
                                                                        $tgl = $dt;
                                                                    }
                                                                    ?>
                                                                <li role="tab" id="<?=$step;?>">
                                                                <h4><span style="background: <?=$bg;?>"><i class="<?=$icon;?>"></i></span><?=$nama_approver;?></h4>
                                                                <p style="margin:-20px 0px 0px 50px; "><?=$stt;?></p>
                                                                <p style="margin-left: 50px"><?=$tgl;?></p> 
                                                                </li>
                                                                <?php $step++;}?>
                                                            </ul>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="btn-group">
                                                            <button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Tutup</button>
                                                        </div>
                                                    </div>
                                     
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dalog -->
                                        </div><!-- /.modal -->
                                        <!-- end modal approvel budget -->

                                        <!-- start modal approvel -->
                                        <div id="myModala<?=$no;?>" class="modal fade in" >
                                            <style type="text/css">
                                                .wizard-next,.wizard-back{display: none};
                                            </style>
                                            <div class="modal-dialog" style="width:1000px; margin:100px auto">
                                                <div class="modal-content">
                                     
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Status Approvel Pengajuan</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="exampleBasic2" >
                                                            <ul class="wizard-steps" role="tablist">
                                                                <?php
                                                                    $tgl_approver_atasan = strtotime($status_atasan[0]->approve_date); 
                                                                    $dt_atasan = date("d F Y  ", $tgl_approver_atasan);
                                                                    if($status_a==1){
                                                                        $bg='#58FA82';
                                                                        $icon ='ti-check';
                                                                        $stt = 'telah disetujui';
                                                                        $tgl = $dt_atasan;
                                                                    }elseif($status_a==0){
                                                                        $bg='#F3F781';
                                                                        $icon ='ti-minus';
                                                                        $stt = 'menunggu persetujuan';
                                                                        $tgl = '';
                                                                    }else{
                                                                        $bg='#FF0040';
                                                                        $icon ='ti-close';
                                                                        $stt = 'ditolak';
                                                                        $tgl = $dt_atasan;
                                                                    }
                                                                    ?>
                                                                <li role="tab" id="<?=$step;?>">
                                                                <h4><span style="background: <?=$bg;?>"><i class="<?=$icon;?>"></i></span><?=$approver_name;?></h4>
                                                                <p style="margin:-20px 0px 0px 50px; "><?=$stt;?></p>
                                                                <p style="margin-left: 50px"><?=$tgl;?></p> 
                                                                </li>
                                                            </ul>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="btn-group">
                                                            <button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Tutup</button>
                                                        </div>
                                                    </div>
                                     
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dalog -->
                                        </div><!-- /.modal -->
                                        <!-- end modal approvel budget -->
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
                                                                                <th>NO</th>
                                                                                <th>TANGGAL</th>
                                                                                <th>KEPERLUAN</th>
                                                                                <th>LOKASI TUJUAN</th>
                                                                                <th>STATUS</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $no=1; foreach($data_dinas as $view){
                                                                                $get_status = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$view->id_dinas' AND status='0'")->result();
                                                                                if($get_status){
                                                                                    $status = 'Menunggu Persetujuan';
                                                                                }else{
                                                                                    $get_status2 = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$view->id_dinas' AND status='2'")->result();
                                                                                    if($get_status2){
                                                                                        $status = 'Pengajuan Ditolak';
                                                                                    }else{
                                                                                        $status = 'Telah Disetujui';
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
                                                                                <td><?=$view->tujuan;?></td>
                                                                                <td><?=$status;?></td>
                                                                                <td>
                                                                                    <?php if($status=='Telah Disetujui'){?>
                                                                                    <a href="<?=base_url()?>dinas/print_surat/<?=$view->id_dinas;?>" title="Unduh Surat Perjalanan"><i class="icon-screen-tablet"> surat perjalanan</i></a><br>
                                                                                    <a href="<?=base_url()?>dinas/print_dana/<?=$view->id_dinas;?>" title="Unduh Surat Pengajuan Dana"><i class="icon-wallet"> surat pengajuan dana</i></a>
                                                                                    <?php }?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="7" class="sm-pd"></td>
                                                                            </tr>
                                                                            <?php $no++;}?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /row 
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                -->
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