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
                            <a href="<?=base_url()?>cuti" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-reply"></i> </a>
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
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>cuti/add_edit_data/<?=$id_cuti;?>">
                                                        
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input3" name="jenis_cuti" required value="<?php if($data_cuti!=''){echo $data_cuti[0]->jenis_cuti;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input3">Jenis Cuti</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="number" class="form-control" id="input4" name="jumlah" required value="<?php if($data_cuti!=''){echo $data_cuti[0]->jumlah;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input4">Jumlah</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="number" class="form-control" id="input5" name="batas_pengajuan" required value="<?php if($data_cuti!=''){echo $data_cuti[0]->batas_pengajuan;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input5">Batas Pengajuan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="number" class="form-control" id="input6" name="approval_level" required value="<?php if($data_cuti!=''){echo $data_cuti[0]->approval_level;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input6">Level Persetujuan</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input51" name="description" required value="<?php if($data_cuti!=''){echo $data_cuti[0]->description;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input51">Keterangan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input551" required name="parent">
                                                                        <option value=""></option>
                                                                        <option value="Izin" <?php if($data_cuti!=0){if($data_cuti[0]->parent=='Izin'){echo 'selected';}}?>>Izin</option>
                                                                        <option value="Cuti" <?php if($data_cuti!=0){if($data_cuti[0]->parent=='Cuti'){echo 'selected';}}?>>Cuti</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input551">Parent</label>
                                                              </div>
                                                          </div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Simpan</button>
                                                          <a href="<?=base_url()?>cuti" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
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