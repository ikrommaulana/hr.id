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
                            <a href="<?=base_url()?>employee" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-reply"></i> </a>
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
                <?php if($data_employee!=0){?>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                      <script>
                      $(document).ready(function(){
                          $("li").removeClass("disabled");
                      });
                      </script>
                      <script>
                      $(document).ready(function(){
                          $("#1").click(function(){
                              $("#satu").addClass("active");
                              $("#1").addClass("current");
                              $("#dua").removeClass("active");
                              $("#2").removeClass("current");
                              $("#tiga").removeClass("active");
                              $("#3").removeClass("current");
                              $("#empat").removeClass("active");
                              $("#4").removeClass("current");
                          });
                          $("#2").click(function(){
                              $("#dua").addClass("active");
                              $("#2").addClass("current");
                              $("#satu").removeClass("active");
                              $("#1").removeClass("current");
                              $("#tiga").removeClass("active");
                              $("#3").removeClass("current");
                              $("#empat").removeClass("active");
                              $("#4").removeClass("current");
                          });
                          $("#3").click(function(){
                              $("#tiga").addClass("active");
                              $("#3").addClass("current");
                              $("#satu").removeClass("active");
                              $("#1").removeClass("current");
                              $("#dua").removeClass("active");
                              $("#2").removeClass("current");
                              $("#empat").removeClass("active");
                              $("#4").removeClass("current");
                          });
                          $("#4").click(function(){
                              $("#empat").addClass("active");
                              $("#4").addClass("current");
                              $("#satu").removeClass("active");
                              $("#1").removeClass("current");
                              $("#dua").removeClass("active");
                              $("#2").removeClass("current");
                              $("#tiga").removeClass("active");
                              $("#3").removeClass("current");
                          });
                      });
                      </script>
                <?php }?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0" style="font-weight: normal;"><?=$title;?></h3><br>
                            <div id="exampleBasic2" >
                                <ul class="wizard-steps" role="tablist">
                                    <li class="<?php if($pass==''){echo 'active';}?>" role="tab" id="1">
                                        <h4><span><i class="ti-user"></i></span>Data Pribadi</h4> </li>
                                    <li role="tab" id="2">
                                        <h4><span><i class="ti-home"></i></span>Perusahaan</h4> </li>
                                    <li role="tab" id="3"  class="<?php if($pass!=''){echo 'active';}?>">
                                        <h4><span><i class="ti-lock"></i></span>Akun User</h4> </li>
                                    <li role="tab" id="4">
                                        <h4><span><i class="ti-money"></i></span>Keuangan</h4> </li>
                                </ul>
                                <div class="wizard-content">
                                    <div id="satu" class="wizard-pane <?php if($pass==''){echo 'active';}?>" role="tabpanel">
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>employee/add_edit_data/<?=$id_employee;?>" enctype="multipart/form-data">
                                                        <?php 
                                                          $data = $this->db->query("SELECT * FROM employee ORDER BY id_employee DESC")->result();
                                                          $last_nik = $data[0]->nik;
                                                          $no_urut = substr($last_nik, 12);
                                                          $no_urut_new = $no_urut + 1;
                                                          $jml = count($no_urut_new);
                                                          if($jml==1){
                                                              $nol = '00';
                                                          }elseif($jml==2){
                                                            $nol = '0';
                                                          }else{
                                                            $nol = '';
                                                          }
                                                        ?>
                                                          <div class="row">
                                                              <!--<div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input1" name="nik" readonly value="<?='LIB/'.date('mY').'/'.$nol.''.$no_urut_new;?>"><span class="highlight"></span> <span class="bar"></span>
                                                              </div>-->
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input290" name="nik" required value="<?php if($data_employee!=0){echo $data_employee[0]->nik;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input290">NIK</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input2" name="nama" required value="<?php if($data_employee!=0){echo $data_employee[0]->firstname;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input2">Nama</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input3" name="tempat_lahir" required value="<?php if($data_employee!=0){echo $data_employee[0]->place_birth;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input3">Tempat Lahir</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control mydatepicker" id="input4" name="tanggal_lahir" required value="<?php if($data_employee!=0){ if($data_employee[0]->date_birth!='0000-00-00'){echo $data_employee[0]->date_birth;}}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input4">Tanggal Lahir</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input5" required name="jenis_kelamin">
                                                                        <option value=""></option>
                                                                        <option value="0" <?php if($data_employee!=0){if($data_employee[0]->gender==0){echo 'selected';}}?>>Wanita</option>
                                                                        <option value="1" <?php if($data_employee!=0){if($data_employee[0]->gender==1){echo 'selected';}}?>>Laki-Laki</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input5">Janis kelamin</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input6" required name="agama">
                                                                        <option value=""></option>
                                                                        <option value="Islam" <?php if($data_employee!=0){if($data_employee[0]->religion=='Islam'){echo 'selected';}}?>>Islam</option>
                                                                        <option value="Kristen Protestan" <?php if($data_employee!=0){if($data_employee[0]->religion=='Kristen Protestan'){echo 'selected';}}?>>Kristen Protestan</option>
                                                                        <option value="Kristen Katolik" <?php if($data_employee!=0){if($data_employee[0]->religion=='Kristen Katolik'){echo 'selected';}}?>>Kristen Katolik</option>
                                                                        <option value="Hindu" <?php if($data_employee!=0){if($data_employee[0]->religion=='Hindu'){echo 'selected';}}?>>Hindu</option>
                                                                        <option value="Budha" <?php if($data_employee!=0){if($data_employee[0]->religion=='Budha'){echo 'selected';}}?>>Budha</option>
                                                                        <option value="Kongwucu" <?php if($data_employee!=0){if($data_employee[0]->religion=='Kongwucu'){echo 'selected';}}?>>Kongwucu</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input6">Agama</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input7" name="no_kk" required value="<?php if($data_employee!=0){echo $data_employee[0]->no_kk;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input7">No KK</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input8" name="no_ktp" required value="<?php if($data_employee!=0){echo $data_employee[0]->identity_no;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input8">KTP</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control mydatepicker" id="input9" name="tgl_ktp" required value="<?php if($data_employee!=0){ if($data_employee[0]->expired_date!='0000-00-00'){echo $data_employee[0]->expired_date;}}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input9">Tanggal Berlaku KTP</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input10" name="no_hp" required value="<?php if($data_employee!=0){echo $data_employee[0]->mobile_phone;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input10">No Handphone</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input20" name="alamat" required value="<?php if($data_employee!=0){echo $data_employee[0]->address;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input20">Alamat</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                <input type="number" class="form-control" id="input20" name="id_absensi" required value="<?php if($data_employee!=0){echo $data_employee[0]->id_absensi;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input20">ID Absensi</label>
                                                              </div>
                                                          </div>
                                                          <?php if($data_employee!=0){?>
                                                          <div class="row" style="margin:0px 0 -40px -20px">
                                                              <div class="col-sm-6">
                                                                  <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save" onclick="return check()">Simpan</button>
                                                              </div>
                                                              <div class="col-sm-6"></div>
                                                          </div>
                                                          <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div id="dua" class="wizard-pane" role="tabpanel">
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="floating-labels ">
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input11" required name="jabatan">
                                                                      <option value=""></option>
                                                                      <?php foreach($data_jabatan as $view){?>
                                                                        <option value="<?=$view->id_jabatan;?>" <?php if($data_employee!=0){if($data_employee[0]->id_position==$view->id_jabatan){echo 'selected';}}?>><?=$view->nama_jabatan;?></option>
                                                                      <?php } ?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input11">Jabatan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input12" required name="departemen">
                                                                      <option value=""></option>
                                                                      <?php foreach($data_divisi as $view){?>
                                                                        <option value="<?=$view->id_division;?>" <?php if($data_employee!=0){if($data_employee[0]->id_division==$view->id_division){echo 'selected';}}?>><?=$view->division_name;?></option>
                                                                      <?php } ?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input12">Departemen</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control mydatepicker" id="input18" name="tgl_bergabung" required value="<?php if($data_employee!=0){ if($data_employee[0]->join_date!='0000-00-00'){echo $data_employee[0]->join_date;}}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input18">Tanggal Bergabung</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input22" onchange="return status();" required name="status_karyawan">
                                                                      <option value=""></option>
                                                                      <option value="0" <?php if($data_employee!=0){if($data_employee[0]->employee_status==0){echo 'selected';}}?>>Permanent</option>
                                                                      <option value="1" <?php if($data_employee!=0){if($data_employee[0]->employee_status==1){echo 'selected';}}?>>Contract</option>
                                                                      <option value="2" <?php if($data_employee!=0){if($data_employee[0]->employee_status==2){echo 'selected';}}?>>Probation</option>
                                                                      <option value="3" <?php if($data_employee!=0){if($data_employee[0]->employee_status==3){echo 'selected';}}?>>Resign</option>
                                                                      <option value="4" <?php if($data_employee!=0){if($data_employee[0]->employee_status==4){echo 'selected';}}?>>Fired</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input29">Status Karyawan</label>
                                                              </div>
                                                        </div>
                                                        <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6" id="check_data">
                                                                  
                                                              </div>
                                                          </div>
                                                          <?php if($data_employee!=0){?>
                                                          <div class="row" style="margin:0px 0 -40px -20px">
                                                              <div class="col-sm-6">
                                                                  <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save" onclick="return check()">Simpan</button>
                                                              </div>
                                                              <div class="col-sm-6"></div>
                                                          </div>
                                                          <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div id="tiga" class="wizard-pane <?php if($pass!=''){echo 'active';}?>" role="tabpanel">
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="floating-labels ">
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input13" name="email" required value="<?php if($data_employee!=0){echo $data_employee[0]->email;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Email</label>
                                                              </div>
                                                              
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <a href="<?=base_url()?>employee/buat_password/<?=$id_employee;?>" class="btn btn-info">buat password</a>
                                                                  <input type="text" class="form-control" id="input14" name="password" required value="<?php if($data_employee!=0){ if($pass==''){echo '**********';}else{echo $pass;}}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input14">Password</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input21" required name="hak_akses">
                                                                      <option value=""></option>
                                                                      <?php foreach($data_privileges as $view){?>
                                                                        <option value="<?=$view->id_privileges;?>" <?php if($data_employee!=0){if($data_employee[0]->id_privileges==$view->id_privileges){echo 'selected';}}?>><?=$view->privileges_name;?></option>
                                                                      <?php } ?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input21">Hak Akses</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <h3 style="color: #fff">n</h3>
                                                              </div>
                                                          </div>

                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <p>Photo Profile</p>
                                                                  <input type="file" name="image"/>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                              </div>
                                                          </div>

                                                          <?php if($data_employee!=0){?>
                                                          <div class="row" style="margin:0px 0 -40px -20px">
                                                              <div class="col-sm-6">
                                                                  <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save" onclick="return check()">Simpan</button>
                                                              </div>
                                                              <div class="col-sm-6"></div>
                                                          </div>
                                                          <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div id="empat" class="wizard-pane" role="tabpanel">
                                          <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="floating-labels ">
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input15" name="nama_bank" required value="<?php if($data_employee!=0){echo $data_employee[0]->nama_bank;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input15">Nama Bank</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input16" name="no_rek" required value="<?php if($data_employee!=0){echo $data_employee[0]->no_rek;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input16">No Rekening</label>
                                                              </div>
                                                          </div>
                                                          <div class="row" style="margin-bottom: -80px">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input17" name="gaji_pokok" required><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input17">Gaji Pokok</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                              </div>
                                                          </div>  
                                                    </div>
                                                </div>
                                                <div class="row" style="margin:120px 0 -40px -20px">
                                                    <div class="col-sm-6">
                                                        <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save" onclick="return check()">Simpan</button>
                                                        <a href="<?=base_url()?>employee" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
                                                    </div>
                                                    <div class="col-sm-6"></div>
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
                  function buat_password(){
                      $.get( "<?= base_url();?>employee/buat_password" , function ( data ) {
                          $( '#buat_password' ) . html ( data ) ;
                        } ) ;
                  }
                </script>
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