 <?php if($role_id==1 || $user_id=='10027'){?>
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
                            <li><a href="javascript:void(0)">Daftar Pengajuan Dinas</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                
                <!--row -->
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        <style type="text/css">
                            .btn-glyphicon { padding:8px; background:#ffffff; margin-right:4px; }
                            .icon-btn { padding: 1px 15px 3px 2px; border-radius:50px;}
                        </style>
                            <!--<div class="row">
                                <a class="btn icon-btn btn-info" href="<?=base_url()?>permit/daftar"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Cuti</a>
                                <a class="btn icon-btn btn-default" href="#"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Piket</a>
                                <a class="btn icon-btn btn-default" href="#"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-info"></span>Dinas</a>
                            </div><br>-->
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Dinas</th>
                                            <th>ID Employee</th>
                                            <th>Nama Staf</th>
                                            <th>Dep.</th>
                                            <th>Tujuan</th>
                                            <th>Keperluan</th>
                                            <th>Tanggal</th>
                                            <th>Total Hari</th>
                                            <th>Total Hari Libur</th>
                                            <th>Approval</th>
                                            <th>Approval Budget</th>
                                            <th>Total Dana</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php $no=1; foreach($data_dinas as $view){
                                            $id_dinas = $view->id_dinas;
                                            $id_employee = $view->id_employee;
                                            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                                            $nama = $data_employee[0]->firstname;
                                            $id_division = $data_employee[0]->id_division;
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
                                            if($data_division){
                                                $nama_divisi = $data_division[0]->division_name;    
                                            }else{
                                                $nama_divisi ='-';
                                            }
                                             
                                            
                                            $tot_hari = $view->total_days;
                                            ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$id_dinas;?></td>
                                            <td><?=$view->id_employee;?></td>
                                            <td><?=$nama;?></td>
                                            <td><?=$nama_divisi;?></td>
                                            <td><?=$view->tujuan;?></td>
                                            <td><?=$view->keperluan;?></td>
                                            <td>
                                                <?php 
                                                    $tanggal1 = strtotime($view->start_date);
                                                    $dt = date("d F Y  ", $tanggal1);
                                                    $tanggal2 = strtotime($view->end_date);
                                                    $dt2 = date("d F Y  ", $tanggal2);
                                                    echo $dt.' - '.$dt2;?>
                                            </td>
                                            <td class="text-center"><?=$view->total_days;?></td>
                                            <td class="text-center"><?=$view->total_days_holiday;?></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"></td>
                                            <td>
                                                    <a href="#" title="Sedang Diproses"><button class="btn btn-info">Sedang Diproses</button></a>
                                                    <a href="#" title="Telah Dibayar"><button class="btn btn-success">Sudah Dibayar</button></a>
                                               
                                            </td>
                                        </tr>
                                        <?php $no++;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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