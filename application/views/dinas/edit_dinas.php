<?php
  $id_dinas = $data_dinas[0]->id_dinas;
  $start_date = (empty($data_dinas)) ? ' ' : $data_dinas[0]->start_date;
  $end_date = (empty($data_dinas)) ? ' ' : $data_dinas[0]->end_date;
  $keperluan = (empty($data_dinas)) ? ' ' : $data_dinas[0]->keperluan;
  $id_negara = (empty($data_dinas)) ? 0 : $data_dinas[0]->id_tujuan_negara;
?>
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
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>dinas/update_dinas_act/<?=$id_dinas;?>">
                                                        <div class="row">
                                                            <h3 class="box-title m-b-0" style="font-weight: normal;">Pengajuan Perjalanan Dinas</h3><br><br>
                                                        </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control input-daterange-datepicker" type="text" id="input12" required name="tanggal" value="<?$start_date.'-'.$end_date;?>"/  onchange="return tgl();"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input12">Tanggal</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="text" id="input13" required name="keperluan" value="<?=$keperluan;?>" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Keperluan</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input5" required name="jenis_perjalanan" onchange="return jenis();">
                                                                        <option value=""></option>
                                                                        <option value="0" <?php if($id_negara==0){echo 'selected';}?>>Domestik</option>
                                                                        <option value="1" <?php if($id_negara==1){echo 'selected';}?>>Luar Negeri</option>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input5">Janis Perjalanan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6" id="check_data1">

                                                              </div> 
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6" id="check_data">

                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6" id="check_data2">

                                                              </div>
                                                          </div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Update</button>
                                                          <a href="<?=base_url()?>dinas" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
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
                <script type="text/javascript">
                  function provinsi(){
                      id = $("#input15").val();
                      $.get( "<?= base_url();?>dinas/data_provinsi" , { option : id } , function ( data ) {
                          $( '#check_data' ) . html ( data ) ;

                        } ) ;
                  }
                </script>

                <script type="text/javascript">
                  function jenis(){
                      id = $("#input5").val();
                      $.get( "<?= base_url();?>dinas/data_jenis" , { option : id } , function ( data ) {
                          $( '#check_data1' ) . html ( data ) ;

                        } ) ;
                  }
                </script>

                <script type="text/javascript">
                  function tgl(){
                      id = $("#input12").val();
                      $.get( "<?= base_url();?>dinas/data_tgl" , { option : id } , function ( data ) {
                          $( '#check_data2' ) . html ( data ) ;

                        } ) ;
                  }
                </script>