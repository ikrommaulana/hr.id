  <?php
    $title_header = 'Administrator';
  ?> 
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_administrator= $(this).data('id-administrator');
        var id_privileges= $(this).data('id-privileges');
        var firstname = $(this).data('firstname');
        var lastname = $(this).data('lastname');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var status = $(this).data('status');
        
        $(".id-administrator").val(id_administrator);
        $(".id-privileges").val(id_privileges);
        $(".firstname").val(firstname);
        $(".lastname").val(lastname);
        $(".email").val(email);
        $(".phone").val(phone);
        $(".status").val(status);
        
    document.getElementById("info").innerHTML = 'Update Data <?=$title_header;?>';
    });
</script>
<script>
  $(document).on( "click", '.add-data',function(e) {    
    document.getElementById("info").innerHTML = 'Add Data <?=$title_header;?>';
    });
</script>
<style type="text/css">
    input{width:100%;}
    select{width:103%;}
    .popover{
        z-index: 9999999
    }
    .popover-title{
        padding: 8px 14px 8px 44px
    }
</style>
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12 mrgn-btm10">
                            <button type="button" class="btn btn-success add-data" data-toggle="modal" data-target="#myModal">Create Administrator</button>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>List Of <?=$title_header;?></h4>
                            </div>
                            <div class="w-box-content">
                                <table class="table table-vam table-striped" id="dt_gal">
                                    <thead>
                                        <tr>
                                            <td style="width:0px; display:none">
                                                <input type="hidden" name="row_sel" class="row_sel" />
                                            </td>
                                            <th style="text-align:center">No</th>
                                            <th>Firsname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Privileges</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_administrator as $view){?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td ><?=$view->firstname;?></td>
                                            <td><?=$view->lastname;?></td>
                                            <td><?=$view->email;?></td>
                                            <td><?=$view->phone;?></td>
                                            <td><?=$view->privileges_name;?></td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status==1){ 
                                                        $status = 'Enable';
                                                        echo 'label label-success';
                                                    }else { 
                                                        $status = 'Disable';
                                                        echo 'label label-important';
                                                    }?>"><?=$status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    
                                                <a href="#" 
                                                    class="btn btn-mini edit_button" title="Edit"
                                                    data-toggle="modal" data-target="#myModal"
                                                    data-id-administrator="<?=$view->id_administrator;?>"
                                                    data-firstname="<?=$view->firstname;?>"
                                                    data-lastname="<?=$view->lastname;?>"
                                                    data-email="<?=$view->email;?>"
                                                    data-phone="<?=$view->phone;?>"
                                                    data-status="<?=$view->status;?>"
                                                    data-privileges="<?=$view->id_privileges;?>"
                                                ><i class="icon-pencil"></i></a>
                                                <a href="<?=base_url()?>user/delete_data/<?=$view->id_administrator;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $no++;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br><br>

            <!-- Bootstrap modal -->
            <style type="text/css">
            .notif{padding:0 10px 0 30px; position:absolute; right:0; margin:-25px 80px 0 0; border-radius:60% 0 0 60%; background:#F5A9BC; font-size:10px; color:#fff}
            .main{display:none; }
            .alamat{display:none; }
            .telp{display:none; }
            textarea{width:100%;}
            </style>
                    <div class="modal fade hide in" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static" style="width:900px; margin-left:-450px">
                        <div class="modal-dialog" >
                            <div class="modal-content" style="height:auto ">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="info" style="color:#999"></h4>
                                </div>
                                <div class="modal-body form" style="background:#f1f1f1">
                                    <div class="col-sm-12">
                                    <form method="post" action="<?=base_url()?>user/add_edit_data" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_administrator" class="id-administrator" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Firstname</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="text" class="form-control firstname" name="firstname" id="validate-email" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Lastname</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="text" class="form-control lastname" name="lastname" id="validate-email" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Email</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="email" class="form-control email" name="email" id="validate-email" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label>Privileges</label>
                                                <div class="input-group divisi">
                                                    <select name="id_privileges" class="form-control id_privileges" required>
                                                    <option value="">- choose privileges -</option>
                                                    <?php foreach($data_privileges as $view){?>
                                                    <option value="<?=$view->id_privileges;?>"><?=$view->privileges_name;?></option>
                                                    <?php };?>
                                                    </select>
                                                </div>
                                                <div class="notif te telp">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Password</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="password" class="form-control password" name="password" id="password" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Confirm Password</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="password" class="form-control password2" name="password2" id="password" oninput="check(this)" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <script language='javascript' type='text/javascript'>
                                                  function check(input) {
                                                      if (input.value != document.getElementById('password').value) {
                                                          input.setCustomValidity('Password Must be Matching.');
                                                      } else {
                                                      // input is valid -- reset the error message
                                                          input.setCustomValidity('');
                                                      }
                                                  }
                                              </script>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <div class="input-group status">
                                                    <select name="status" class="form-control status" required>
                                                    <option value="">- choose status -</option>
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                    </select>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                            <div style="float:left; margin:10px 0 0 200px; padding:10px 0">
                                <button type="submit" name="save" class="btn btn-success" style="width:150px">Submit</button>
                                <a type="button" class="btn btn-danger" data-dismiss="modal" style="width:140px">Cancel</a>
                            </div></form>
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    </div>
                    <!-- End Bootstrap modal -->