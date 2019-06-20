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
                                <h4>List Of KPI</h4>
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
                                            <th>Attendance</th>
                                            <th>Job Target</th>
                                            <th>Team Work</th>
                                            <th>Discipline</th>
                                            <th>Attitude</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_kpi as $view){
                                            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_employee'")->result();
                                            if($data_employee){
                                                $id_division = $data_employee[0]->id_division;
                                            }else{
                                                $id_division = 1;
                                            }
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
                                            $total = $view->attendance + $view->job_target + $view->team_work + $view->discipline + $view->attitude; 
                                            $total_kpi = $total;
                                        ?>
                                        <tr>
                                            <td style="display:none"><?=$no;?></td>
                                            <td style="text-align:center"><?=$view->id_employee;?></td>
                                            <td style="text-align:center"><?=$data_employee[0]->firstname.' '.$data_employee[0]->lastname;?></td>
                                            <td style="text-align:center"><?=$data_division[0]->division_name;?></td>
                                            <td style="text-align:center"><?=$view->attendance;?></td>
                                            <td style="text-align:center"><?=$view->job_target;?></td>
                                            <td style="text-align:center"><?=$view->team_work;?></td>
                                            <td style="text-align:center"><?=$view->discipline;?></td>
                                            <td style="text-align:center"><?=$view->attitude;?></td>
                                            <td style="text-align:center"><?=$total_kpi;?></td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>employee/delete_kpi/<?=$view->id_kpi;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
