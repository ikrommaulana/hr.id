
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
                            <li><a href="javascript:void(0)">Daftar Pengajuan Cuti</a></li>
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
                            <div class="row">
                                <a class="btn icon-btn btn-info" href="#"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-info"></span>Cuti</a>
                                <a class="btn icon-btn btn-default" href="<?=base_url()?>piket/daftar"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Piket</a>
                                <a class="btn icon-btn btn-default" href="<?=base_url()?>dinas/daftar_pengajuan"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Dinas</a>
                            </div><br>
                            <div class="table-responsive">
                                <table id="myTable" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Staf</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_permit as $view){
                                            $id_permit = $view->id_permit;
                                            $status_cuti = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();
                                            $status_batal = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status_batal=1")->result();
                                            $status_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=1")->result();
                                            if($status_batal){
                                                $status = 'Telah Dibatalkan';
                                            }elseif($status_cuti){
                                                $jml_approver = count($status_cuti);
                                                $status_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=1 ORDER BY updated_date DESC")->result();
                                                if($status_approve){
                                                    $jml_approve = count($status_approve);
                                                    if($jml_approver==$jml_approve){
                                                        $status = 'Telah Disetujui';
                                                    }else{
                                                        $status = 'Menunggu Persetujuan';
                                                    }
                                                }else{
                                                    $status_not_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=2")->result();
                                                    if($status_not_approve){
                                                        $status = 'Tidak Disetujui';
                                                    }else{
                                                        $status = 'Menunggu Persetujuan';   
                                                    }
                                                }
                                            }

                                            $karyawan = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$view->id_employee'")->result();
                                            $jenis_cuti = $this->db->query("SELECT jenis_cuti as cuti FROM cuti WHERE id_cuti='$view->id_cuti'")->result();
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$karyawan[0]->nama;?></td>
                                            <td><?=$jenis_cuti[0]->cuti;?></td>
                                            <td>
                                                <?php 
                                                    $tanggal1 = strtotime($view->start_date);
                                                    $dt = date("d F Y  ", $tanggal1);
                                                    $tanggal2 = strtotime($view->end_date);
                                                    $dt2 = date("d F Y  ", $tanggal2);
                                                    echo $dt.' - '.$dt2;?>
                                            </td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <a href="<?=base_url()?>permit_/detail/<?=$view->id_permit;?>" title="Lihat Detail"><i class="mdi mdi-eye" style="font-size: 25px; color:#999"></i></a>
                                                <?php 
                                                    $tgl_skr = date('Y-m-d'); 
                                                    $mulai_cuti = $view->start_date;
                                                    if($status=='Telah Disetujui' && $tgl_skr<=$mulai_cuti){?>
                                                        <a href="<?=base_url()?>permit_/batal/<?=$view->id_permit;?>" title="batalkan"><i class="mdi mdi-close" style="font-size: 25px; color:#999"></i></a>
                                                <?php }?>
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