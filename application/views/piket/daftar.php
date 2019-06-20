
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
                            <li><a href="javascript:void(0)">Daftar Pengajuan Piket</a></li>
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
                                <a class="btn icon-btn btn-info" href="<?=base_url()?>permit/daftar"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-white"></span>Cuti</a>
                                <a class="btn icon-btn btn-default" href="#"><span class="glyphicon btn-glyphicon glyphicon-ok img-circle text-info"></span>Piket</a>
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
                                            <th>Status Pengajuan</th>
                                            <th>Status Laporan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_piket as $view){
                                            $id_piket = $view->id_piket;
                                            $status_report = $view->report_approve;
                                            if($status_report==0){
                                                $status_report_piket = 'Menunggu Persetujuan Anda';
                                            }elseif($status_report==1){
                                                $status_report_piket = 'Telah Anda Setujui';
                                            }else{
                                                $status_report_piket = 'Telah Anda Tolak';    
                                            }
                                            
                                            $tanggalstart[$no] = strtotime($view->start_date);
                                            $dtstart[$no] = date("d F Y  ", $tanggalstart[$no]);
                                            $tanggalend[$no] = strtotime($view->end_date);
                                            $dtend[$no] = date("d F Y  ", $tanggalend[$no]);
                                            $status_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
                                            $status_batal = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status_batal=1")->result();
                                            $status_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=1")->result();
                                            if($status_batal){
                                                $status = 'Telah Dibatalkan';
                                            }elseif($status_piket){
                                                $jml_approver = count($status_piket);
                                                $status_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=1 ORDER BY updated_date DESC")->result();
                                                if($status_approve){
                                                    $jml_approve = count($status_approve);
                                                    if($jml_approver==$jml_approve){
                                                        $status = 'Telah Disetujui';
                                                    }else{
                                                        $status = 'Menunggu Persetujuan';
                                                    }
                                                }else{
                                                    $status_not_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND status=2")->result();
                                                    if($status_not_approve){
                                                        $status = 'Tidak Disetujui';
                                                    }else{
                                                        $status = 'Menunggu Persetujuan';   
                                                    }
                                                }
                                            }

                                            $karyawan = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$view->id_employee'")->result();
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$karyawan[0]->nama;?></td>
                                            <td>Piket</td>
                                            <td>
                                                <?= $dtstart[$no].' - '.$dtend[$no];?>
                                            </td>
                                            <td><?=$status;?></td>
                                            <td><?=$status_report_piket;?></td>
                                            <td>
                                                <a href="<?=base_url()?>piket/detail/<?=$view->id_piket;?>" title="Lihat Detail"><i class="mdi mdi-eye" style="font-size: 25px; color:#999"></i></a>
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