
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
                        <?php if($role_id==1){?>
                            <a href="<?=base_url()?>document/add_edit_data/" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-plus"></i> </a>
                            <?php }?>
                            <li><a href="javascript:void(0)">Dokumen</a></li>
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
                                            <th>Nama Dokumen</th>
                                            <th>No Dokumen</th>
                                            <th>Type File</th>
                                            <th>Tanggal Upload</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_dokumen as $view){
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->document_name;?></td>
                                            <td><?=$view->document_no;?></td>
                                            <td><?=$view->document_type;?></td>
                                            <td><?php $tanggal = strtotime($view->created_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url();?>assets/document_file/<?=$view->file_name;?>" class="btn btn-mini" title="Download Document"><i class="icon-arrow-down"></i></a>
                                                <?php if($role_id==1){?>
                                                <a href="<?=base_url()?>document/delete_data/<?=$view->id_document;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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