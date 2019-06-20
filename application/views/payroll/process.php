  <?php
    $title_header = 'Generate Payroll';
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
                        <?php
                            $tanggal = strtotime(date('Y-m-d')); $dt = date("F Y  ", $tanggal);
                        ?>
                            <div class="w-box-header">
                                <h4>Payroll setup <?=$dt;?></h4>
                            </div>
                            <div class="w-box-content">
                                <form method="post" action="<?=base_url()?>payroll/process_salary">
                                <div class="row-fluid" style="padding: 15px 0; background: #f1f1f1">

                                        <div class="span2"></div>
                                        <div class="span4">
                                            <i>ID Employee</i>  <br><b><?=$nik;?></b><br>
                                            <i>Name</i><br> <b><?=$data_employee[0]->firstname;?></b>
                                            
                                        </div>
                                        <div class="span4">
                                            <i>Division</i>  <br><b><?=$data_division[0]->division_name;?></b><br>
                                            <i>Position</i><br> <b><?=$jabatan[0]->nama_jabatan;?></b>

                                        </div>
                                        <div class="span2"></div>

                                </div><br>
                                <div class="row-fluid">
                                    <div class="span2">
                                    <input type="hidden" name="id_employee" value="<?=$data_employee[0]->id_employee;?>">
                                    <input type="hidden" name="id_payroll_detail" value="<?=$id_payroll_detail;?>">
                                    </div>
                                    <div class="span4">
                                        <label>Cut Salary *</label>
                                        <div class="input-group">
                                            <select name="cut" class="form-control">
                                                <?php foreach($data_loan as $view){?>
                                                <option value="<?=$view->id_employee_loan;?>"><?=$view->total_loan;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <!--<label>Fixed Allowance</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control span12" value="<?=$data_payroll[0]->fixed_allowance;?>" name="fixed_allowance">
                                        </div>-->
                                    </div>
                                    <div class="span2"></div>
                                </div>
                                <!--<div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span4">
                                        <label>Trannsport Allowance</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control span12" value="<?=$data_payroll[0]->transport_allowance;?>" name="transport_allowance">
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <label>Meal Allowance</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control span12" value="<?=$data_payroll[0]->meal_allowance;?>" name="meal_allowance">
                                        </div>
                                    </div>
                                    <div class="span2"></div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span4">
                                        <label>Others Allowance</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control span12" value="<?=$data_payroll[0]->others_allowance;?>" name="other_allowance">
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <label>Bonus</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control span12" value="<?=$data_payroll[0]->bonus;?>" name="bonus">
                                        </div>
                                    </div>
                                    <div class="span2"></div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span4">
                                        <label>Salary Cuts</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control span12" name="salary_cuts">
                                        </div>
                                    </div>
                                    <div class="span4">
                                    </div>
                                    <div class="span2"></div>
                                </div><br>-->

                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span8">
                                        <div class="span12 mrgn-btm10">
                                            <button type="submit" name="save" value="save" class="btn btn-success" style="width:150px">Save</button>
                                            <!--<a href="<?=base_url()?>privileges" type="button" class="btn btn-default" style="width:130px">Print</a>-->
                                            <a href="<?=base_url()?>payroll/" type="button" class="btn btn-danger" style="width:130px">Cancel</a>
                                        </div>
                                    </div>
                                </div><br><br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
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