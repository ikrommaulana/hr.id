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
                                            <th>NS</th>
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
                                             
                                            $status_atasan = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
                                            $status_a = $status_atasan[0]->status;
                                            $status_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='0' AND status!='2'")->result();
                                            if($status_dana){
                                                $status_b = 'Menunggu Persetujuan';    
                                            }else{
                                                $status_dana2 = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='2'")->result();
                                                if($status_dana2){
                                                    $status_b = 'Ditolak';
                                                }else{
                                                    $status_b = 'Telah Disetujui';
                                                }
                                                //$status_b = (isset($status_dana2))? 'Ditolak' : 'Telah Disetujui';
                                            }
                                            
                                            $data_telekomunikasi = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=1")->result();
                                            $data_bandara = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=2")->result();
                                            $data_makan = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=3")->result();
                                            
                                            $telpon = (isset($data_telekomunikasi[0]->biaya))? $data_telekomunikasi[0]->biaya : 0;
                                            $bandara = (isset($data_bandara[0]->biaya))? $data_bandara[0]->biaya : 0;
                                            $makan = (isset($data_makan[0]->biaya))? $data_makan[0]->biaya : 0;
                                            
                                            
                                            $tot_hari = $view->total_days;
                                            $total = ($tot_hari * $makan) + $telpon + $bandara;
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$id_dinas;?></td>
                                            <td><?=$view->no_surat;?></td>
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
                                            <td><?php if($status_a==0){echo 'Menunggu Persetujuan';}elseif($status_a==1){echo 'Telah Disetujui';}else{echo 'Ditolak';};?></td>
                                            <td><?=$status_b;?></td>
                                            <td class="text-right"><?=number_format($total);?></td>
                                            <td>
                                                    <a href="#" title="Sedang Diproses"><i class="icon-energy"></i></a>
                                                    <a href="#" title="Bayar"><i class="icon-check"></i></a>
                                               
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