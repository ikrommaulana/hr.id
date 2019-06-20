
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        
        <div id="page-wrapper">
            <div class="container-fluid">
            
                <br><br>
                <?=$this->session->flashdata('notifikasi')?>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                
                <!--row -->
                <?php foreach($data_meeting_room as $view){
                    if($view->id_meeting_room==4){
                        $bg = 'success';
                        $bg2 = '';
                    }elseif($view->id_meeting_room==3){
                        $bg = 'info';
                        $bg2 = '';
                    }elseif($view->id_meeting_room==2){
                        $bg = 'warning';
                        $bg2 = '#F8E6E0';
                    }else{
                        $bg = 'default';
                        $bg2 = '';
                    }
                    $skr = date('Y-m-d');
                    $data_agenda = $this->db->query("SELECT * FROM meeting_room_booking WHERE id_meeting_room='$view->id_meeting_room' AND meeting_date='$skr'")->result();
                    ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box" style="background-color: <?=$bg2;?>">
                            <div class="row row-in">
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-<?=$bg;?> "><i class="ti-layout-column2"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="text-right m-t-15"></h3>
                                        </li>
                                        <li class="col-middle">
                                            <h4><?=$view->room_name;?></h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-<?=$bg;?>" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-sm-6 row-in-br  b-r-none">
                                    <ul class="col-in">
                                        <li>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="text-right m-t-15"></h3>
                                        </li>
                                        <li class="col-middle">
                                            <h4>Kapasitas</h4>
                                            <h3 class="text-right m-t-15" style="color: #000"><?=$view->capacity;?></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                        <li class="col-middle">
                                            <h4>Fasilitas</h4>
                                            <p style="color: #000"><?=$view->facility;?></p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <ul class="col-in">
                                        <li class="col-middle">
                                            <h4>Agenda Hari Ini</h4>
                                                <!-- START carousel-->
                                                <div id="carousel-example-captions" data-ride="carousel" class="carousel slide" style="width: 300%">
                                                    <div role="listbox" class="carousel-inner">
                                                        <?php $no=1; foreach($data_agenda as $view){?>
                                                        <div class="item <?php if($no==1){echo 'active';};?>">
                                                            <?=$view->description;?> <span style="margin-left: 30px"><span style="color: #dedede">|</span> <?=$view->meeting_start.' - '.$view->meeting_end;?></span>
                                                        </div>
                                                        <?php $no++;}?>
                                                    </div>
                                                    <a href="#carousel-example-captions" role="button" data-slide="prev"> <span aria-hidden="true" class="fa fa-angle-left"></span> <span class="sr-only">Previous</span> </a>
                                                    <a href="#carousel-example-captions" role="button" data-slide="next"> <span aria-hidden="true" class="fa fa-angle-right"></span> <span class="sr-only">Next</span> </a>
                                                </div>
                                                <!-- END carousel-->
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-sm-6  b-0">
                                    <ul class="col-in">
                                        <li class="col-middle" style="padding-top: 30px">
                                            <a href="<?=base_url()?>booking/daftar/<?=$view->id_meeting_room;?>"
                                            class="btn btn-block btn-outline btn-rounded btn-default"
                                            style="width:160px">Detail</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row -->
                <?php }?> 
                <style type="text/css">
                    .popover{
                        z-index: 9999;
                    }
                </style>

                <?php foreach($data_meeting_room as $view){?>
                
                <div class="row" style="z-index: 9000">
                    <div class="col-md-4">
                            <!-- sample modal content -->
                            <!-- /.modal -->
                            <div id="mymodal<?=$view->id_meeting_room;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <form method="post" action="<?=base_url()?>booking/add_edit_data_booking/<?=$view->id_meeting_room;?>">
                                <input type="hidden" name="id_meeting_room<?=$view->id_meeting_room;?>" value="<?=$view->id_meeting_room;?>">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="padding:30px">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="info" style="color:#999">Booking <?=$view->room_name;?></h4> 
                                        </div>
                                        <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Keterangan :</label>
                                                    <input type="text" name="keterangan<?=$view->id_meeting_room;?>" class="form-control room-name" id="recipient-name" required> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Tanggal :</label>
                                                    <div class="input-group">
                                                        <input type="text" name="tanggal<?=$view->id_meeting_room;?>" class="form-control mydatepicker" required> <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Jam Mulai :</label>
                                                    <div class="input-group">
                                                        <input type="text" id="#single-input" class="form-control clockpicker" name="jam_mulai<?=$view->id_meeting_room;?>" required> <span class="input-group-addon"> <i class="glyphicon glyphicon-time"></i> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Jam Selesai:</label>
                                                    <div class="input-group clockpicker">
                                                        <input type="text" data-placement="top" data-align="top" name="jam_akhir<?=$view->id_meeting_room;?>" class="form-control"  required> <span class="input-group-addon"> <i class="glyphicon glyphicon-time"></i> </span>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="<?=$view->id_meeting_room;?>" class="btn btn-danger waves-effect waves-light">Booking</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                    </div>
                </div>
                
                <?php }?>
                   

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