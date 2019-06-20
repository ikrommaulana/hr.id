  <?php
    $title_header = 'Division';
  ?>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-clockpicker.min.css">     
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_division= $(this).data('id-division');
        var division_name = $(this).data('division-name');
        var daily_in = $(this).data('daily-in');
        var daily_out = $(this).data('daily-out');
        
        $(".id-division").val(id_division);
        $(".division-name").val(division_name);
        $(".daily-in").val(daily_in);
        $(".daily-out").val(daily_out);
        
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
                            <button type="button" class="btn btn-success add-data" data-toggle="modal" data-target="#myModal">Add Data</button>
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
                                            <th>Division Name</th>
                                            <th>Daily In</th>
                                            <th>Daily Out</th>
                                            <th>Create Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_division as $view){?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td ><?=$view->division_name;?></td>
                                            <td><?=$view->daily_in;?></td>
                                            <td><?=$view->daily_out;?></td>
                                            <td><?php $tanggal = strtotime($view->created_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td><?php $tanggal = strtotime($view->updated_date); $dt = date("d F Y  ", $tanggal); if($view->updated_date=='0000-00-00'){echo '-';}else{echo $dt;}?></td>
                                            <td>
                                                <div class="btn-group">
                                                    
                                                <a href="#" 
                                                    class="btn btn-mini edit_button" title="Edit"
                                                    data-toggle="modal" data-target="#myModal"
                                                    data-id-division="<?=$view->id_division;?>"
                                                    data-division-name="<?=$view->division_name;?>"
                                                    data-daily-in="<?=$view->daily_in;?>"
                                                    data-daily-out="<?=$view->daily_out;?>"
                                                ><i class="icon-pencil"></i></a>
                                                <a href="<?=base_url()?>division/delete_data/<?=$view->id_division;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
                                    <form method="post" action="<?=base_url()?>division/add_edit_data" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_division" class="id-division" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Division Name</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="text" class="form-control division-name" name="division_name" id="validate-email" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Daily In</label>
                                                <div class="clearfix">
                                                    <div class="input-group clockpicker pull-center" data-placement="left" data-align="top" data-autoclose="true">
                                                        <input type="text" class="form-control daily-in" value="09:00" name="daily_in">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Daily Out</label>
                                                <div class="clearfix">
                                                    <div class="input-group clockpicker pull-center" data-placement="left" data-align="top" data-autoclose="true">
                                                        <input type="text" class="form-control daily-out" value="17:30" name="daily_out">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                    </div>
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