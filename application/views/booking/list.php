
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
                            <a href="#" type="button" class="btn btn-success btn-circle" style="color: #fff"
                            data-toggle="modal" data-target="#mymodal"><i class="fa fa-plus"></i> </a>
                            <li><a href="javascript:void(0)">Daftar booking</a></li>
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        <h3><?=$meeting_room[0]->room_name.' List';?></h3><hr><br>
                            <div class="table-responsive">
                                <table id="myTable" class="display nowrap" cellspacing="0" width="100%">
                                <?php
                                    $id_employee = $this->session->userdata('user_id');
                                ?>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Agenda</th>
                                            <th>Tanggal</th>
                                            <th>Jam Mulai</th>
                                            <th>Jam Selesai</th>
                                            <th>Dibooking Oleh</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_meeting_room_booking as $view){
                                            $id_meeting_room = $view->id_meeting_room;
                                            $dibuat_oleh = $view->booking_by;
                                            $status = $view->status_batal;
                                            if($status==1){
                                                $batal_by = $view->batal_by;
                                                $pembatal = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$batal_by'")->result();
                                                $sts = 'Dibatalkan oleh '.$pembatal[0]->nama;
                                            }else{
                                                $sts = '-';
                                            }
                                            $tanggal = strtotime($view->meeting_date); $dt = date("d F Y  ", $tanggal);
                                            $mulai = $view->meeting_start;
                                            $akhir = $view->meeting_end;
                                            ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->description;?></td>
                                            <td><?=$dt;?></td>
                                            <td><?=$mulai;?></td>
                                            <td><?=$akhir;?></td>
                                            <td><?=$view->firstname;?></td>
                                            <td><?=$sts;?></td>
                                            <td>
                                                <?php
                                                    if($id_meeting_room==3 || $id_meeting_room==4){
                                                        if($status!=1){if($id_employee==$dibuat_oleh || $id_employee=='10039'){?>
                                                <a href="<?=base_url()?>booking/batal/<?=$view->id_meeting_room_booking.'/'.$view->id_meeting_room;?>" title="batalkan"><i class="mdi mdi-close" style="font-size: 25px; color:#999"></i></a>
                                                <?php }}}elseif($id_meeting_room==2){
                                                    if($status!=1){if($id_employee==$dibuat_oleh || $id_employee=='10013'){?>
                                                <a href="<?=base_url()?>booking/batal/<?=$view->id_meeting_room_booking.'/'.$view->id_meeting_room;?>" title="batalkan"><i class="mdi mdi-close" style="font-size: 25px; color:#999"></i></a>
                                                <?php }}}?>
                                            </td>
                                        </tr>
                                        <?php $no++;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <style type="text/css">
                    .popover{
                        z-index: 9999;
                    }
                </style>

                <div class="row" style="z-index: 9000">
                    <div class="col-md-4">
                            <!-- sample modal content -->
                            <!-- /.modal -->
                            <div id="mymodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <form method="post" action="<?=base_url()?>booking/add_edit_data_booking/<?=$id_meeting_room;?>">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="padding:30px">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="info" style="color:#999">Booking ruang meeting</h4> 
                                        </div>
                                        <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Keterangan :</label>
                                                    <input type="text" name="keterangan" class="form-control room-name" id="recipient-name" required> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Tanggal :</label>
                                                    <div class="input-group">
                                                        <input type="text" name="tanggal" id="datepicker-autoclose" class="form-control" required> <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Jam Mulai :</label>
                                                    <div class="input-group">
                                                        <input type="text" id="#single-input" class="form-control clockpicker" name="jam_mulai" required> <span class="input-group-addon"> <i class="glyphicon glyphicon-time"></i> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Jam Selesai:</label>
                                                    <div class="input-group clockpicker">
                                                        <input type="text" name="jam_akhir" class="form-control" required> <span class="input-group-addon"> <i class="glyphicon glyphicon-time"></i> </span>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="booking" class="btn btn-danger waves-effect waves-light">Booking</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
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

                