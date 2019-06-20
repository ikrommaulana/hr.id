<?php
// include autoloader
require(APPPATH . '/libraries/dompdf/autoload.inc.php');
$tanggal = strtotime(date('Y-m-d')); $dt = date("F Y  ", $tanggal);
$dt = date("d F Y  ", $tanggal);
$salary = $data_payroll[0]->basic_salary + $data_payroll[0]->fixed_allowance + $data_payroll[0]->transport_allowance + $data_payroll[0]->meal_allowance + $data_payroll[0]->other_allowance + $data_payroll[0]->bonus;
$total_salary = $salary - $data_payroll[0]->salary_cuts;
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class

$html = 
    '<html lang="en">
     <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     </head>
     <body>
     <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="w-box">
                    <div class="w-box-content">
                        <div class="row-fluid" style="padding: 15px 0 0 0;">
                            <div class="span2"></div>
                            <div class="span3">
                                <b>PT Liga Indonesia Baru</b><br>
                                <i>Kuningan, Jakarta Selatan</i><br>
                                <span>Telp : 021 89378390</span>
                            </div>
                            <div class="span2"><h3>SLIP GAJI</h3></div>
                            <div class="span3" style="padding-left: 80px">
                                Date : <i>'.$dt.'</i><br>
                                ID Employee : <b>'.$data_employee[0]->nik.'</b>
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
                                                <td style="width: 250px">: '.$data_employee[0]->firstname.'</td>
                                                <td style="width: 100px">Address</td>
                                                <td style="width: 300px">: '.$data_employee[0]->address.' </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">Position</td>
                                                <td style="width: 250px">: '.$jabatan[0]->nama_jabatan.'</td>
                                                <td style="width: 100px">Phone</td>
                                                <td style="width: 300px">: '.$data_employee[0]->mobile_phone.' </td>
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
                                                <td style="width: 200px">'.number_format($data_payroll[0]->basic_salary).'</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">2</td>
                                                <td style="width: 550px">Fixed Allowance</td>
                                                <td style="width: 200px">'.number_format($data_payroll[0]->fixed_allowance).'</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">3</td>
                                                <td style="width: 550px">Transport Allowance</td>
                                                <td style="width: 200px">'.number_format($data_payroll[0]->transport_allowance).'</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">4</td>
                                                <td style="width: 550px">Meal Allowance</td>
                                                <td style="width: 200px">'.number_format($data_payroll[0]->meal_allowance).'</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">5</td>
                                                <td style="width: 550px">Others Allowance</td>
                                                <td style="width: 200px">'.number_format($data_payroll[0]->other_allowance).'</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">6</td>
                                                <td style="width: 550px">Bonus</td>
                                                <td style="width: 200px; border-bottom:2px solid #999">'.number_format($data_payroll[0]->bonus).' <span style="float: right"><b>+</b></span></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px"></td>
                                                <td style="width: 550px"></td>
                                                <td style="width: 200px">'.number_format($salary).'</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px">7</td>
                                                <td style="width: 550px">Salary Cuts</td>
                                                <td style="width: 200px; border-bottom:2px solid #999;">'.number_format($data_payroll[0]->salary_cuts).' <span style="float: right"><b>-</b></span></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50px"></td>
                                                <td style="width: 550px;"><span style="float: right; margin-right: 30px"><b>TOTAL SALARY</b></span></td>
                                                <td style="width: 200px"><b>'.number_format($total_salary).'</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="span2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </body>
    </html>';
    $dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codex",array("Attachment"=>0));
?>