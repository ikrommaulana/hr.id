<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=report payroll.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<h3>Report Payroll <?=date('F',mktime(0,0,0,$month,10)).' '.$year;?></h3>
<table border='1' width="70%">
<tr style="background-color: #0489B1; color: #fff">
<th>No</th>
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
<?php $no=1; foreach($data_payroll as $view){?>
                                        <tr>
                                            <?php 
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
</table>