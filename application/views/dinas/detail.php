
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <style type="text/css">
          .ui-group-buttons .or{position:relative;float:left;width:.3em;height:1.3em;z-index:3;font-size:12px}
          .ui-group-buttons .or:before{position:absolute;top:50%;left:50%;content:'';background-color:#999;margin-top:-.1em;margin-left:-.9em;width:1.8em;height:1.8em;line-height:1.55;color:#fff;font-style:normal;font-weight:400;text-align:center;border-radius:500px;-webkit-box-shadow:0 0 0 1px rgba(0,0,0,0.1);box-shadow:0 0 0 1px rgba(0,0,0,0.1);-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;box-sizing:border-box}
          .ui-group-buttons .or:after{position:absolute;top:0;left:0;content:'';width:.3em;height:2.84em;background-color:rgba(0,0,0,0);border-top:.6em solid #999;border-bottom:.6em solid #999}
          .ui-group-buttons .or.or-lg{height:1.3em;font-size:16px}
          .ui-group-buttons .or.or-lg:after{height:2.85em}
          .ui-group-buttons .or.or-sm{height:1em}
          .ui-group-buttons .or.or-sm:after{height:2.5em}
          .ui-group-buttons .or.or-xs{height:.25em}
          .ui-group-buttons .or.or-xs:after{height:1.84em;z-index:-1000}
          .ui-group-buttons{display:inline-block;vertical-align:middle}
          .ui-group-buttons:after{content:".";display:block;height:0;clear:both;visibility:hidden}
          .ui-group-buttons .btn{float:left;border-radius:0}
          .ui-group-buttons .btn:first-child{margin-left:0;border-top-left-radius:.25em;border-bottom-left-radius:.25em;padding-right:15px}
          .ui-group-buttons .btn:last-child{border-top-right-radius:.25em;border-bottom-right-radius:.25em;padding-left:15px}

          .btn3d {
                position:relative;
                top: -6px;
                border:0;
                 transition: all 40ms linear;
                 margin-top:10px;
                 margin-bottom:10px;
                 margin-left:2px;
                 margin-right:2px;
            }
            .btn3d:active:focus,
            .btn3d:focus:hover,
            .btn3d:focus {
                -moz-outline-style:none;
                     outline:medium none;
            }
            .btn3d:active, .btn3d.active {
                top:2px;
            }
            .btn3d.btn-white {
                color: #666666;
                box-shadow:0 0 0 1px #ebebeb inset, 0 0 0 2px rgba(255,255,255,0.10) inset, 0 8px 0 0 #f5f5f5, 0 8px 8px 1px rgba(0,0,0,.2);
                background-color:#fff;
            }
            .btn3d.btn-white:active, .btn3d.btn-white.active {
                color: #666666;
                box-shadow:0 0 0 1px #ebebeb inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,.1);
                background-color:#fff;
            }
            .btn3d.btn-default {
                color: #666666;
                box-shadow:0 0 0 1px #ebebeb inset, 0 0 0 2px rgba(255,255,255,0.10) inset, 0 8px 0 0 #BEBEBE, 0 8px 8px 1px rgba(0,0,0,.2);
                background-color:#f9f9f9;
            }
            .btn3d.btn-default:active, .btn3d.btn-default.active {
                color: #666666;
                box-shadow:0 0 0 1px #ebebeb inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,.1);
                background-color:#f9f9f9;
            }
            .btn3d.btn-primary {
                box-shadow:0 0 0 1px #417fbd inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #4D5BBE, 0 8px 8px 1px rgba(0,0,0,0.5);
                background-color:#4274D7;
            }
            .btn3d.btn-primary:active, .btn3d.btn-primary.active {
                box-shadow:0 0 0 1px #417fbd inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,0.3);
                background-color:#4274D7;
            }
            .btn3d.btn-success {
                box-shadow:0 0 0 1px #31c300 inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #5eb924, 0 8px 8px 1px rgba(0,0,0,0.5);
                background-color:#78d739;
            }
            .btn3d.btn-success:active, .btn3d.btn-success.active {
                box-shadow:0 0 0 1px #30cd00 inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,0.3);
                background-color: #78d739;
            }
            .btn3d.btn-info {
                box-shadow:0 0 0 1px #00a5c3 inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #348FD2, 0 8px 8px 1px rgba(0,0,0,0.5);
                background-color:#39B3D7;
            }
            .btn3d.btn-info:active, .btn3d.btn-info.active {
                box-shadow:0 0 0 1px #00a5c3 inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,0.3);
                background-color: #39B3D7;
            }
            .btn3d.btn-warning {
                box-shadow:0 0 0 1px #d79a47 inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #D79A34, 0 8px 8px 1px rgba(0,0,0,0.5);
                background-color:#FEAF20;
            }
            .btn3d.btn-warning:active, .btn3d.btn-warning.active {
                box-shadow:0 0 0 1px #d79a47 inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,0.3);
                background-color: #FEAF20;
            }
            .btn3d.btn-danger {
                box-shadow:0 0 0 1px #b93802 inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #AA0000, 0 8px 8px 1px rgba(0,0,0,0.5);
                background-color:#D73814;
            }
            .btn3d.btn-danger:active, .btn3d.btn-danger.active {
                box-shadow:0 0 0 1px #b93802 inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,0.3);
                background-color: #D73814;
            }
            .btn3d.btn-magick {
                color: #fff;
                box-shadow:0 0 0 1px #9a00cd inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #9823d5, 0 8px 8px 1px rgba(0,0,0,0.5);
                background-color:#bb39d7;
            }
            .btn3d.btn-magick:active, .btn3d.btn-magick.active {
                box-shadow:0 0 0 1px #9a00cd inset, 0 0 0 1px rgba(255,255,255,0.15) inset, 0 1px 3px 1px rgba(0,0,0,0.3);
                background-color: #bb39d7;
            }
        </style>
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
                <div class="row" style="margin-top: -40px">
                    
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="white-box" style="background-color: #999;">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                <?php $sts = explode(' ', $status);?>
                                  <div class="ui-group-buttons" style="float: right; font-family: monospace; font-size: 8px">
                                      <button type="button" class="btn btn-primary btn-lg"><?=$sts[0];?></button>
                                      <div class="or or-lg"></div>
                                      <button type="button" class="btn btn-success btn-lg"><?=$sts[1];?></button>
                                      </div>
                                  </div>
                            </div>
                            <div>
                                <div class="wizard-content" style="margin-bottom: -30px">
                                    <div>
                                        <div class="row">
                                        
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                          <div class="col-sm-12">
                                                              <div class="white-box p-l-20 p-r-20">
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                          
                                                                          <div class="row">
                                                                              <h2 class="box-title m-b-0">Pengajuan Perjalanan Dinas</h2><br>
                                                                          </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Oleh</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <h5><?=$data_requestor[0]->firstname;?></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Jabatan</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <h5><?=$jabatan.' '.$division;?></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Tanggal Pengajuan</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <h5><?php 
                                                                                    $tanggal1 = strtotime($data_dinas[0]->created_date);$dt = date("d F Y  ", $tanggal1);
                                                                                    echo $dt;?></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Tanggal Diputuskan</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <h5><?php 
                                                                                    if($tgl_diputuskan!=0){
                                                                                        $tanggal1 = strtotime($tgl_diputuskan);$dt = date("d F Y  ", $tanggal1);
                                                                                        echo $dt;
                                                                                    }else{echo '-';}?></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                </div>
                                                                            </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                          <div class="col-sm-12">
                                                              <div class="white-box p-l-20 p-r-20">
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                          <div class="row">
                                                                          </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Tanggal perjalanan</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <h5><?php 
                                                                                        $tanggal1 = strtotime($data_dinas[0]->start_date);$dt = date("d F Y  ", $tanggal1);
                                                                                        $tanggal2 = strtotime($data_dinas[0]->end_date);$dt2 = date("d F Y  ", $tanggal2);
                                                                                        echo $dt.' - '.$dt2;?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Tujuan</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <h5><?=$data_dinas[0]->tujuan;?></h5>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <h5><b>Keperluan</b></h5>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <h5><?=$data_dinas[0]->keperluan;?></h5>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $jumlah_approver = count($data_approver);
                                    for($i=0; $i<$jumlah_approver; $i++){
                                      if($id_employee_login==$data_approver[$i]->id_approver){?>
                                    <form method="post" action="<?=base_url()?>dinas/approve_pengajuan/<?=$data_dinas[0]->id_dinas;?>">
                                    <div class="row">
                                          <button style="line-height: 10px; font-size: 14px" type="submit" name="setuju" class="btn btn-info btn-lg btn3d"><span class="glyphicon glyphicon-check"></span> Setujui</button>
                                          <button style="line-height: 10px; font-size: 14px" type="submit" name="tidak_setuju" class="btn btn-danger btn-lg btn3d"><span class="glyphicon glyphicon-remove"></span> Tidak Setujui</button>
                                    </div>
                                    </form>
                                    <?php }}?>
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
             