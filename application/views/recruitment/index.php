  <?php
    $title_header = 'Recruitment';
  ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-clockpicker.min.css">     
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_recruitment= $(this).data('id-recruitment');
        var firstname = $(this).data('firstname');
        var lastname = $(this).data('lastname');
        var phone = $(this).data('phone');
        var email = $(this).data('email');
        var address = $(this).data('address');
        var id_division = $(this).data('id-division');
        var id_jabatan = $(this).data('id-jabatan');
        var status = $(this).data('status');
        
        $(".id-recruitment").val(id_recruitment);
        $(".firstname").val(firstname);
        $(".lastname").val(lastname);
        $(".phone").val(phone);
        $(".email").val(email);
        $(".address").val(address);
        $(".id-division").val(id_division);
        $(".id-jabatan").val(id_jabatan);
        $(".status").val(status);
        
    document.getElementById("info").innerHTML = 'Update <?=$title_header;?>';
    });
</script>
<script>
  $(document).on( "click", '.add-data',function(e) {    
    document.getElementById("info").innerHTML = 'Create <?=$title_header;?>';
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
                            <button type="button" class="btn btn-success add-data" data-toggle="modal" data-target="#myModal">Create Recruitment</button>
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
                                            <th style="text-align:center">No</th>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>Division</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_calon_karyawan as $view){?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->firstname;?></td>
                                            <td><?=$view->lastname;?></td>
                                            <td><?=$view->email;?></td>
                                            <td>
                                                <?php $pos=$this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_jabatan'")->result(); echo $pos[0]->nama_jabatan;?>
                                            </td>
                                            <td>
                                                <?php $div=$this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result(); echo $div[0]->division_name;?>
                                            </td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status=='Waiting'){
                                                        echo 'label label-default';
                                                    }elseif($view->status=='In Process'){
                                                        echo 'label label-info';
                                                    }elseif($view->status=='Accept'){
                                                        echo 'label label-success';
                                                    }else { 
                                                        echo 'label label-important';
                                                    }?>"><?=$view->status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>cv/<?=$view->cv;?>" class="btn btn-mini" title="Download CV"><i class="icon-book"></i></a>
                                                <?php if($view->status!='Accept'){?>
                                                <a href="<?=base_url()?>recruitment/accept/<?=$view->id_calon_karyawan;?>" class="btn btn-mini" title="Accept"><i class="icon-check"></i></a>
                                                <?php };?>
                                                <?php if($view->status!='Reject'){?>
                                                <a href="<?=base_url()?>recruitment/reject/<?=$view->id_calon_karyawan;?>" class="btn btn-mini" title="Reject"><i class="icon-remove"></i></a>
                                                <?php };?>
                                                <a href="<?=base_url()?>recruitment/delete_data/<?=$view->id_calon_karyawan;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
                                    <form method="post" action="<?=base_url()?>recruitment/add_edit_data" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_recruitment" class="id-recruitment" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label>Fisrtname</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control firstname" name="firstname" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Lastname</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control lastname" name="lastname">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control phone" name="phone" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="input-group">
                                                    <input type="email" class="form-control email" name="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Position</label>
                                                <div class="input-group">
                                                    <select type="text" class="form-control id-jabatan" name="position">
                                                        <option value="">- Choose Position -</option>
                                                        <?php foreach($data_position as $view){?>
                                                            <option value="<?=$view->id_jabatan;?>"><?=$view->nama_jabatan;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Division</label>
                                                <div class="input-group">
                                                    <select type="text" class="form-control id-division" name="division">
                                                        <option value="">- Choose Division -</option>
                                                        <?php foreach($data_division as $view){?>
                                                            <option value="<?=$view->id_division;?>"><?=$view->division_name;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Requirement</label>
                                                <div class="input-group">
                                                    <textarea class="form-control requirement" name="requirement" cols="100" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Address</label>
                                                <div class="input-group">
                                                    <textarea class="form-control address" name="address" cols="100" rows="5" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <div class="input-group">
                                                    <select type="text" class="form-control status" name="status">
                                                        <option value="Waiting">Waiting</option>
                                                        <option value="In Process">In Process</option>
                                                        <option value="Recruit">Recruit</option>
                                                        <option value="Reject">Reject</option>
                                                    </select>
                                                </div>
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
         

<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
    .find('input').change(function(){
        console.log(this.value);
    });
var input = $('#single-input').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
        donetext: 'Done',
        init: function() { 
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    })
    .find('input').change(function(){
        console.log(this.value);
    });

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
    // Have to stop propagation here
    e.stopPropagation();
    input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
    $('input').prop('readOnly', true);
}
</script>