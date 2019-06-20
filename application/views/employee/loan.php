  <?php
    $title_header = 'Employee';
  ?>
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_kpi= $(this).data('id-kpi');
        var id_employee= $(this).data('id-employee');
        var attitude = $(this).data('attitude');
        var team_work = $(this).data('team-work');
        var discipline = $(this).data('discipline');
        var job_target = $(this).data('job-target');
        
        $(".id-kpi").val(id_kpi);
        $(".id-employee").val(id_employee);
        $(".attitude").val(attitude);
        $(".team-work").val(team_work);
        $(".discipline").val(discipline);
        $(".job-target").val(job_target);
        
    document.getElementById("info").innerHTML = 'Key Performance Indicator';
    });
</script>
<script>
  $(document).on( "click", '.add-data',function(e) {    
    document.getElementById("info").innerHTML = 'Key Performance Indicator';
    });
</script>
<style type="text/css">
    input{width:100%;}
    select{width:103%;}
</style>
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                <!--<div class="row-fluid">
                    <div class="span12">
                        <div class="span12 mrgn-btm10">
                            <a href="<?=base_url()?>employee/add_edit_data/" type="button" class="btn btn-success">Create Employee</a>
                        </div>
                    </div>
                </div>-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>List Of Loan</h4>
                            </div>
                            <div class="w-box-content">
                                <table class="table table-vam table-striped" id="dt_gal">
                                    <thead>
                                        <tr>
                                            <td style="width:0px; display:none">
                                                <input type="hidden" name="row_sel" class="row_sel" />
                                            </td>
                                            <th style="text-align:center">Employee ID</th>
                                            <th>Name</th>
                                            <th>Division</th>
                                            <th>Description</th>
                                            <th>Total</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_loan as $view){
                                            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_employee'")->result();
                                            $id_division = $data_employee[0]->id_division;
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
                                        ?>
                                        <tr>
                                            <td style="display:none"><?=$no;?></td>
                                            <td style="text-align:center"><?=$view->id_employee;?></td>
                                            <td style="text-align:center"><?=$data_employee[0]->firstname.' '.$data_employee[0]->lastname;?></td>
                                            <td style="text-align:center"><?=$data_division[0]->division_name;?></td>
                                            <td style="text-align:center"><?=$view->note;?></td>
                                            <td style="text-align:center"><?=number_format($view->total_loan);?></td>
                                            <td style="text-align:center">
                                                <?php $tanggal = strtotime($view->loan_date); $dt = date("d F Y  ", $tanggal); echo $dt;?>
                                            </td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status=='0'){
                                                        $status = 'Belum Lunas';
                                                        echo 'label label-important';
                                                    }else { 
                                                        $status = 'Lunas';
                                                        echo 'label label-success';
                                                    }?>"><?=$status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>employee/loan_lunas/<?=$view->id_employee_loan?>" class="btn btn-mini" title="Lunas"><i class="icon-check"></i></a>
                                                <a href="<?=base_url()?>employee/loan_hapus/<?=$view->id_employee_loan;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
                                    <form method="post" action="<?=base_url()?>employee/kpi" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_employee" class="id-employee" />
                                        <input type="hidden" value="" name="id_kpi" class="id-kpi" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Attendance (%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="100" class="form-control attendance" name="attendance" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Job Target (%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="100" class="form-control job-target" name="job_target" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Team Work (%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="100" class="form-control team-work" name="team_work" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Attitude (%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="100" class="form-control attitude" name="attitude" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Discipline (%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="100" class="form-control discipline" name="discipline" id="validate-email" required>
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
