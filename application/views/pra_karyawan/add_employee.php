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
                            <a href="<?=base_url()?>pra_karyawan" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-reply"></i> </a>
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
                            <div id="exampleBasic2" class="wizard">
                                <ul class="wizard-steps" role="tablist">
                                    <li class="active" role="tab">
                                        <h4><span><i class="ti-user"></i></span>Data Pribadi</h4> </li>
                                </ul>
                                <div class="wizard-content">
                                    <div class="wizard-pane active" role="tabpanel">
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>pra_karyawan/add_edit_data/">
                                                        
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input2" name="nama" required value="<?php if($data_employee!=0){echo $data_employee[0]->firstname;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input2">Nama</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input5" required name="jenis_kelamin">
                                                                        <option value=""></option>
                                                                        <option value="0" <?php if($data_employee!=0){if($data_employee[0]->gender==0){echo 'selected';}}?>>Wanita</option>
                                                                        <option value="1" <?php if($data_employee!=0){if($data_employee[0]->gender==1){echo 'selected';}}?>>Laki-Laki</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input5">Jenis kelamin</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input100" name="email" required value="<?php if($data_employee!=0){echo $data_employee[0]->email;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input100">Email</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input10" name="no_hp" required value="<?php if($data_employee!=0){echo $data_employee[0]->phone;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input10">No Handphone</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input11" required name="jabatan">
                                                                      <option value=""></option>
                                                                      <?php foreach($data_jabatan as $view){?>
                                                                        <option value="<?=$view->id_jabatan;?>" <?php if($data_employee!=0){if($data_employee[0]->id_jabatan=='$view->id_jabatan'){echo 'selected';}}?>><?=$view->nama_jabatan;?></option>
                                                                      <?php } ?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input11">Jabatan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input12" required name="departemen">
                                                                      <option value=""></option>
                                                                      <?php foreach($data_divisi as $view){?>
                                                                        <option value="<?=$view->id_division;?>" <?php if($data_employee!=0){if($data_employee[0]->id_division=='$view->id_division'){echo 'selected';}}?>><?=$view->division_name;?></option>
                                                                      <?php } ?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input12">Departemen</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input12" required name="status">
                                                                      <option value=""></option>
                                                                        <option value="Menunggu" <?php if($data_employee!=0){if($data_employee[0]->status=='$view->id_status'){echo 'selected';}}?>>Menunggu</option>
                                                                        <option value="Sedang diproses" <?php if($data_employee!=0){if($data_employee[0]->status=='$view->id_status'){echo 'selected';}}?>>Sedang diproses</option>
                                                                        <option value="Diterima" <?php if($data_employee!=0){if($data_employee[0]->status=='$view->id_status'){echo 'selected';}}?>>Diterima</option>
                                                                        <option value="Ditolak" <?php if($data_employee!=0){if($data_employee[0]->status=='$view->id_status'){echo 'selected';}}?>>Ditolak</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input20">Status</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                              </div>
                                                          </div>

                                                <div class="row" style="margin:120px 0 -40px -20px">
                                                            <div class="col-sm-6">
                                                              <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save" onclick="return check()">Simpan</button>
                                                          <a href="<?=base_url()?>employee" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
                                                          </div>
                                                          <div class="col-sm-6">
                                                              </div>
                                                            </div>
                                            </div>
                                            </form>
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
                <script type="text/javascript">
                  function status(){
                      id = $("#input22").val();
                      $.get( "<?= base_url();?>employee/data_status_karyawan" , { option : id } , function ( data ) {
                          $( '#check_data' ) . html ( data ) ;
                        } ) ;
                  }
                </script>
                <script>
                  function check(){
                    $(".form-control").removeAttr('required');
                    return true;
                  }
                  </script>
<?php }else{
    redirect('error');
}?>