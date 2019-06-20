  <?php
    $title_header = 'Request Recruitment';
  ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-clockpicker.min.css">     
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_recruitment_request= $(this).data('id-recruitment-request');
        var id_division = $(this).data('id-division');
        var position = $(this).data('position');
        var requirement = $(this).data('requirement');
        var recruit_date = $(this).data('recruit-date');
        var recruit_total = $(this).data('recruit-total');
        var status = $(this).data('status');
        
        $(".id-recruitment-request").val(id_recruitment_request);
        $(".id-division").val(id_division);
        $(".position").val(position);
        $(".requirement").val(requirement);
        $(".recruit-date").val(recruit_date);
        $(".recruit-total").val(recruit_total);
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
                            <button type="button" class="btn btn-success add-data" data-toggle="modal" data-target="#myModal">Request Recruitment</button>
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
                                            <!--<th style="text-align:center">No</th>-->
                                            <th>Request Number</th>
                                            <th>Division</th>
                                            <th>Position</th>
                                            <th>Requirements</th>
                                            <th>Recruit Date</th>
                                            <th>Recruit Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_recruitment_request as $view){?>
                                        <tr>
                                            <!--<td style="text-align:center"><?=$no;?></td>-->
                                            <td style="text-align: center;"><?=$view->id_recruitment_request;?></td>
                                            <td>
                                                <?php $div=$this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result(); echo $div[0]->division_name;?>
                                            </td>
                                            <td>
                                                <?php $pos=$this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->position'")->result(); echo $pos[0]->nama_jabatan;?>
                                            </td>
                                            <td><?=$view->requirement;?></td>
                                            <td><?php $tanggal = strtotime($view->recruit_date); $dt = date("d F Y  ", $tanggal); echo $dt;?>                                                
                                            </td>
                                            <td><?=$view->recruit_total;?></td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status=='Waiting'){
                                                        echo 'label label-default';
                                                    }elseif($view->status=='Processing'){
                                                        echo 'label label-info';
                                                    }elseif($view->status=='Recruit'){
                                                        echo 'label label-success';
                                                    }else { 
                                                        echo 'label label-important';
                                                    }?>"><?=$view->status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="#" 
                                                    class="btn btn-mini edit_button" title="Edit"
                                                    data-toggle="modal" data-target="#myModal"
                                                    data-id-recruitment-request="<?=$view->id_recruitment_request;?>"
                                                    data-id-division="<?=$view->id_division;?>"
                                                    data-position="<?=$view->position;?>"
                                                    data-requirement="<?=$view->requirement;?>"
                                                    data-recruit-date="<?=$view->recruit_date;?>"
                                                    data-recruit-total="<?=$view->recruit_total;?>"
                                                    data-status="<?=$view->status;?>"
                                                ><i class="icon-pencil"></i></a>
                                                <a href="<?=base_url()?>recruitment/process/<?=$view->id_recruitment_request;?>" class="btn btn-mini" title="Process"><i class="icon-check"></i></a>
                                                <a href="<?=base_url()?>recruitment/delete_data_request/<?=$view->id_recruitment_request;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
                                        <input type="hidden" value="" name="id_recruitment_request" class="id-recruitment-request" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            
                                            <div class="form-group">
                                                <label for="validate-email">Requirement</label>
                                                <div class="input-group">
                                                    <textarea class="form-control requirement" name="requirement" cols="100" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Recruit Total</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control recruit-total" name="recruit_total" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Position</label>
                                                <div class="input-group">
                                                    <select type="text" class="form-control position" name="position">
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
                                            <!--<div class="form-group">
                                                <label>Status</label>
                                                <div class="input-group">
                                                    <select type="text" class="form-control status" name="status">
                                                        <option value="Waiting">Waiting</option>
                                                        <option value="In Process">In Process</option>
                                                        <option value="Recruit">Recruit</option>
                                                        <option value="Reject">Reject</option>
                                                    </select>
                                                </div>
                                            </div>-->
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