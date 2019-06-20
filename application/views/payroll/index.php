
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
                            <a href="#" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-plus"></i> </a>
                            <li><a href="javascript:void(0)">Payroll</a></li>
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
                            <h3 class="box-title m-b-0" style="font-weight: normal;">Data Export</h3>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Division</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_employee as $view){
                                            $get_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                            $get_division = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$view->nik;?></td>
                                            <td><?php if($view->firstname!=''){echo $view->firstname;};?></td>
                                            <td><?php if($get_division){echo $get_division[0]->division_name;}?></td>
                                            <td><?php if($get_division){echo $get_jabatan[0]->nama_jabatan;}?></td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>payroll/process/<?=$view->id_employee.'/'.$data_payroll[0]->id_payroll_detail;?>" class="btn btn-mini" title="Process" ><i class="icon-check"></i></a>
                                                <a href="<?=base_url()?>payroll/print_slip/<?=$view->id_employee.'/08';?>" class="btn btn-mini" title="Slip Gaji" ><i class="icon-calculator"></i></a>
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