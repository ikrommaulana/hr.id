  <?php
    $title_header = 'Attendance';
  ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-clockpicker.min.css"> 
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_employee= $(this).data('id-employee');
        var id_attendance= $(this).data('id-attendance');
        var attendance_date= $(this).data('attendance-date');
        var name = $(this).data('firstname');
        var division_name = $(this).data('division-name');
        var nik = $(this).data('nik');
        var gender = $(this).data('gender');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var divisi = $(this).data('divisi');
        var actual_in = $(this).data('actual-in');
        var actual_out = $(this).data('actual-out');

        $(".id-employee").val(id_employee);
        $(".id-attendance").val(id_attendance);
        $(".attendance-date").val(attendance_date);
        $(".nik").val(nik);
        $(".name").val(name);
        $(".division-name").val(division_name);
        $(".gender").val(gender);
        $(".email").val(email);
        $(".phone").val(phone);
        $(".divisi").val(divisi);
        $(".actual-in").val(actual_in);
        $(".actual-out").val(actual_out);
    
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
                <!-- main content -->
            <div class="container">
             <?=$this->session->flashdata('notifikasi')?>
                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12 mrgn-btm10">
                            <button type="button" class="btn btn-success add-data" data-toggle="modal" data-target="#myModal">Add Data</button>
                            <button type="button" class="btn btn-info import-data" data-toggle="modal" data-target="#myModal2">Import Data</button>
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
                                            <tH style="width:0px; display:none">
                                                <input type="hidden" name="row_sel" class="row_sel" />
                                            </tH>
                                            <th >Date</th>
                                            <th >ID Employee</th>
                                            <th >Firstname</th>
                                            <th >Division</th>
                                            <th >Daily In</th>
                                            <th>Daily Out</th>
                                            <th >Actual In</th>
                                            <th >Actual Out</th>
                                            <th >Total Time</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data_attendance as $view){?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td><?php $tanggal = strtotime($view->attendance_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td><?=$view->nik;?></td>
                                            <td><?=$view->firstname;?></td>
                                            <td><?=$view->division_name;?></td>
                                            <td><?=$view->daily_in;?></td>
                                            <td><?=$view->daily_out;?></td>
                                            <td style="background: #f1f1f1"><?=$view->actual_in;?></td>
                                            <td style="background: #f1f1f1"><?=$view->actual_out;?></td>
                                            <td><?=$view->total_time;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" 
                                                        class="btn btn-mini edit_button" title="Edit"
                                                        data-toggle="modal" data-target="#myModal2"
                                                        data-id-attendance="<?=$view->id_attendance;?>"
                                                        data-attendance-date ="<?=$view->attendance_date;?>"
                                                        data-nik="<?=$view->nik;?>"
                                                        data-name="<?=$view->firstname;?>"
                                                        data-division-name="<?=$view->division_name;?>"
                                                        data-actual-in="<?=$view->actual_in;?>"
                                                        data-actual-out="<?=$view->actual_out;?>"
                                                    ><i class="icon-pencil"></i></a>
                                                    <a href="<?=base_url()?>attendance/detail" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br><br><br>

            <!-- Bootstrap modal -->
            <style type="text/css">
            .notif{padding:0 10px 0 30px; position:absolute; right:0; margin:-25px 80px 0 0; border-radius:60% 0 0 60%; background:#F5A9BC; font-size:10px; color:#fff}
            .main, .tanggal{display:none; }
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
                                    <form method="post" action="<?=base_url()?>attendance/add_edit_data" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_employee" class="id-employee" />
                                        <div class="form-body" style="width:700px; margin:0 auto;">
                                            <div class="form-group" style="width: 150px">
                                                <label for="validate-email">Date</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="date" class="form-control tanggal" id="datepicker" name="tanggal" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif tg tanggal">required</div>
                                            </div>
                                            <table class="table table-vam table-striped" id="dt_gal">
                                            <thead>
                                                <tr>
                                                    <td style="width:0px; display:none">
                                                        <input type="hidden" name="row_sel" class="row_sel" />
                                                    </td>
                                                    <th>No</th>
                                                    <th>ID Employee</th>
                                                    <th>Firstname</th>
                                                    <th>Division</th>
                                                    <th style="text-align: center">In</th>
                                                    <th style="text-align: center">Out</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no=1; foreach($data_employee as $view){?>
                                                <input type="hidden" class="in" value="<?=$view->id_employee;?>" name="id_employee[<?=$no;?>]">
                                                <tr>
                                                    <td style="display:none"></td>
                                                    <td><?=$no;?></td>
                                                    <td><?=$view->nik;?></td>
                                                    <td><?=$view->firstname;?></td>
                                                    <td><?=$view->division_name;?></td>
                                                    <td style="text-align:center">
                                                        <div class="clearfix">
                                                            <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top" data-autoclose="true">
                                                                <input type="text" class="form-control in" name="in[<?=$no;?>]" style="width:70px; height: 13px" required>
                                                                <span class="input-group-addon">
                                                                    <i class="icon-time"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <div class="clearfix">
                                                            <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top" data-autoclose="true">
                                                                <input type="text" class="form-control out" name="out[<?=$no;?>]" style="width:70px; height: 13px" required>
                                                                <span class="input-group-addon">
                                                                    <i class="icon-time"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;}?>
                                            </tbody>
                                        </table>
                                        </div>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                            <div style="float:left; margin:10px 0 0 100px; padding:10px 0">
                                <button type="submit" name="save" class="btn btn-success" style="width:150px">Submit</button>
                                <a type="button" class="btn btn-danger" data-dismiss="modal" style="width:140px">Cancel</a>
                            </div></form>
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    </div>
                    <!-- End Bootstrap modal -->

                    <!-- Bootstrap modal 2-->
            
                    <div class="modal fade hide in" id="myModal2" role="dialog" data-keyboard="false" data-backdrop="static" style="width:900px; margin-left:-450px">
                        <div class="modal-dialog" >
                            <div class="modal-content" style="height:180px ">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title"></h3>
                                </div>
                                <div class="modal-body form" style="background:#f1f1f1">
                                    <div class="col-sm-12">
                                        <div style="border:1px solid #dedede; padding:0 10px 10px 10px; background:#fff; border-radius:10px 10px">
                                        <h5>format file</h5>
                                        <img src="<?=base_url()?>assets/img/excel2.png" width="100%">
                                        <div style="margin-top:10px">
                                            <button class="btn btn-info" style="line-height:10px; font-size:10px">A : NIK</button>
                                            <button class="btn btn-info" style="line-height:10px; font-size:10px">B : Actual In</button>
                                            <button class="btn btn-info" style="line-height:10px; font-size:10px">C : Actual Out</button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <form action="<?=base_url() ?>attendance/import_data" method="post" enctype="multipart/form-data" id="form2" class="form-horizontal">
                                        <input type="hidden" value="" name="id"/>
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                        <div class="form-group"><br>
                                            <div class="input-group">
                                                <label>Date</label>
                                                <input type="date" class="form-control attendance-date" id="datepicker" name="tanggal" required>
                                            </div>
                                        </div><br>
                                        <div class="form-group"> 
                                            <div class="input-group" style="border:1px solid #dedede; width:512px; border-radius:5px 5px">  
                                                <label class="btn btn-default" for="my-file-selector">
                                                    <input id="my-file-selector" type="file" name="userfile" accept="application/vnd.ms-excel" style="display:none; width:200px" onchange="$('#upload-file-info').html($(this).val());" required>
                                                    Search File...
                                                </label>
                                                <span class='label label-info' id="upload-file-info" style="margin-left:10px"></span>
                                            </div>
                                        </div>
                                        </div>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                            <div style="float:left; margin:10px 0 0 200px; padding:10px 0">
                                <button type="submit" name="save" value="Upload" class="btn btn-success" style="width:150px">Submit</button>
                                <a type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancel2()" style="width:140px">Cancel</a>
                            </div>
                            </form>
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