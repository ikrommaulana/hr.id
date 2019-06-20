
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
                            <li><a href="javascript:void(0)">Daftar Pengajuan Piket</a></li>
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
                        <form method="post" action="<?=base_url()?>piket/rekap">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <select class="form-control p-0" id="input15" name="status">
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input class="form-control input-daterange-datepicker" type="text" id="input12" required name="tanggal" value="" style="width: 300px">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" name="filter" class="btn btn-mini" title="Filter"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            </form>
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
                                            <th>ID Piket Approve Dana</th>
                                            <th>ID piket</th>
                                            <th>id approver</th>
                                            <th>token</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php 
                                                $no=1; foreach($data_piket as $view){
                                                ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->id_piket_approve_dana;?></td>
                                            <td><?=$view->id_piket;?></td>
                                            <td><?=$view->id_approver;?></td>
                                            <td><?=$view->token;?></td>
                                            <td><?=$view->status;?></td>
                                            <td><?=$view->approve_date;?></td>
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
