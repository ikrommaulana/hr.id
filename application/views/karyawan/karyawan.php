
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
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>karyawan/add_edit_data/">
                                                        <div class="row">
                                                            <h3 class="box-title m-b-0" style="font-weight: normal;">Pengajuan Karyawan Baru</h3><br><br>
                                                        </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="number" id="input13" required name="jumlah" value="" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Jumlah</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="text" id="input14" required name="persyaratan" value="" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input14">Persyaratan</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input15" required name="departemen">
                                                                      <option value=""></option>
                                                                      <?php
                                                                       $id_div = $user[0]->id_division;
                                                                       $admin_role = $user[0]->admin_role;
                                                                       if($admin_role==1){
                                                                          $data_dep = $this->db->query("SELECT * FROM division WHERE status='enable'")->result();
                                                                          foreach($data_dep as $view){?>  
                                                                            <option value="<?=$view->id_division;?>"><?=$view->division_name;?></option>
                                                                       <?php }}else{
                                                                          $data_dep = $this->db->query("SELECT * FROM division WHERE status='enable'")->result();
                                                                          foreach($data_dep as $view){?>  
                                                                            <option value="<?=$view->id_division;?>"><?=$view->division_name;?></option> 
                                                                        
                                                                       
                                                                      <?php }}?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input15">Departemen</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input15" required name="posisi">
                                                                      <option value=""></option>
                                                                      <?php $data_jb = $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan DESC")->result();
                                                                          foreach($data_jb as $view){?>  
                                                                            <option value="<?=$view->id_jabatan;?>"><?=$view->nama_jabatan;?></option>
                                                                      <?php }?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input16">Posisi</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input15" required name="status_kerja">
                                                                      <option value=""></option>
                                                                      <option value="Freelance">Freelance</option>
                                                                      <option value="Probation">Probation</option>
                                                                      <option value="Contract">Contract</option>
                                                                      <option value="Permanent">Permanent</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input15">Status Kerja</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input15" required name="budget">
                                                                      <option value=""></option>
                                                                      <option value="Budgeted">Budgeted</option>
                                                                      <option value="Unbadgeted">Unbadgeted</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input15">Budget</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="number" id="input13" required name="salary" value="" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Salary</label>
                                                              </div>
                                                          </div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Ajukan</button>
                                                          <a href="<?=base_url()?>Karyawan" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
                                                        </form>
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