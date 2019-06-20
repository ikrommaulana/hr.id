<?php if($role_id==1){
  $access_id = (empty($data_role[0]->access_id)) ? '' : $data_role[0]->access_id;
  $access_name = (empty($data_role[0]->access_name)) ? '' : $data_role[0]->access_name;
  $status = (empty($data_role[0]->status)) ? '' : $data_role[0]->status;
  ?>
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <script type="text/javascript">

    function do_this(name,btn){

        var checkboxes = document.getElementsByClassName(name);
        var button = document.getElementById(btn);

        if(button.value == 'check all'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'uncheck all'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'check all';
        }
    }
</script>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
                  <div class="col-lg-12 main-chart" style="min-height: 490px;">
                      <?=$this->session->flashdata('notifikasi')?>
                  	  <div class="content">
                        <div class="panel panel-default" style="min-height:400px; background:#f1f1f1">
                          <div class="panel-heading">Access</div>
                          <div class="panel-body">
                              <p>Add Access</p>
                              <br>

                          <form action="<?=base_url()?>role/add_edit_data/<?=$access_id;?>" method="post" enctype="multipart/form-data">
                              <div class="row">
                                  <div class="col-sm-6">
                                     <label>Access Name</label>
                                     <input type="text" name="access_name" class="form-control" value="<?=$access_name;?>" required>
                                  </div>
                                  <div class="col-sm-6">
                                  </div>
                              </div><br>

                              <div class="row">
                                  <div class="col-sm-6">
                                     <label>Status</label>
                                     <select class="form-control" name="status" required>
                                        <option value=""> - choose status -</option>
                                          <option <?php if($status==1000){echo 'selected';}?> value="1000"> Enable</option>
                                          <option <?php if($status==1003){echo 'selected';}?> value="1003"> Disable</option>
                                     </select>
                                  </div>
                                  <div class="col-sm-6"></div>
                              </div><br>

                              <label>Privileges</label>
                              <div style="background-color: #fff; padding: 20px 0">
                                <div class="row" style="margin: 0px 50px;">
                                    <h2 style="margin-left: -8px">Modul Master</h2>
                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Calon karyawan</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_pra" value="check all" onClick="do_this('chbox_pra','btn_pra')" />
                                        <div class="checkbox" style="margin-left: -40px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_pra"  class="chbox_pra" value="1" name="view_pra" >
                                               <label for="chbox_pra">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_pra1"  class="chbox_pra" value="1" name="create_pra" >
                                               <label for="chbox_pra1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_pra2"  class="chbox_pra" value="1" name="delete_pra" > 
                                                <label for="chbox_pra2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Karyawan</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_karyawan" value="check all" onClick="do_this('chbox_karyawan','btn_karyawan')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_karyawan" class="chbox_karyawan" value="1" name="view_karyawan" > 
                                               <label for="chbox_karyawan">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_karyawan1" class="chbox_karyawan" value="1" name="create_karyawan"> 
                                                <label for="chbox_karyawan1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_karyawan2" class="chbox_karyawan" value="1" name="delete_karyawan"> 
                                                <label for="chbox_karyawan2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Departemen</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_departemen" value="check all" onClick="do_this('chbox_departemen','btn_departemen')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_departemen" class="chbox_departemen" value="1" name="view_departemen"> 
                                               <label for="chbox_departemen">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_departemen1" class="chbox_departemen" value="1" name="create_departemen"> 
                                               <label for="chbox_departemen1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_departemen2" class="chbox_departemen" value="1" name="delete_departemen"> 
                                                <label for="chbox_departemen2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Jabatan</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_jabatan" value="check all" onClick="do_this('chbox_jabatan','btn_jabatan')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_jabatan" class="chbox_jabatan" value="1" name="view_jabatan" > 
                                               <label for="chbox_jabatan">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox"  id="chbox_jabatan1"  class="chbox_jabatan" value="1" name="create_jabatan" > 
                                                <label for="chbox_jabatan1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_jabatan2"  class="chbox_jabatan" value="1" name="delete_jabatan" > 
                                                <label for="chbox_jabatan2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Cuti</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_cuti" value="check all" onClick="do_this('chbox_cuti','btn_cuti')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_cuti" class="chbox_cuti" value="1" name="view_cuti" > 
                                               <label for="chbox_cuti">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_cuti1" class="chbox_cuti" value="1" name="create_cuti" > 
                                                <label for="chbox_cuti1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_cuti2" class="chbox_cuti" value="1" name="delete_cuti" > 
                                                <label for="chbox_cuti2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Kalender</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_kalender" value="check all" onClick="do_this('chbox_kalender','btn_kalender')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_kalender" class="chbox_kalender" value="1" name="view_kalender" > 
                                               <label for="chbox_kalender">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_kalender1" class="chbox_kalender" value="1" name="create_kalender" > 
                                                <label for="chbox_kalender1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_kalender2" class="chbox_kalender" value="1" name="delete_kalender" > 
                                                <label for="chbox_kalender2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                              <br>

                              <div class="row" style="margin: 0px 50px;">
                                    
                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Kota</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_kota" value="check all" onClick="do_this('chbox_kota','btn_kota')" />
                                        <div class="checkbox" style="margin-left: -40px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_kota"  class="chbox_kota" value="1" name="view_kota" >
                                               <label for="chbox_kota">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_kota1"  class="chbox_kota" value="1" name="create_kota" >
                                               <label for="chbox_kota1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_kota2"  class="chbox_kota" value="1" name="delete_kota" > 
                                                <label for="chbox_kota2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Ruang Meeting</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_meeting" value="check all" onClick="do_this('chbox_meeting','btn_meeting')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_meeting" class="chbox_meeting" value="1" name="view_meeting" > 
                                               <label for="chbox_meeting">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_meeting1" class="chbox_meeting" value="1" name="create_meeting"> 
                                                <label for="chbox_meeting1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_meeting2" class="chbox_meeting" value="1" name="delete_meeting"> 
                                                <label for="chbox_meeting2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Biaya Perjalanan Dinas</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_biaya_dinas" value="check all" onClick="do_this('chbox_biaya_dinas','btn_biaya_dinas')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_biaya_dinas" class="chbox_biaya_dinas" value="1" name="view_biaya_dinas"> 
                                               <label for="chbox_biaya_dinas">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_biaya_dinas1" class="chbox_biaya_dinas" value="1" name="create_biaya_dinas"> 
                                               <label for="chbox_biaya_dinas1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_biaya_dinas2" class="chbox_biaya_dinas" value="1" name="delete_biaya_dinas"> 
                                                <label for="chbox_biaya_dinas2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Holiday</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_holiday" value="check all" onClick="do_this('chbox_holiday','btn_holiday')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_holiday" class="chbox_holiday" value="1" name="view_holiday" > 
                                               <label for="chbox_holiday">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox"  id="chbox_holiday1"  class="chbox_holiday" value="1" name="create_holiday" > 
                                                <label for="chbox_holiday1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_holiday2"  class="chbox_holiday" value="1" name="delete_holiday" > 
                                                <label for="chbox_holiday2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Lock backdate</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_lock" value="check all" onClick="do_this('chbox_lock','btn_lock')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_lock" class="chbox_lock" value="1" name="view_lock" > 
                                               <label for="chbox_lock">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_lock1" class="chbox_lock" value="1" name="create_lock" > 
                                                <label for="chbox_lock1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_lock2" class="chbox_lock" value="1" name="delete_lock" > 
                                                <label for="chbox_lock2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                              <br><hr>

                                <div class="row" style="margin: 0px 50px;">
                                    <h2 style="margin-left: -8px">Modul Menu</h2> 
                                    

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Dokumen</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_file" value="check all" onClick="do_this('chbox_file','btn_file')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_file" class="chbox_file" value="1" name="upload_file"> 
                                               <label for="chbox_file">Upload</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_file1" class="chbox_file" value="1" name="download_file"> 
                                                <label for="chbox_file1">Download</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Laporan</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_laporan" value="check all" onClick="do_this('chbox_laporan','btn_laporan')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_laporan" class="chbox_laporan" value="1" name="view_laporan" > 
                                               <label for="chbox_laporan">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox"  id="chbox_laporan1"  class="chbox_laporan" value="1" name="download_laporan" > 
                                                <label for="chbox_laporan1">Download</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Sync Absen</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_sync" value="check all" onClick="do_this('chbox_sync','btn_sync')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_sync" class="chbox_sync" value="1" name="view_sync" > 
                                               <label for="chbox_sync">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_sync1" class="chbox_sync" value="1" name="create_sync" > 
                                                <label for="chbox_sync1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_sync2" class="chbox_sync" value="1" name="delete_sync" > 
                                                <label for="chbox_sync2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Ruang Meeting</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_booking" value="check all" onClick="do_this('chbox_booking','btn_booking')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_booking" class="chbox_booking" value="1" name="view_booking" > 
                                               <label for="chbox_booking">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_booking1" class="chbox_booking" value="1" name="create_booking" > 
                                                <label for="chbox_booking1">Booking</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Absensi Saya</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_absensi" value="check all" onClick="do_this('chbox_absensi','btn_absensi')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_absensi" class="chbox_absensi" value="1" name="view_absensi" > 
                                               <label for="chbox_absensi">View</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Faq</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_faq" value="check all" onClick="do_this('chbox_faq','btn_faq')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_faq" class="chbox_faq" value="1" name="view_faq"> 
                                               <label for="chbox_faq">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_faq1" class="chbox_faq" value="1" name="create_faq" > 
                                                <label for="chbox_faq1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_faq2" class="chbox_faq" value="1" name="delete_faq" > 
                                                <label for="chbox_faq2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                              <br>

                              <div class="row" style="margin: 0px 50px;">
                                    
                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Setup</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_setup" value="check all" onClick="do_this('chbox_setup','btn_setup')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_setup" class="chbox_setup" value="1" name="view_setup"> 
                                               <label for="chbox_setup">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_setup1" class="chbox_setup" value="1" name="create_setup" > 
                                                <label for="chbox_setup1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_setup2" class="chbox_setup" value="1" name="delete_setup" > 
                                                <label for="chbox_setup2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                              <br><hr>

                              <div class="row" style="margin: 0px 50px;">
                                    <h2 style="margin-left: -8px">Modul Pengajuan</h2> 
                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Cuti</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_pengajuan_cuti" value="check all" onClick="do_this('chbox_pengajuan','btn_pengajuan_cuti')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_pengajuan_cuti" class="chbox_pengajuan_cuti" value="1" name="view_pengajuan_cuti" > 
                                               <label for="chbox_pengajuan_cuti">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_pengajuan_cuti1" class="chbox_pengajuan_cuti" value="1" name="create_pengajuan_cuti"> 
                                                <label for="chbox_pengajuan_cuti1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_pengajuan_cuti2" class="chbox_pengajuan_cuti" value="1" name="delete_pengajuan_cuti"> 
                                                <label for="chbox_pengajuan_cuti2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Piket</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_piket" value="check all" onClick="do_this('chbox_piket','btn_piket')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_piket" class="chbox_piket" value="1" name="create_piket"> 
                                               <label for="chbox_piket">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_piket1" class="chbox_piket" value="1" name="delete_piket"> 
                                                <label for="chbox_piket1">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Dinas</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_dinas" value="check all" onClick="do_this('chbox_dinas','btn_dinas')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_dinas" class="chbox_dinas" value="1" name="create_dinas" > 
                                               <label for="chbox_dinas">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox"  id="chbox_dinas1"  class="chbox_dinas" value="1" name="delete_dinas" > 
                                                <label for="chbox_dinas1">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <h5 style="margin-left: -20px">Karyawan Baru</h5>
                                        <input type="button" style="line-height: 10px; font-size: 10px; margin-left: -20px" id="btn_calon_karyawan" value="check all" onClick="do_this('chbox_calon_karyawan','btn_calon_karyawan')" />
                                        <div class="mrgn-btm20" style="margin-left: -20px">
                                            <div class="checkbox checkbox-success">
                                               <input type="checkbox" id="chbox_calon_karyawan" class="chbox_calon_karyawan" value="1" name="view_calon_karyawan" > 
                                               <label for="chbox_calon_karyawan">View</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_calon_karyawan1" class="chbox_calon_karyawan" value="1" name="create_calon_karyawan" > 
                                                <label for="chbox_calon_karyawan1">Create</label>
                                            </div>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chbox_calon_karyawan2" class="chbox_calon_karyawan" value="1" name="delete_calon_karyawan" > 
                                                <label for="chbox_calon_karyawan2">Delete</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                </div>

                              <div class="row">
                                  <div class="col-sm-6">
                                     <button class="btn btn-success" name="save">Save</button>
                                     <a href="<?=base_url()?>role" class="btn btn-warning">Cancel</a>
                                  </div>
                                  <div class="col-sm-6"></div>
                              </div><br>
                          </form>

                          </div>
                        </div>
                    </div>
                  </div><!-- /col-lg-3 -->
              </div><! --/row -->
              </section>
              </section>

              

      <!--main content end-->
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