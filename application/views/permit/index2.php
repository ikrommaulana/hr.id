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
                                                                    <a href="<?=base_url()?>permit_/cuti" style="width: 100%" class="btn btn-success btn-rounded waves-effect waves-light m-t-20">Ajukan Cuti</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <style type="text/css">
                                                                .counter2{
                                                                    font-size: 14px;
                                                                    color: #000
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
                                                                                        <h4><a href="<?=base_url()?>permit_/index2/6" style="color:#000">Cuti Tahunan</a></h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15"><?php if($cuti_tahunan){echo $cuti_tahunan[0]->jml;}else{echo 0;};?></h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-lg-2 col-sm-6 row-in-br  b-r-none">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-danger"><i class="ti-wheelchair"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4><a href="<?=base_url()?>permit_/index2/5" style="color:#000">Cuti Sakit</a></h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15">
                                                                                            <?php if($cuti_sakit){echo $cuti_sakit[0]->jml;}else{echo 0;}?>
                                                                                        </h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <!--<div class="col-lg-2 col-sm-6 row-in-br">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-success"><i class="ti-car"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4>Perjalanan Dinas</h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15">2</h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>-->
                                                                            <div class="col-lg-2 col-sm-6 row-in-br">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-warning"><i class="ti-pencil-alt"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4><a href="<?=base_url()?>permit_/index2/4" style="color:#000">Izin </a><span style="color:#fff">new br br br</span></h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15">
                                                                                            <?php if($cuti_izin){echo $cuti_izin[0]->jml;}else{echo 0;}?>
                                                                                        </h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-lg-2 col-sm-6 row-in-br">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-inverse"><i class="ti-close"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4><a href="<?=base_url()?>permit_/index2/3" style="color:#000">Cuti haid </a><span style="color:#fff">new br</span></h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15">
                                                                                            <?php if($cuti_haid){echo $cuti_haid[0]->jml;}else{echo 0;}?>
                                                                                        </h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-lg-2 col-sm-6  b-0">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-purple"><i class="ti-gift"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4><a href="<?=base_url()?>permit_/index2/2" style="color:#000">Cuti Menikah</a></h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15">
                                                                                            <?php if($cuti_menikah){echo $cuti_menikah[0]->jml;}else{echo 0;}?>
                                                                                        </h3>
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
                                                            <h3 class="box-title m-b-0">Summary <?=$summary;?></h3>
                                                            <div class="table-responsive" style="margin-top: -40px">
                                                                <table id="myTable" class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>NO</th>
                                                                            <th>JENIS CUTI</th>
                                                                            <th>KEPERLUAN</th>
                                                                            <th>TANGGAL</th>
                                                                            <th>JUMLAH HARI</th>
                                                                            <th>STATUS</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $no=1; foreach($data_cuti as $view){
                                                                            $id_cuti = $view->id_cuti;
                                                                            $jenis_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
                                                                            $id_permit = $view->id_permit;
                                                                            $status_cuti = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();
                                                                            if($status_cuti){
                                                                                $jml_approver = count($status_cuti);
                                                                                $status_batal = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status_batal=1")->result();//batal disetujui
                                                                                $status_batal2 = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status_batal=2")->result();//menunggu persetujuan pembatalan
                                                                                $status_batal3 = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status_batal=3")->result();//batal ditolak
                                                                                $status_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=1")->result();
                                                                                if($status_batal){
                                                                                    $data_batal = $status_batal[0]->batal_by;
                                                                                    $batal_by = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$data_batal'")->result();
                                                                                    $status = 'Telah dibatalkan oleh '.$batal_by[0]->nama;
                                                                                }elseif($status_batal2){
                                                                                    $status = 'Menunggu Persetujuan Pembatalan';
                                                                                }elseif($status_batal3){
                                                                                    $status = 'Pembatalan Ditolak';
                                                                                }elseif($status_approve){
                                                                                    $jml_approve = count($status_approve);
                                                                                if($jml_approver==$jml_approve){
                                                                                    $status = 'Telah Disetujui';
                                                                                }else{
                                                                                    $status = 'Menunggu Persetujuan';
                                                                                }
                                                                            }else{
                                                                                $status_not_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=2")->result();
                                                                                if($status_not_approve){
                                                                                    $status = 'Tidak Disetujui';
                                                                                }else{
                                                                                    $status = 'Menunggu Persetujuan';   
                                                                                }
                                                                            }
                                                                            }
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-center"><?=$view->id_permit;?></td>
                                                                            <td><?=$jenis_cuti[0]->jenis_cuti;?></td>
                                                                            <td><?=$view->reason;?></td>
                                                                            <td><?php 
                                                                                    $tanggal1 = strtotime($view->start_date); $dt = date("d F Y  ", $tanggal1);
                                                                                    $tanggal2 = strtotime($view->end_date); $dt2 = date("d F Y  ", $tanggal2);
                                                                                    echo $dt.' - '.$dt2 ;?>
                                                                            </td>
                                                                            <td class="text-center"><?=$view->total_days;?></td>
                                                                            <td><?=$status;?></td>
                                                                            <td>
                                                                                <!--<div class="btn-group">
                                                                                    <a href="<?=base_url()?>permit/cancel/<?=$view->id_cuti;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Batalkan"><i class="icon-trash"></i></a>
                                                                                    </div>-->
                                                                                    <?php 
                                                                                        $now=date('Y-m-d');
                                                                                        $tgl_cuti=$view->start_date;
                                                                                        if($tgl_cuti<$now){
                                                                                     if((!$status_batal2) && (!$status_batal)){?>
                                                                                    <div class="button-box">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#<?=$id_permit;?>" data-whatever="@mdo">Batalkan</button>
                            </div><?php }}?>
                                                                            </td>
                                                                        </tr>

                                                                        <?php $no++;}?>
                                                                    </tbody>
                                                                </table>
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
                        </div>
                    </div>
                </div>

                <!-- .row -->
                <?php foreach ($data_cuti as $view2 ) {
                    $id_permit2 = $view2->id_permit;?>
                            <form method="post" action="<?=base_url()?>permit_/batal">
                            <input type="hidden" name="id_permit" value="<?=$id_permit2;?>">
                            <div class="modal fade" id="<?=$id_permit2;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="exampleModalLabel1">Alasan Batal</h4> </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="recipient-name1" name="alasan"> </div>
                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                      
                <?php }?>

                <!--add new-->
                
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
                