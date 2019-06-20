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
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                        <?php
                            $tanggal = strtotime(date('Y-m-d')); $dt = date("F Y  ", $tanggal);
                        ?>
                            <div class="w-box-header">
                                <h4>SLIP GAJI</h4>
                            </div>
                            <div class="w-box-content">
                                <form method="post" action="<?=base_url()?>payroll/process_salary">
                                
                                <div class="row-fluid" style="padding: 15px 0 0 0;">
                                        <div class="span2"></div>
                                        <div class="span3">
                                            <b>PT Liga Indonesia Baru</b><br>
                                            <i>Kuningan, Jakarta Selatan</i><br>
                                            <span>Telp : 021 89378390</span>
                                        </div>
                                        <div class="span2"><h3>SLIP GAJI</h3></div>
                                        <div class="span3" style="padding-left: 80px">
                                            <?php $tanggal = strtotime(date('Y-m-d')); $dt = date("d F Y  ", $tanggal);?>
                                            Date : <i><?=$dt;?></i><br>
                                            ID Employee : <b><?=$data_employee[0]->nik;?></b>

                                        </div>
                                        <div class="span2"></div>
                                </div>
                                <div class="row-fluid">
                                        <div class="span2"></div>
                                        <div class="span8">
                                            <hr>
                                        </div>
                                        <div class="span2"></div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span8">
                                        <table>
                                            <tr>
                                                <td style="width: 150px">Name</td>
                                                <td style="width: 250px">: <?=$data_employee[0]->firstname;?></td>
                                                <td style="width: 100px">Address</td>
                                                <td style="width: 300px">: <?=$data_employee[0]->address;?> </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">Position</td>
                                                <td style="width: 250px">: <?=$jabatan[0]->nama_jabatan;?></td>
                                                <td style="width: 100px">Phone</td>
                                                <td style="width: 300px">: <?=$data_employee[0]->mobile_phone;?> </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="span2"></div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span8">
                                        <hr>
                                    </div>
                                    <div class="span2"></div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span8">
                                        <table style="margin-top: -28px">
                                            <tr>
                                                <td style="width: 50px"><b>N0</b></td>
                                                <td style="width: 550px"><b>Description</b></td>
                                                <td style="width: 200px"><b>Total</b></td>
                                            </tr>
                                        </table>
                                        <hr style="margin-top: -1px">
                                        <table style="margin-top: -10px">
                                            <tr>
                                                <td style="width: 50px">1</td>
                                                <td style="width: 550px">Basic Salary</td>
                                                <td style="width: 200px"><?=number_format($data_payroll[0]->basic_salary);?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">2</td>
                                                <td style="width: 550px">Fixed Allowance</td>
                                                <td style="width: 200px"><?=number_format($data_payroll[0]->fixed_allowance);?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">3</td>
                                                <td style="width: 550px">Transport Allowance</td>
                                                <td style="width: 200px"><?=number_format($data_payroll[0]->transport_allowance);?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">4</td>
                                                <td style="width: 550px">Meal Allowance</td>
                                                <td style="width: 200px"><?=number_format($data_payroll[0]->meal_allowance);?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">5</td>
                                                <td style="width: 550px">Others Allowance</td>
                                                <td style="width: 200px"><?=number_format($data_payroll[0]->other_allowance);?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">6</td>
                                                <td style="width: 550px">Bonus</td>
                                                <td style="width: 200px; border-bottom:2px solid #999"><?=number_format($data_payroll[0]->bonus);?> <span style="float: right"><b>+</b></span></td>
                                            </tr>
                                            <?php 
                                                $salary = $data_payroll[0]->basic_salary + $data_payroll[0]->fixed_allowance + $data_payroll[0]->transport_allowance + $data_payroll[0]->meal_allowance + $data_payroll[0]->other_allowance + $data_payroll[0]->bonus;
                                                $total_salary = $salary - $data_payroll[0]->salary_cuts;
                                            ?>
                                            <tr>
                                                <td style="width: 50px"></td>
                                                <td style="width: 550px"></td>
                                                <td style="width: 200px"><?=number_format($salary);?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td style="width: 50px">7</td>
                                                <td style="width: 550px">Salary Cuts</td>
                                                <td style="width: 200px; border-bottom:2px solid #999;"><?=number_format($data_payroll[0]->salary_cuts);?> <span style="float: right"><b>-</b></span></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px"></td>
                                                <td style="width: 550px;"><span style="float: right; margin-right: 30px"><b>TOTAL SALARY</b></span></td>
                                                <td style="width: 200px"><b><?=number_format($total_salary);?></b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="span2"></div>
                                </div>
                                <br>
                                <br>

                                <div class="row-fluid">
                                    <div class="span2"></div>
                                    <div class="span8">
                                        <div class="span12 mrgn-btm10">
                                            <a href="<?=base_url()?>payroll/cetak" type="button" class="btn btn-default" style="width:130px">Print</a>
                                            
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