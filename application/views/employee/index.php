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
  $(document).on( "click", '.loan',function(e) {
        var id_employee= $(this).data('id-employee');
        
        $(".id-employee").val(id_employee);
        
    document.getElementById("info").innerHTML = 'Create Loan';
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
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12 mrgn-btm10">
                            <a href="<?=base_url()?>employee/add_edit_data/" type="button" class="btn btn-success">Create Employee</a>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>List Of Employees</h4>
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
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Division</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_employee as $view){
                                            $data_kpi = $this->db->query("SELECT * FROM employee_kpi WHERE id_employee='$view->id_employee'")->result();
                                        ?>
                                        <tr>
                                            <td style="display:none"><?=$no;?></td>
                                            <td style="text-align:center"><?=$view->nik;?></td>
                                            <td><?=$view->firstname;?></td>
                                            <td><?php if($view->gender==1){echo 'Male';}else{echo 'Female';}?></td>
                                            <td><?=$view->email;?></td>
                                            <td><?=$view->phone;?></td>
                                            <td><?=$view->division_name;?></td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>" class="btn btn-mini" title="Edit Data"><i class="icon-pencil"></i></a>
                                                
                                                <a href="#" 
                                                    class="btn btn-mini edit_button"
                                                    data-toggle="modal" data-target="#myModal"
                                                    data-id-employee="<?=$view->id_employee;?>"
                                                    title="Key Performance Indicator (KPI)"><i class="icon-signal"></i></a>
                                                <a href="#" 
                                                    class="btn btn-mini loan" 
                                                    data-toggle="modal" data-target="#myModal2"
                                                    data-id-employee="<?=$view->id_employee;?>"
                                                    title="Loan"><i class="icon-tags"></i></a>
                                                <a href="<?=base_url()?>employee/detail/<?=$view->nik?>" class="btn btn-mini" title="Addition Information"><i class="icon-plus"></i></a>
                                                <a href="<?=base_url()?>employee/karir/<?=$view->nik?>" class="btn btn-mini" title="Career"><i class="icon-user"></i></a>
                                                <a href="<?=base_url()?>employee/job/<?=$view->nik?>" class="btn btn-mini" title="Jobs Target"><i class="icon-calendar"></i></a>
                                                <a href="<?=base_url()?>employee/delete_data/<?=$view->id_employee;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
                                        <input type="hidden" name="id_employee" class="id-employee" />
                                        <input type="hidden" name="id_kpi" class="id-kpi" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Attendance (max 35%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="35" class="form-control attendance" name="attendance" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Job Target (max 45%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="45" class="form-control job-target" name="job_target" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Team Work (max 5%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="5" class="form-control team-work" name="team_work" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Attitude (max 5%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="5" class="form-control attitude" name="attitude" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Discipline (max 10%)</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" max="10" class="form-control discipline" name="discipline" id="validate-email" required>
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


                    <!-- Bootstrap modal -->
            <style type="text/css">
            .notif{padding:0 10px 0 30px; position:absolute; right:0; margin:-25px 80px 0 0; border-radius:60% 0 0 60%; background:#F5A9BC; font-size:10px; color:#fff}
            .main{display:none; }
            .alamat{display:none; }
            .telp{display:none; }
            textarea{width:100%;}
            </style>
                    <div class="modal fade hide in" id="myModal2" role="dialog" data-keyboard="false" data-backdrop="static" style="width:900px; margin-left:-450px">
                        <div class="modal-dialog" >
                            <div class="modal-content" style="height:auto ">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="info" style="color:#999">Create Loan</h4>
                                </div>
                                <div class="modal-body form" style="background:#f1f1f1">
                                    <div class="col-sm-12">
                                    <form method="post" action="<?=base_url()?>employee/create_loan" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_employee" class="id-employee" />
                                        <input type="hidden" value="" name="id_employee_loan" class="id-employee-loan" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Description</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="text" class="form-control description" name="description" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Total Loan</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="number" class="form-control job-target" name="loan" id="validate-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Date</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="datepicker" name="tanggal" required>
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


