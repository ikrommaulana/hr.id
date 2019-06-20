
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
                        
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                
                <!--row -->
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div>
                                <div class="wizard-content">
                                    <div>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <div class="col-md-2">
                                                            <div class="row">
                                                                <div> <img class="img-responsive" alt="user" src="<?=base_url()?>plugins/images/big/img2.jpg">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div>
                                                                    <a href="<?=base_url()?>karyawan/karyawan" style="width: 100%" class="btn btn-success btn-rounded waves-effect waves-light m-t-20">Ajukan Karyawan</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <style type="text/css">
                                                                .counter2{
                                                                    font-size: 14px;
                                                                    color: #f1f1f1
                                                                }
                                                            </style>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="white-box">
                                                                        <div class="row row-in">
                                                                            <div class="col-lg-2 col-sm-6 row-in-br">
                                                                                <ul class="col-in">
                                                                                    <li>
                                                                                        <span class="circle circle-md bg-info"><i class="ti-ticket"></i></span>
                                                                                    </li>
                                                                                    <li>
                                                                                        <h4>Total Pengajuan Karyawan</h4>
                                                                                        <h3 class="counter counter2 text-right m-t-15"><?php if($data_request){$jml = count($data_request); echo $jml;}else{echo 0;}?></h3>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--row -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <!-- .row -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="white-box">
                                                                <div class="table-responsive manage-table">
                                                                    <table class="table" cellspacing="14">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="150">NO</th>
                                                                                <th>JUMLAH</th>
                                                                                <th>PERSYARATAN</th>
                                                                                <th>STATUS</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $no=1; foreach($data_request as $view){
                                                                                $cek_approve = $this->db->query("SELECT * FROM recrutment_request_approve WHERE id_recruitment_request='$view->id_recruitment_request'")->result();
                                                                                if($cek_approve){
                                                                                    $status = $cek_approve[0]->status;    
                                                                                }else{
                                                                                    $status = 0;
                                                                                }
                                                                                
                                                                                ?>
                                                                            <tr class="advance-table-row">
                                                                                <td><?=$no;?></td>
                                                                                <td><?=$view->recruit_total;?></td>
                                                                                <td><?=$view->requirement;?></td>
                                                                                <td><?php if($status==0){echo 'Menunggu Persetujuan';}else{echo 'Telah Disetujui';}?></td>
                                                                                <td><a href="<?=base_url()?>karyawan/detail/<?=$view->id_recruitment_request;?>" title="Lihat Detail"><i class="mdi mdi-eye" style="font-size: 25px; color:#999"></i></a></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="7" class="sm-pd"></td>
                                                                            </tr>
                                                                            <?php $no++;}?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /row -->
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                
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