 <?php if($role_id==1 || $user_id=='10027'){?>
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
                            <li><a href="javascript:void(0)">Daftar Pengajuan Dinas</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                
                <!--row -->
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        <style type="text/css">
                            .btn-glyphicon { padding:8px; background:#ffffff; margin-right:4px; }
                            .icon-btn { padding: 1px 15px 3px 2px; border-radius:50px;}
                        </style>
                            <!--<div class="row">
                                <a class="btn icon-btn btn-info" href="<?=base_url()?>permit/daftar"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Cuti</a>
                                <a class="btn icon-btn btn-default" href="#"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Piket</a>
                                <a class="btn icon-btn btn-default" href="#"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-info"></span>Dinas</a>
                            </div><br>-->
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Dinas</th>
                                            <th>NS</th>
                                            <th>Nama Staf</th>
                                            <th>Dep.</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Tanggal</th>
                                            <th>Total Hari</th>
                                            <th>Total Hari Libur</th>
                                            <th>Approval</th>
                                            <th>Approval Budget</th>
                                            <th>Uang Telpon</th>
                                            <th>Uang Transport</th>
                                            <th>Uang Makan</th>
                                            <th>Uang Makan Hari Libur</th>
                                            <th>Total Dana</th>
                                            <th>Surat</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php $no=1; foreach($data_dinas as $view){
                                            $data_pengajuan = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$view->id_dinas'")->result();
                                            $status_pengajuan = $data_pengajuan[0]->status;
                                            $dinas_updated_by = $data_pengajuan[0]->updated_by;
                                            $dinas_updated_date = $data_pengajuan[0]->updated_date;
                                            if($dinas_updated_by > 1){
                                            $get_updated_by = $this->db->query("SELECT * FROM employee WHERE id_employee='$dinas_updated_by'")->result();
                                            $admin_cancel = $get_updated_by[0]->firstname;
                                            }else{
                                                $admin_cancel = "";
                                            }
                                            $id_dinas = $view->id_dinas; 

                                            $get_approvel_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas'")->result();

                                            $id_employee = $view->id_employee;
                                            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                                            $nama = $data_employee[0]->firstname;
                                            $id_division = $data_employee[0]->id_division;
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
                                            if($data_division){
                                                $nama_divisi = $data_division[0]->division_name;    
                                            }else{
                                                $nama_divisi ='-';  
                                            }
                                             
                                            $status_atasan = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
                                            $id_approver_pengajuan = (empty($status_atasan)) ? 0 : $status_atasan[0]->id_approver;
                                            $status_approver_pengajuan = (empty($status_atasan)) ? 0 : $status_atasan[0]->status;

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
                                            
                                            $data_telekomunikasi = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=1")->result();
                                            $data_bandara = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=2")->result();
                                            $data_makan = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=3")->result();
                                            $data_makan_libur = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=4")->result();
                                            
                                            $telpon = (isset($data_telekomunikasi[0]->biaya))? $data_telekomunikasi[0]->biaya : 0;
                                            $bandara = (isset($data_bandara[0]->biaya))? $data_bandara[0]->biaya : 0;
                                            $makan = (isset($data_makan[0]->biaya))? $data_makan[0]->biaya : 0;
                                            $makan_libur = (isset($data_makan_libur[0]->biaya))? $data_makan_libur[0]->biaya : 0;
                                            $total_holiday = $view->total_days_holiday;

                                            if($total_holiday!=''){
                                                if($data_makan_libur){
                                                    $um_holiday = $total_holiday * $makan_libur;
                                                }else{
                                                    $um_holiday = $total_holiday * 300000; // pengajuan lama/manual
                                                }
                                            }else{
                                                $um_holiday = 0;
                                            }
                                            
                                            $tot_hari = $view->total_days;
                                            $total = ($tot_hari * $makan) + $telpon + $bandara + $um_holiday;
                                            $biaya_makan = $makan * $tot_hari;
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->id_dinas;?></td>
                                            <td><?=$view->no_surat;?></td>
                                            <td><?=$nama;?></td>
                                            <td><?=$nama_divisi;?></td>
                                            <td><?=$view->tujuan;?></td>
                                            <td><?=$view->keperluan;?></td>
                                            <td>
                                                <?php 
                                                    $tanggal1 = strtotime($view->start_date);
                                                    $dt = date("d F Y  ", $tanggal1);
                                                    $tanggal2 = strtotime($view->end_date);
                                                    $dt2 = date("d F Y  ", $tanggal2);
                                                    echo $dt.' - '.$dt2;?>
                                            </td>
                                            <td class="text-center"><?=$view->total_days;?></td>
                                            <td class="text-center"><?=$total_holiday;?></td>
                                            <td><a data-toggle="modal" href="#myModala<?=$no;?>" class="btn btn-primary"><?php if($status_a==0){echo 'Menunggu Persetujuan';}elseif($status_a==1){echo 'Telah Disetujui';}else{echo 'Ditolak';};?></a></td>
                                            <td><a data-toggle="modal" href="#myModal<?=$no;?>" class="btn btn-primary"><?=$status_b;?></a></td>
                                            <td><?=$telpon;?></td>
                                            <td><?=$bandara;?></td>
                                            <td><?=$biaya_makan;?></td>
                                            <td><?=$um_holiday;?></td>
                                            <td class="text-right"><?=number_format($total);?></td>
                                            <td>
                                                <?php if($status_pengajuan==2){
                                                    echo 'Telah dibatalkan';
                                                }elseif($status_pengajuan==3){
                                                    echo 'Telah dibatalkan oleh '.$admin_cancel;
                                                }else{?>
                                                <?php if($status_dana && ($user_id==10000 || $user_id==10001)){?>
                                                    <a href="<?=base_url()?>dinas/update_dinas/<?=$view->id_dinas;?>" title="Update Dinas"><i class="icon-pencil"></i></a><?php }?>
                                                <?php if($status_a==1){?>
                                                    <a href="<?=base_url()?>dinas/print_surat/<?=$id_dinas;?>" title="Unduh Surat Perjalanan <?=$nama;?>"><i class="icon-screen-tablet"></i></a>
                                                    <a href="<?=base_url()?>dinas/print_dana/<?=$id_dinas;?>" title="Unduh Surat Pengajuan Dana <?=$nama;?>"><i class="icon-wallet"></i></a>
                                                <?php }?>
                                                <?php if($status_a==0 && $status_a!=2){?>
                                                    <a href="<?=base_url()?>resend/send_pengajuan_dinas/<?=$id_dinas;?>" title="Resend surat pengajuan <?=$nama;?>"><i class="icon-envelope-open"></i></a>
                                                <?php }elseif($status_a==1){if($status_dana && !$status_dana_tolak){?>
                                                    <a href="<?=base_url()?>resend/send_pengajuan_dana_dinas/<?=$id_dinas;?>" title="Resend pengajuan dana <?=$nama;?>" target='1'><i class="icon-envelope-open"></i></a>
                                                <?php }}?>
                                                    <a href="<?=base_url()?>dinas/hitung_ulang/<?=$id_dinas;?>" title="Recount <?=$nama;?>" target='1'><i class="icon-reload"></i></a>
                                                    <!--a href="<?=base_url()?>dinas/reject_dinas/<?=$id_dinas;?>" title="Batalkan <?=$nama;?>" target='1'><i class="icon-close"></i></a-->
                                                <?php }?>
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
                                                                    if($status_approver_pengajuan==1){
                                                                        $bg='#58FA82';
                                                                        $icon ='ti-check';
                                                                        $stt = 'telah disetujui';
                                                                        $tgl = $dt_atasan;
                                                                    }elseif($status_approver_pengajuan==0){
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