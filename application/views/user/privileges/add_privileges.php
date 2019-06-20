  <?php
    $title_header = 'Create Privileges';
    if(!empty($data_privileges)){
      $id_privileges = $data_privileges[0]->id_privileges;
      $privileges_name = $data_privileges[0]->privileges_name;
      $status = $data_privileges[0]->status;
      $view_employee = $data_privileges[0]->view_employee;
      $create_employee = $data_privileges[0]->create_employee;
      $update_employee = $data_privileges[0]->update_employee;
      $delete_employee = $data_privileges[0]->delete_employee;
      $view_division = $data_privileges[0]->view_division;
      $create_division = $data_privileges[0]->create_division;
      $update_division = $data_privileges[0]->update_division;
      $delete_division = $data_privileges[0]->delete_division;
      $view_permit = $data_privileges[0]->view_permit;
      $create_permit = $data_privileges[0]->create_permit;
      $update_permit = $data_privileges[0]->update_permit;
      $delete_permit = $data_privileges[0]->delete_permit;
      $view_event = $data_privileges[0]->view_event;
      $create_event = $data_privileges[0]->create_event;
      $update_event = $data_privileges[0]->update_event;
      $delete_event = $data_privileges[0]->delete_event;
      $view_user = $data_privileges[0]->view_user;
      $create_user = $data_privileges[0]->create_user;
      $update_user = $data_privileges[0]->update_user;
      $delete_user = $data_privileges[0]->delete_user;
      $view_payroll = $data_privileges[0]->view_payroll;
      $create_payroll = $data_privileges[0]->create_payroll;
      $update_payroll = $data_privileges[0]->update_payroll;
      $delete_payroll = $data_privileges[0]->delete_payroll;
      $view_room = $data_privileges[0]->view_room;
      $create_room = $data_privileges[0]->create_room;
      $update_room = $data_privileges[0]->update_room;
      $delete_room = $data_privileges[0]->delete_room;
      $booking_room = $data_privileges[0]->booking_room;
      $view_document = $data_privileges[0]->view_document;
      $create_document = $data_privileges[0]->create_document;
      $update_document = $data_privileges[0]->update_document;
      $delete_document = $data_privileges[0]->delete_document;
      $download_document = $data_privileges[0]->download_document;
      $view_recruitment = $data_privileges[0]->view_recruitment;
      $create_recruitment = $data_privileges[0]->create_recruitment;
      $update_recruitment = $data_privileges[0]->update_recruitment;
      $delete_recruitment = $data_privileges[0]->delete_recruitment;
      $download_recruitment = $data_privileges[0]->download_recruitment;
      $view_attendance = $data_privileges[0]->view_attendance;
      $create_attendance = $data_privileges[0]->create_attendance;
      $update_attendance = $data_privileges[0]->update_attendance;
      $delete_attendance = $data_privileges[0]->delete_attendance;
      $view_detail_attendance = $data_privileges[0]->view_detail_attendance;
      $import_attendance = $data_privileges[0]->import_attendance;
      $export_attendance = $data_privileges[0]->export_attendance;
    }

  ?>   
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
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4><?=$title_header;?></h4>
                            </div>
                            <div class="w-box-content" style="padding:15px">
                                <div class="col-sm-12">
                                    <form action="<?=base_url()?>privileges/add_edit_data/<?php if(!empty($data_privileges)){ echo $id_privileges; } ?>" id="form" class="form-horizontal" method="post">
                                        <input type="hidden" value="" name="id_privileges"/>
                                        <div class="form-body" style="width:100%;">
                                            <div class="form-group">
                                                <label>Privileges Name</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="privileges_name" value="<?php if(!empty($data_privileges)){ echo $privileges_name; } ?>" style="width:30%">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <div class="input-group">
                                                    <select name="status" required style="width:31%">
                                                    <option value="">- pilih status -</option>
                                                    <option value="1" <?php if(!empty($data_privileges) && ($status == '1')){ echo 'selected'; } ?>>Enable</option>
                                                    <option value="0" <?php if(!empty($data_privileges) && ($status == '0')){ echo 'selected'; } ?>>Disable</option>
                                                    </select>
                                                </div>
                                            </div><hr>
                                            <p style="margin-top:-10px">Privileges</p>
                                            <div class="col-sm-12" style="background: #f1f1f1; height: 390px; padding: 15px">
                                                <div class="col-sm-12">
                                                <div class="span2">
                                                    <h5>Employee</h5>
                                                     <input type="button" style="line-height: 10px; font-size: 10px" id="btn_employee" value="check all" onClick="do_this('chbox_employee','btn_employee')" />
                                                     <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_employee == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_employee" value="1" name="view_employee" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_employee == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_employee" value="1" name="create_employee" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_employee == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_employee" value="1" name="update_employee" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_employee == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_employee" value="1" name="delete_employee" > Delete
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Division</h5>
                                                    <input type="button" style="line-height: 10px; font-size: 10px" id="btn_division" value="check all" onClick="do_this('chbox_division','btn_division')" />
                                                    <div class="mrgn-btm20">
                                                           <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_division == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_division" value="1" name="view_division" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_division == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_division" value="1" name="create_division" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_division == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_division" value="1" name="update_division" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_division == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_division" value="1" name="delete_division" > Delete
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Permit</h5>
                                                    <input type="button" style="line-height: 10px; font-size: 10px" id="btn_permit" value="check all" onClick="do_this('chbox_permit','btn_permit')" />
                                                    <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_permit == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_permit" value="1" name="view_permit" > View
                                                          </p><br>        
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_permit == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_permit" value="1" name="create_permit" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_permit == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_permit" value="1" name="update_permit" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_permit == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_permit" value="1" name="delete_permit" > Delete
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Event</h5>
                                                     <input type="button" style="line-height: 10px; font-size: 10px" id="btn_event" value="check all" onClick="do_this('chbox_event','btn_event')" />
                                                     <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_event == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_event" value="1" name="view_event" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_event == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_event" value="1" name="create_event" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_event == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_event" value="1" name="update_event" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_event == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_event" value="1" name="delete_event" > Delete
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>User</h5>
                                                     <input type="button" style="line-height: 10px; font-size: 10px" id="btn_user" value="check all" onClick="do_this('chbox_user','btn_user')" />
                                                     <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_user == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_user" value="1" name="view_user" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_user == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_user" value="1" name="create_user" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_user == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_user" value="1" name="update_user" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_user == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_user" value="1" name="delete_user" > Delete
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Payroll</h5>
                                                     <input type="button" style="line-height: 10px; font-size: 10px" id="btn_letter" value="check all" onClick="do_this('chbox_letter','btn_letter')" />
                                                     <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_payroll == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_letter" value="1" name="view_payroll" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_payroll == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_letter" value="1" name="create_payroll" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_payroll == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_letter" value="1" name="update_payroll" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_payroll == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_letter" value="1" name="delete_payroll" > Delete
                                                          </p>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="span2">
                                                    <h5>Meeting Room</h5>
                                                    <input type="button" style="line-height: 10px; font-size: 10px" id="btn_room" value="check all" onClick="do_this('chbox_room','btn_room')" />
                                                    <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_room == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_room" value="1" name="view_room" > View
                                                          </p><br>        
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_room == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_room" value="1" name="create_room" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_room == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_room" value="1" name="update_room" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_room == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_room" value="1" name="delete_room" > Delete
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($booking_room == '1')){ echo 'checked'; } ?> id="inlineCheckbox1" class="chbox_room" value="1" name="booking_room" > Booking
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Document</h5>
                                                     <input type="button" style="line-height: 10px; font-size: 10px" id="btn_document" value="check all" onClick="do_this('chbox_document','btn_document')" />
                                                     <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_document == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_document" value="1" name="view_document" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_document == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_document" value="1" name="create_document" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_document == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_document" value="1" name="update_document" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_document == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_document" value="1" name="delete_document" > Delete
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($download_document == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_document" value="1" name="download_document" > Download
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Time Attendance</h5>
                                                    <input type="button" style="line-height: 10px; font-size: 10px" id="btn_attendance" value="check all" onClick="do_this('chbox_attendance','btn_attendance')" />
                                                    <div class="mrgn-btm20">
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="view_attendance" > View
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_detail_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="view_detail_attendance" > View Detail
                                                          </p><br>        
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="create_attendance" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="update_attendance" > Update
                                                          </p><br>        
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="delete_attendance" > Delete
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($import_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="import_attendance" > Import Data
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($export_attendance == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_attendance" value="1" name="export_attendance" > Export Data
                                                          </p><br>
                                                    </div>
                                                </div>
                                                <div class="span2">
                                                    <h5>Recruitment</h5>
                                                     <input type="button" style="line-height: 10px; font-size: 10px" id="btn_recruitment" value="check all" onClick="do_this('chbox_recruitment','btn_recruitment')" />
                                                     <div class="mrgn-btm20">
                                                        <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($view_recruitment == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_recruitment" value="1" name="view_recruitment" > View
                                                          </p> <br>       
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($create_recruitment == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_recruitment" value="1" name="create_recruitment" > Create
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($update_recruitment == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_recruitment" value="1" name="update_recruitment" > Update
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($delete_recruitment == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_recruitment" value="1" name="delete_recruitment" > Delete
                                                          </p><br>
                                                          <p class="checkbox inline mgn">
                                                          <input type="checkbox" <?php if(!empty($data_privileges) && ($download_recruitment == '1')){ echo 'checked'; } ?> id="inlineCheckbox1"  class="chbox_recruitment" value="1" name="download_recruitment" > Download
                                                          </p>
                                                    </div>
                                                </div>
                                                <div class="span2"></div>
                                                <div class="span2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div><br>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span12 mrgn-btm10">
                                            <button type="submit" name="<?php if(!empty($id_privileges)){ echo 'edit'; }else{echo 'save';} ?>" class="btn btn-success" style="width:150px"><?php if(!empty($id_privileges)){ echo 'Submit'; }else{echo 'Update';} ?></button>
                                            <a href="<?=base_url()?>privileges" type="button" class="btn btn-danger" style="width:130px">Back</a>
                                            
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br><br>

            