  <?php
    $title_header = 'Create Payroll';
  ?>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-clockpicker.min.css">     
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
                <!--<div class="row-fluid">
                    <div class="span2" style="margin-left: -5px">
                        <select name="month" class="form-control">
                            <option value="">- all division -</option>
                            <?php foreach($data_division as $view){?>
                            <option value="<?=$view->id_division;?>"><?=$view->division_name;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="span1" style="margin: 4px 0 0 8px"><a href="#" class="btn btn-mini" title="Filter"><i class="icon-search"></i></a></div>
                    <div class="span9"></div>
                </div>-->
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
                                            <th>ID Employee</th>
                                            <th>Name</th>
                                            <th>Division</th>
                                            <th>Position</th>
                                            <th>Salary Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_employee as $view){?>
                                        <tr>
                                            <?php 
                                                $data_divisi=$this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                                if($data_divisi){
                                                    $division_name = $data_divisi[0]->division_name;    
                                                }else{
                                                    $division_name ='-';
                                                }
                                                $data_position = $this->db->query("SELECT * from jabatan  WHERE id_jabatan='$view->id_position'")->result();
                                                $jabatan = $data_position[0]->nama_jabatan;
                                                $data_payroll = $this->db->query("SELECT * from payroll WHERE id_employee='$view->id_employee'")->result();
                                                $total_salary = $data_payroll[0]->basic_salary + $data_payroll[0]->fixed_allowance + $data_payroll[0]->transport_allowance + $data_payroll[0]->meal_allowance + $data_payroll[0]->others_allowance + $data_payroll[0]->bonus;
                                                $month = date('m');
                                                $status_process = $this->db->query("SELECT * FROM payroll_detail WHERE id_employee='$view->id_employee' and payroll_month='$month'")->result();
                                                
                                            ?>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->nik;?></td>
                                            <td ><?=$view->firstname;?></td>
                                            <td ><?=$division_name;?></td>
                                            <td><?=$jabatan;?></td>
                                            <td><?=number_format($total_salary);?></td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($status_process){ 
                                                        $status = 'Processed';
                                                        echo 'label label-success';
                                                    }else { 
                                                        $status = 'Waiting Process';
                                                        echo 'label label-warning';
                                                    }?>"><?=$status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">    
                                                <?php if(!$status_process){?>
                                                <a href="<?=base_url()?>payroll/process/<?=$view->id_employee;?>" class="btn btn-mini" title="Process" ><i class="icon-check"></i></a>
                                                <?php }?>
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
                                    <form method="post" action="<?=base_url()?>letter/add_edit_data" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_letter_number" class="id-letter-number" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Letter Number</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="text" class="form-control letter-number" name="letter_number" id="validate-email" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label>Division</label>
                                                <div class="input-group id-division">
                                                    <select name="id_division" class="form-control id-division" required>
                                                    <option value="">- choose division -</option>
                                                    <?php foreach($data_division as $view){?>
                                                    <option value="<?=$view->id_division;?>"><?=$view->division_name;?></option>
                                                    <?php };?>
                                                    </select>
                                                </div>
                                                <div class="notif te telp">required</div>
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