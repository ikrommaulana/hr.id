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
                            <li><a href="javascript:void(0)">Lock Backdate</a></li>
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
                            <h3 class="box-title m-b-0" style="font-weight: normal;">Data Export</h3>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pengajuan</th> 
                                            <th>Status</th>
                                            <th>Last Update</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_lock as $view){
                                            $status = $view->status;
                                            $update_date = $view->updated_date;
                                            if($status==1){
                                                $stat = 'Lock';
                                                $class = 'danger';
                                            }else{
                                                $stat = 'Unlock';
                                                $class = 'success';
                                            }
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->jenis_pengajuan;?></td>
                                            <td><button class="btn btn-<?=$class;?>"><?=$stat;?></button></td>
                                            <td><?php $tanggal = strtotime($update_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td>
                                                <div class="btn-group">
                                                <?php if($status==0){?>
                                                <a href="<?=base_url()?>lock/lock/<?=$view->lock_id?>" class="btn btn-mini" title="lock"><i class="fa fa-key" style="color: red; font-size: 24px"></i></a>
                                                <?php }elseif($status==1){?>
                                                <a href="<?=base_url()?>lock/unlock/<?=$view->lock_id?>" class="btn btn-mini" title="Unlock"><i class="fa fa-key" style="color: green; font-size: 24px"></i></a>
                                                <?php }?>
                                                </div>
                                            </td>
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