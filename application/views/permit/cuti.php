<?php
  if($data_permit!=''){
    $id_permit = $data_permit[0]->id_permit;
    $id_cuti   = $data_permit[0]->id_cuti;
    $tgl = substr($data_permit[0]->start_date,5,6).'/'.substr($data_permit[0]->start_date,8,9).'/'.substr($data_permit[0]->start_date,0,4).' - '.substr($data_permit[0]->end_date,5,6).'/'.substr($data_permit[0]->end_date,8,9).'/'.substr($data_permit[0]->end_date,0,4);
    $keterangan = $data_permit[0]->keterangan;
    $keperluan = $data_permit[0]->reason;
  }else{
    $id_permit = '';
    $id_cuti   = '';
    $tgl = '';
    $keterangan = '';
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
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>permit_/add_edit_data/<?=$id_permit;?>">
                                                        <div class="row">
                                                            <h3 class="box-title m-b-0" style="font-weight: normal;">Pengajuan Cuti</h3><br><br>
                                                        </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input11" required name="jenis_cuti" onchange="return cuti();">
                                                                      <option value=""></option>
                                                                      <?php foreach($data_cuti as $view){?>
                                                                      <option value="<?=$view->id_cuti;?>" <?php if($id_cuti==$view->id_cuti){echo 'selected';};?>><?=$view->jenis_cuti;?></option>
                                                                      <?php }?>
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input3">Jenis Cuti</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control input-daterange-datepicker" type="text" id="input12" required value="<?=$tgl;?>" name="tanggal" onchange="return tgl();"/><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input12">Tanggal</label>
                                                                   <span style="font-size: 12px; color: red" id="check_data"></span>
                                                              </div>
                                                          </div>
                                                          <?php
                                                            $sehari = $this->session->userdata('sehari');
                                                          ?>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <select class="form-control p-0" id="input7" required name="keterangan">
                                                                      <option value=""></option>
                                                                      <option value="Sehari Penuh" <?php if($keterangan=='Sehari Penuh'){echo 'selected';};?>>Sehari Penuh</option>
                                                                      
                                                                      <option value="Hanya Pagi" <?php if($keterangan=='Hanya Pagi'){echo 'selected';};?>>Hanya Pagi</option>
                                                                      <option value="Hanya Sore" <?php if($keterangan=='Hanya Sore'){echo 'selected';};?>>Hanya Sore</option>
                                                                      
                                                                  </select><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input7">Keterangan</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input class="form-control" type="text" id="input13" required name="keperluan" value="<?=$keperluan;?>" /><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input13">Keperluan</label>
                                                              </div>
                                                          </div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Ajukan</button>
                                                          <a href="<?=base_url()?>permit_" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
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
                  function cuti(){
                      id = $("#input11").val();
                      $.get( "<?= base_url();?>permit_/data_cuti" , { option : id } , function ( data ) {
                          $( '#check_data' ) . html ( data ) ;

                        } ) ;
                  }
                </script>
                <script type="text/javascript">
                  function tgl(){
                      id = $("#input12").val();
                      $.get( "<?= base_url();?>permit_/jumlah_cuti" , { option : id } , function ( data ) {
                          $( '#check_data' ) . html ( data ) ;

                        } ) ;
                  }
                </script>
                <script>
    // Clock pickers
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
    // Colorpicker
    $(".colorpicker").asColorPicker();
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: "09/20/2017",
        maxDate: "09/09/2020",
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 30
        }
    });
    </script>