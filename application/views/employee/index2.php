<?php if($role_id==1){?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
                        <ol class="breadcrumb">
                            <a href="<?=base_url()?>employee/add_edit_data/" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-plus"></i> </a>
                            <li><a href="javascript:void(0)">Karyawan</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?=$this->session->flashdata('notifikasi')?>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                
                <!--row -->
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div class="btn btn-default"><a href="<?=base_url()?>employee"> aktif</a></div>
                            <div class="btn btn-default"><a href="<?=base_url()?>employee/non"> non-aktif</a></div><br>
                            <h3 class="box-title m-b-0" style="font-weight: normal;">Data Export</h3>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <!--<th>Alamat</th>-->
                                            <th>Phone</th>
                                            <th>Division</th>
                                            <th>Jabatan</th>
                                            <th>Status Karyawan</th>
                                            <th>Apr</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_employee as $view){
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                            $level = isset($data_jabatan[0]->level) ? $data_jabatan[0]->level : 0;
                                        ?>
                                        <tr>
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer; text-align:center"><?=$view->nik;?></td>
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?=$view->firstname;?></td>
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?php if($view->gender==1){echo 'Male';}else{echo 'Female';}?></td>
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?=$view->email;?></td>
                                            <!--<td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?=$view->address;?></td>-->
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?=$view->mobile_phone;?></td>
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?php if($data_division){echo $data_division[0]->division_name;}else{echo '-';}?></td>
                                            <td onclick="window.document.location='<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>'" style="cursor:pointer;"><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
                                            <td>
                                                <?php $status_kerja =$view->employee_status; if($status_kerja==0){echo 'Permanen';}elseif($status_kerja==1){echo 'Kontrak';}elseif($status_kerja==2){echo 'Probation';}elseif($status_kerja==3){echo 'Resign';}elseif($status_kerja==4){echo 'Fired';}?>
                                            </td>
                                            <td><?=$view->approver;?></td>
                                            <td>
                                                <div class="btn-group" style="width: 250px">
                                                <a href="#<?=$view->id_employee;?>" data-toggle="modal" data-target="#<?=$view->id_employee;?>" class="btn btn-mini" title="Hak cuti"><i class="icon-bag"></i></a>
                                                <a href="<?=base_url()?>employee/add_edit_data/<?=$view->id_employee?>" class="btn btn-mini" title="Edit Data"><i class="icon-pencil"></i></a>
                                                <a href="<?=base_url()?>employee/sign/<?=$view->id_employee?>" class="btn btn-mini" title="Digital Signature"><i class="icon-badge"></i></a>
                                                <a href="<?=base_url()?>employee/approver/<?=$view->id_employee?>" class="btn btn-mini" title="Approver"><i class="icon-eyeglass"></i></a>
                                                <?php if($level>1){?>
                                                <a href="<?=base_url()?>employee/set_approvel_dana/<?=$view->id_employee?>" class="btn btn-mini" title="Set Approvel Dana <?=$view->firstname;?>"><i class="icon-wallet"></i></a>
                                                <?php }?>
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

                <?php foreach($data_employee as $view){
                    $id_employee = $view->id_employee;
                ?>
                <div class="row">
                    <div class="col-md-4">
                            <!-- sample modal content -->
                            <!-- /.modal -->
                            <div id="<?=$view->id_employee;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <form method="post" action="<?=base_url()?>employee/add_edit_cuti_karyawan/<?=$view->id_employee;?>">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="padding:30px">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="info" style="color:#999">Hak cuti <?=$view->firstname;?></h4> 
                                        </div>
                                        <div class="modal-body">
                                        <table>
                                            <tr>
                                                <th>Keterangan</th>
                                                <th style="width: 160px"></th>
                                                <th>Jumlah</th>
                                            </tr>
                                        <?php 
                                            $data_cuti = $this->db->query("SELECT * FROM cuti ORDER BY jenis_cuti ASC")->result();
                                            if($data_cuti){foreach($data_cuti as $view){
                                                $data_hak_cuti = $this->db->query("SELECT * FROM employee_hak_cuti WHERE id_employee='$id_employee' AND id_cuti='$view->id_cuti'")->result();
                                                ?>  
                                              
                                            <tr>
                                                <td>
                                                <div class="checkbox checkbox-success">
                                                    <input name="cuti<?=$view->id_cuti;?>" id="checkbox0" type="checkbox" value="1" <?php if(!empty($data_hak_cuti) && ($data_hak_cuti[0]->status == '1')){ echo 'checked'; } ?>>
                                                    <label for="checkbox0"> <?=$view->jenis_cuti;?> </label>
                                                </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input name="jumlah<?=$view->id_cuti;?>" type="number" class="form-control" style="width: 70px; height: 25px" value="<?php if(!empty($data_hak_cuti)){ echo $data_hak_cuti[0]->jumlah; }else{echo $view->jumlah;} ?>">
                                                </td>
                                             </tr>
                                            <?php }}?>
                                        </div>
                                        </table>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="booking" class="btn btn-danger waves-effect waves-light">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                    </div>
                </div>
                <?php }?>
                <!-- ============================================================== -->
                <!-- wallet, & manage users widgets -->
                <!-- ============================================================== -->
                <!-- .row -->
                <div class="row">
                    <!-- col-md-9 -->
                    <!-- /col-md-9 -->
                    <!-- col-md-3 -->
                    <div class="col-md-4 col-lg-3">
                        <div class="panel wallet-widgets"  style="height:0px; display: none">
                            <div class="panel-body">
                                
                            </div>
                            <div id="morris-area-chart2" style="height:0px; display: none"></div>
                            
                        </div>
                    </div>
                    <!-- /col-md-3 -->
                </div>
                <?php }else{
    redirect('error');
}?>