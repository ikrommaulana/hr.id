  <?php
    $title_header = 'Career';
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
    document.getElementById("info").innerHTML = 'Add Career';
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
                            <button type="button" class="btn btn-info add-data" data-toggle="modal" data-target="#myModal">Create Career</button>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-content">
                                <table class="table table-vam table-striped">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data_karir as $view){
                                        ?>
                                        <tr>
                                            <td><?=$view->join_date;?></td>
                                            <td><?=$view->exit_date;?></td>
                                            <td><?=$view->nama_jabatan;?></td>
                                        </tr>
                                        <?php }?>

                                        <?php 
                                        $data_karir2 = $this->db->query("select * FROM jenjang_karir a, jabatan b WHERE a.id_employee='$id_employee' and b.id_jabatan=a.id_jabatan")->result();
                                        foreach($data_karir2 as $view){
                                        ?>
                                        <tr>
                                            <td><?=$view->start_date;?></td>
                                            <td><?=$view->end_date;?></td>
                                            <td><?=$view->nama_jabatan;?></td>
                                        </tr>
                                        <?php }?>
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
                                    <form method="post" action="<?=base_url()?>employee/add_karir" id="form" class="form-horizontal">
                                        <input type="hidden" name="id_employee" value="<?=$id_employee;?>">
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label>Position</label>
                                                <div class="input-group description">
                                                    <select name="jabatan" class="form-control jabatan" required>
                                                    <?php foreach($data_jabatan as $view){?>
                                                    <option value="<?=$view->id_jabatan;?>"><?=$view->nama_jabatan;?></option>
                                                    <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Start Date</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="date" class="form-control meeting-date" id="datepicker" name="start_date" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">End Date</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="date" class="form-control meeting-date" id="datepicker" name="end_date" required>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                            <div style="float:left; margin:10px 0 0 200px; padding:10px 0">
                                <button type="submit" name="save" class="btn btn-success" style="width:150px" >Submit</button>
                                <a type="button" class="btn btn-danger" data-dismiss="modal" style="width:140px">Cancel</a>
                            </div></form>
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    </div>
                    <!-- End Bootstrap modal -->

