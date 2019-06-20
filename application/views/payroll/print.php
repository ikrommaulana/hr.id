<html lang="en">
     <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     </head>
     <body>
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                        <?php
                            $tanggal = strtotime(date('Y-m-d')); $dt = date("F Y  ", $tanggal);
                        ?>
                            <div class="w-box-content">
                                
                                <div class="row-fluid" style="padding: 15px 0 0 0;">
                                        <div class="span2"></div>
                                        <div class="span8">
                                            <table style="margin-top: -28px">
                                                <tr>
                                                    <td style="width: 300px">
                                                        <b>PT Liga Indonesia Baru</b><br>
                                                        <i>Kuningan, Jakarta Selatan</i><br>
                                                        <span>Telp : 021 89378390</span>
                                                    </td>
                                                    <td style="width: 200px"><h3>SLIP GAJI</h3></td>
                                                    <td style="width: 250px">
                                                        <?php $tanggal = strtotime(date('Y-m-d')); $dt = date("d F Y  ", $tanggal);?>
                                                        Date : <i><?=$dt;?></i><br>
                                                        ID Employee : <b><?=$data_employee[0]->nik;?></b>
                                                    </td>
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
                                        <table style="margin-top: -20px">
                                            <tr>
                                                <td style="width: 50px"><b>No</b></td>
                                                <td style="width: 550px"><b>Description</b></td>
                                                <td style="width: 200px"><b>Total</b></td>
                                            </tr>
                                        </table>
                                        <hr style="margin-top: 0px">
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
                                                <td style="width: 200px; border-bottom:2px solid #999"><?=number_format($data_payroll[0]->bonus);?></td>
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
                                                <td style="width: 200px; border-bottom:2px solid #999;"><?=number_format($data_payroll[0]->salary_cuts);?> </td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
</body>
    </html>