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
                            <?php if($role_id==1){?>
                            <a href="<?=base_url()?>document" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-reply"></i> </a>
                            <?php }?>
                            <li><a href="javascript:void(0)">Kembali</a></li>
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
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0" style="font-weight: normal;"><?=$title;?></h3><br>
                            <div>
                                <div class="wizard-content">
                                    <div>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>document/add_edit_data/<?=$id_document;?>" enctype="multipart/form-data">
                                                        
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input3" name="document_name" required value="<?php if($data_dokumen!=''){echo $data_dokumen[0]->document_name;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input3">Nama Dokumen</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input4" name="document_no" required value="<?php if($data_dokumen!=''){echo $data_dokumen[0]->document_no;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input4">No Dokumen</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                <div class="white-box">
                                                                    <input type="file" id="input-file-now" name="docfile" /> 
                                                                </div>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  
                                                              </div>
                                                          </div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Simpan</button>
                                                          <a href="<?=base_url()?>document" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
                                                        </form>
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
                <?php }else{
    redirect('error');
}?>