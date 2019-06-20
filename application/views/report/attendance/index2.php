
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
                            <li><a href="javascript:void(0)">Absensi Karyawan</a></li>
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
                            <form method="post" action="<?=base_url()?>report/ob">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <select class="form-control p-0" id="input15" name="departemen">
                                        <option value="9" >General Affair</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input class="form-control input-daterange-datepicker" type="text" id="input12" required name="tanggal" value="<?=$tanggal_start2.' - '.$tanggal_end2;?>" style="width: 300px">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" name="filter" class="btn btn-mini" title="Filter"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            </form>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Terlambat</th>
                                            <th>Jam Keluar</th>
                                            <th>Total Jam</th>
                                            <th>Sebelum Jam Kerja</th>
                                            <th>Jam Kerja</th>
                                            <th>Lebih Jam</th>
                                            <th>Kurang Jam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1;
                                            if($departemen==''){
                                                $data_kehadiran = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_absensi=b.id_absensi AND b.absensi_date>='$tanggal_start' AND b.absensi_date<='$tanggal_end' GROUP BY CONCAT(a.firstname, '-', b.absensi_date) ASC")->result();
                                            }else{
                                                $data_kehadiran = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_division='$departemen' AND a.id_absensi=b.id_absensi AND b.absensi_date>='$tanggal_start' AND b.absensi_date<='$tanggal_end' GROUP BY CONCAT(a.firstname, '-', b.absensi_date) ASC")->result();
                                            }
                                            foreach($data_kehadiran as $view){
                                            $data_keluar = $this->db->query("SELECT * FROM employee_absensi  WHERE id_absensi='$view->id_absensi' AND absensi_date='$view->absensi_date' ORDER BY id_employee_absensi DESC")->result();
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->id_position'")->result();
                                            $tgl_skrg = date('Y-m-d');  
                                            $datetime1 = new DateTime($data_keluar[0]->absensi_time);
                                            $datetime2 = new DateTime($view->absensi_time);
                                            $interval = $datetime1->diff($datetime2);                                         
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$view->nik;?></td>
                                            <td><?=$view->firstname;?></td>
                                            <td><?php if($data_division){echo $data_division[0]->division_name;}else{echo '-';}?></td>
                                            <td><?php if($data_jabatan){echo $data_jabatan[0]->nama_jabatan;}else{echo '-';}?></td>
                                            <td><?php $tanggal = strtotime($view->absensi_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td><?=$view->absensi_time;?></td>
                                            <td></td>
                                            <td><?php if($view->absensi_date<$tgl_skrg){echo $data_keluar[0]->absensi_time;}else{echo '-';}?></td>
                                            <td><?=$interval->format('%h jam %i menit');?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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