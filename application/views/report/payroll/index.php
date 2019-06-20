  <?php
    $title_header = 'Payroll';
  ?>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-clockpicker.min.css">     
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_letter_number= $(this).data('id-letter-number');
        var id_division = $(this).data('id-division');
        var letter_number = $(this).data('letter-number');
        
        $(".id-letter-number").val(id_letter_number);
        $(".id-division").val(id_division);
        $(".letter-number").val(letter_number);
        
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
                <form method="post" action="<?=base_url()?>report/payroll">
                    <!--<div class="span1">
                        <div class="span12 mrgn-btm10">
                            <button name="excel" type="submit" class="btn btn-success">Excel</button>
                        </div>
                    </div>-->
                    
                    <div class="span3" style="margin-left: -5px">
                        <select name="id_division" class="form-control">
                            <option value="">- select division -</option>
                            <?php foreach($data_division as $view){?>
                            <option value="<?=$view->id_division;?>" <?php if($view->id_division==$id_division){echo 'selected';}?>><?=$view->division_name;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="span2" style="margin-left: 10px">
                        <select name="month" class="form-control">
                            <option value="01" <?php if($month=='01'){echo 'selected';}?>>Januari</option>
                            <option value="02" <?php if($month=='02'){echo 'selected';}?>>Februari</option>
                            <option value="03" <?php if($month=='03'){echo 'selected';}?>>Maret</option>
                            <option value="04" <?php if($month=='04'){echo 'selected';}?>>April</option>
                            <option value="05" <?php if($month=='05'){echo 'selected';}?>>Mei</option>
                            <option value="06" <?php if($month=='06'){echo 'selected';}?>>Juni</option>
                            <option value="07" <?php if($month=='07'){echo 'selected';}?>>Juli</option>
                            <option value="08" <?php if($month=='08'){echo 'selected';}?>>Agustus</option>
                            <option value="09" <?php if($month=='09'){echo 'selected';}?>>September</option>
                            <option value="10" <?php if($month=='10'){echo 'selected';}?>>Oktober</option>
                            <option value="11" <?php if($month=='11'){echo 'selected';}?>>Nopember</option>
                            <option value="12" <?php if($month=='12'){echo 'selected';}?>>Desember</option>
                        </select>
                    </div>
                    <div class="span1" style="margin-left: 10px">
                        <select name="year" class="form-control">
                            <?php for($now=$year-4; $now<=$year; $now++){?>
                            <option value="<?=$now;?>" <?php if($now==$year){echo 'selected';}?>><?=$now;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="span1" style="margin: 4px 0 0 8px">
                        <button type="submit" name="filter" value="filter" class="btn btn-mini" title="Filter"><i class="icon-search"></i></button>
                    </div>
                    <div class="span5"></div>
                    </form>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>List Of <?=$title_header;?> <a href="<?=base_url()?>report/payroll_excel/<?=$id_division.'/'.$month.'/'.$year;?>"> - Excel -</a></h4>
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
                                            <th>Position</th>
                                            <th>Basic Salary</th>
                                            <th>Fixed Allowance</th>
                                            <th>Transport Allowance</th>
                                            <th>Meal Allowance</th>
                                            <th>Other Allowance</th>
                                            <th>Bonus</th>
                                            <th>Salary Cuts</th>
                                            <th>Salary Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_payroll as $view){
                                            $data_employee =  $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_employee'")->result();
                                                $id_division = $data_employee[0]->id_division;
                                                $id_jabatan = $data_employee[0]->id_position;
                                                $total_salary = ($view->basic_salary + $view->fixed_allowance + $view->transport_allowance + $view->meal_allowance + $view->other_allowance + $view->bonus) - $view->salary_cuts;
                                                $data_position = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
                                                $data_divisi=$this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
                                                if($data_divisi){
                                                    $division_name = $data_divisi[0]->division_name;    
                                                }else{
                                                    $division_name ='-';
                                                }
                                            ?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->id_employee;?></td>
                                            <td ><?=$data_employee[0]->firstname;?></td>
                                            <td><?=$data_position[0]->nama_jabatan;?></td>
                                            <td><?=number_format($view->basic_salary);?></td>
                                            <td><?=number_format($view->fixed_allowance);?></td>
                                            <td><?=number_format($view->transport_allowance);?></td>
                                            <td><?=number_format($view->meal_allowance);?></td>
                                            <td><?=number_format($view->other_allowance);?></td>
                                            <td><?=number_format($view->bonus);?></td>
                                            <td><?=number_format($view->salary_cuts);?></td>
                                            <td><?=number_format($total_salary);?></td>
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