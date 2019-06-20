<?php
  if($data_piket!=''){
    $id_piket = $data_piket[0]->id_piket;
    $tgl = substr($data_piket[0]->start_date,5,6).'/'.substr($data_piket[0]->start_date,8,9).'/'.substr($data_piket[0]->start_date,0,4).' - '.substr($data_piket[0]->end_date,5,6).'/'.substr($data_piket[0]->end_date,8,9).'/'.substr($data_piket[0]->end_date,0,4);
    $keperluan = $data_piket[0]->keperluan;
  }else{
    $id_piket = '';
    $tgl = '';
    $keperluan = '';
  }

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
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>piket/add_edit_data/<?=$id_piket;?>">
                                                        <div class="row">
                                                            <h3 class="box-title m-b-0" style="font-weight: normal;">Pengajuan Piket</h3>
                                                            <p style="color: #000">Ket : hanya dapat diambil atas persetujuan atasan dan diwaktu libur atau tanggal merah</p><br><br>
                                                        </div>
                                                          <div class="row">
                                                              <?php if($id_jabatan==4){// manager
                                                                        $staff = $this->db->query("SELECT * FROM employee WHERE id_division='$id_division' ORDER BY firstname ASC")->result();
                                                                    }elseif($id_jabatan==5 || $id_jabatan==11){
                                                                        $staff = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
                                                                    }
                                                                    ?> 
                                                                <div class="form-group m-b-40 col-sm-6">
                                                                    <select class="form-control p-0" id="input6" required name="nama">
                                                                        <option value=""></option>
                                                                        <?php if($staff){foreach($staff as $view){?>
                                                                        <option value="<?=$view->id_employee;?>"><?=$view->firstname;?></option>
                                                                        <?php }}?>
                                                                    </select><span class="highlight"></span> <span class="bar"></span>
                                                                    <label for="input6">Nama</label>
                                                                </div>
                                                                <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control input-daterange-datepicker" type="text" id="input12" required name="tanggal" value="<?=$tgl;?>" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input12">Tanggal</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="text" id="input13" required name="keperluan" value="<?=$keperluan;?>" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Uraian pekerjaan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                    <select class="form-control p-0" id="input66" required name="jenis_piket">
                                                                        <option value="0">Dalam Kantor</option>
                                                                        <option value="1">Luar Kantor</option>
                                                                    </select><span class="highlight"></span> <span class="bar"></span>
                                                                    <label for="input66">Jenis Piket</label>
                                                                </div>
                                                          </div>
                                                          <!--<div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="text" id="input13" required name="keperluan" value="<?=$keperluan;?>" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Uraian pekerjaan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select name="jum_todo" id="jml" class="form-control" onchange="return jml();">
                                                                        </option value="0">- Jumlah -</option>
                                                                        <?php
                                                                        for($i=1;$i<=10;$i++){
                                                                          if($this->input->post('jml')==$i){
                                                                            echo "<option value=".$i." selected>".$i."</option>";
                                                                          }else{
                                                                            echo "<option value=".$i.">".$i."</option>";
                                                                          }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                              </div>-->
                                                          </div>
                                                          <div class="row" id="check_data"></div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Ajukan</button>
                                                          <a href="<?=base_url()?>piket" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
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
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script type="text/javascript">
                    function jml(){
                        id = $("#jml").val();
                        $.get( "<?= base_url(); ?>piket/uraian" , { option : id } , function ( data ) {
                            $( '#check_data' ) . html ( data ) ;
                          } ) ;
                    }
                </script>