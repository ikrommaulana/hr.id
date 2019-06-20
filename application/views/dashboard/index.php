<?php if($role_id==1 || $role_id==2){?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<?php 
    $data_gender_cw = $this->db->query("SELECT * FROM employee WHERE gender='0'")->result();
    $data_gender_co = $this->db->query("SELECT * FROM employee WHERE gender='1'")->result();
    $jml_cw = count($data_gender_cw);
    $jml_co = count($data_gender_co);

    $get_usia = $this->db->query("SELECT YEAR(curdate()) - YEAR(date_birth) AS usia, YEAR(curdate()) - YEAR(join_date) AS masa  FROM employee WHERE status_hapus='0'")->result();
    $tot_usia = 0;
    $tot_masa = 0;
    if($get_usia){
        $jum_karyawan = count($get_usia);
        foreach($get_usia as $view){
            $tot_usia += $view->usia;
        }
        $ave_usia = $tot_usia / $jum_karyawan;

        foreach($get_usia as $view2){
            $tot_masa += $view2->masa;
        }
        $ave_masa = $tot_masa / $jum_karyawan;
    }
?>
<script type="text/javascript">
    $(function () {
        $(document).ready(function() {
            Highcharts.chart('cont', {
            credits: {
                enabled: false
            },
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            series: [{
                name: 'Jumlah ',
                data: [
                    ['Wanita', <?=$jml_cw;?>],
                    ['Laki-laki', <?=$jml_co;?>]
                ]
            }]
            });
        });
    });
</script>
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
                            <li><a href="javascript:void(0)">Dashboard</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div class="row row-in">
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                    <a href="<?=base_url()?>employee">
                                        <li>
                                            <span class="circle circle-md bg-danger"><i class="ti-user"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="counter text-right m-t-15"><?=$total_karyawan;?></h3>
                                        </li>
                                        <li class="col-middle">
                                            <h4>Total Karyawan</h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                                    <ul class="col-in">
                                        <a href="<?=base_url()?>cuti/daftar">
                                        <li>
                                            <span class="circle circle-md bg-info"><i class="ti-wallet"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="counter text-right m-t-15"><?=$total_cuti;?></h3>
                                        </li>
                                        <li class="col-middle">
                                            <h4>Total Cuti Hari Ini</h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                        </a>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-success"><i class="ti-briefcase"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="text-right m-t-15">
                                            <a href="<?=base_url()?>dinas/daftar"><span style="color:#00FF00"><?=$total_dinas;?></span></a>/<a href="<?=base_url()?>dinas/daftar2"><span style="color:#FF0000"><?=$total_dinas_blm_approve;?></span></a>
                                            </h3>
                                        </li>
                                        <li class="col-middle">
                                            <h4>Perjalanan Dinas</h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6  b-0">
                                    <ul class="col-in">
                                        <a href="<?=base_url()?>event/daftar">
                                        <li>
                                            <span class="circle circle-md bg-warning"><i class="ti-calendar"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="counter text-right m-t-15"><?=$total_agenda;?></h3>
                                        </li>
                                        <li class="col-middle">
                                            <h4>Agenda Hari Ini</h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row -->
                <!-- /.row -->
                <style type="text/css">
                    .glyphicon.glyphicon-one-fine-dot:before {
                        content: "\25cf";
                        font-size: 1.5em;
                    }
                </style>
                <div class="row">
                    <div class="col-md-12 col-lg-9 col-sm-12 col-xs-12">
                        <div class="white-box">
                        <?php 
                            $skrg = date('Y-m-d');
                            /*$jml_hadir_skrg = $this->db->query("SELECT * FROM employee_absensi WHERE absensi_date='$skrg' GROUP BY id_absensi")->num_rows();*/
                            $hadir = $this->db->query("SELECT * FROM employee a, employee_absensi b WHERE a.id_absensi=b.id_absensi AND b.absensi_date='$skrg' GROUP BY a.firstname ASC")->num_rows();
                        ?>
                            <h3 class="box-title" style="color: #999">Kehadiran Karyawan Hari Ini <span style="color: #666; margin-left: 10px; font-size: 30px"><?=$hadir;?></span></h3>
                            <div class="row">
                                <form action="<?=base_url()?>home/filt" method="post">
                                <div class="col-sm-3" style="text-align: right"><span class="glyphicon glyphicon-one-fine-dot" style="color:#2EFEF7"> </span> Jumlah karyawan</div>
                                <div class="col-sm-2"><span class="glyphicon glyphicon-one-fine-dot" style="color:#0080FF"></span> Jumlah hadir</div>
                                <div class="col-sm-3">
                                    <select name="bulan" class="form-control">
                                        <option value="1" <?php if($bulan==1){echo 'selected';} ;?>>Januari</option>
                                        <option value="2" <?php if($bulan==2){echo 'selected';} ;?>>Februari</option>
                                        <option value="3" <?php if($bulan==3){echo 'selected';} ;?>>Maret</option>
                                        <option value="4" <?php if($bulan==4){echo 'selected';} ;?>>April</option>
                                        <option value="5" <?php if($bulan==5){echo 'selected';} ;?>>Mei</option>
                                        <option value="6" <?php if($bulan==6){echo 'selected';} ;?>>Juni</option>
                                        <option value="7" <?php if($bulan==7){echo 'selected';} ;?>>Juli</option>
                                        <option value="8" <?php if($bulan==8){echo 'selected';} ;?>>Agustus</option>
                                        <option value="9" <?php if($bulan==9){echo 'selected';} ;?>>September</option>
                                        <option value="10" <?php if($bulan==10){echo 'selected';} ;?>>Oktober</option>
                                        <option value="11" <?php if($bulan==11){echo 'selected';} ;?>>Nopember</option>
                                        <option value="12" <?php if($bulan==12){echo 'selected';} ;?>>Desember</option>    
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="tahun" class="form-control">
                                        <option value="2019" <?php if($tahun==2019){echo 'selected';} ;?>>2019</option>
                                        <option value="2018" <?php if($tahun==2018){echo 'selected';} ;?>>2018</option>
                                        <option value="2017" <?php if($tahun==2017){echo 'selected';} ;?>>2017</option>    
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" name="save" class="btn btn-mini" title="Cari"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-sm-1">
                                    <a href="<?=base_url()?>home/detail/<?=$bulan.'/'.$tahun;?>" type="submit" name="save" class="btn btn-eye" title="Detail"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </div>    
                                </form>
                            </div>
                            <div>
                                <canvas id="chart1" height="105"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Chart JS -->
                    <script src="<?=base_url()?>plugins/bower_components/Chart.js/Chart.min.js"></script>
                    <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12"><br>
                        <div class="panel">
                            <?php 
                                $jml = count($tidak_hadir);?>
                            <div class="panel-heading" style="background-color: #f1f1f1; color: #999">Tidak Hadir Hari Ini <span style="color: #666; margin-left: 10px; font-size: 30px"><?=$jml;?></span></div>
                            <div class="panel-body" style="height: 360px; overflow-y: <?php if($jml > 3){echo 'scroll';}?>">
                                <div class="steamline" style="height: 330px;">
                                    <?php 
                                        $now = date('Y-m-d');
                                        foreach($tidak_hadir as $view){  
                                            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_emp' AND status_hapus='0'")->result();
                                            $cek_dinas = $this->db->query("SELECT * FROM dinas WHERE id_employee='$view->id_emp' AND start_date<='$now' AND end_date>='$now'")->result();
                                            $cek_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE id_employee='$view->id_emp' AND a.id_permit=b.id_permit AND b.status_batal='0'  AND b.status!='2' AND start_date<='$now' AND end_date>='$now'")->result();
                                            if($cek_dinas){
                                                $ket = 'Perjalanan dinas';
                                            }elseif($cek_cuti){
                                                $id_cuti = $cek_cuti[0]->id_cuti;
                                                $get_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
                                                $ket = $get_cuti[0]->jenis_cuti;
                                            }else{
                                                $ket ='';
                                            }
                                            $gbr = $data_employee[0]->image;
                                            $id_divis = $data_employee[0]->id_division;
                                            $id_posi = $data_employee[0]->id_position;
                                            $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_divis'")->result();
                                            if($data_division){
                                                $division = $data_division[0]->division_name;
                                            }else{
                                                $division = '';
                                            }
                                            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_posi'")->result();
                                            if($data_jabatan){
                                                $jabatan = $data_jabatan[0]->nama_jabatan;
                                            }else{
                                                $jabatan = '';
                                            }
                                        if($data_employee){
                                    ?>
                                    <div>
                                        <div class="sl-left bg-success" style="overflow-y: hidden;"> <i><img style="border-radius:50% 50%; max-width: 100%;
                                            height: auto; width: auto;" src="<?=base_url()?>assets/images/<?php if($gbr!=''){echo $gbr;}else{echo 'admin.png';}?>" alt="user" /></i>
                                        </div>
                                        <div class="sl-right">
                                            <div><a href="#"><?=$data_employee[0]->firstname;?></a> <span class="sl-date"></span></div>
                                            <div class="desc">
                                            <?php if($jabatan!=$division){echo $jabatan.' '.$division;}else{echo $jabatan;}?><br>
                                            <i><?=$ket;?></i>    
                                            </div>
                                        </div>
                                    </div>
                                    <?php }}?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title" style="color: #999">Komposisi Gender</h3>
                            <div id="cont" style="height: 285px;"></div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <p style="color: #999">Rata-rata usia</p>
                            
                            <div id="ct-vis" style="height: 122px;"><h1><b><?=round($ave_usia,1);?> tahun</b></h1></div>

                            <p style="color: #999">Rata-rata masa kerja</p>
                            
                            <div id="ct-vis" style="height: 140px;"><h1><b><?=round($ave_masa,2);?> tahun</b></h1></div>
                        </div>
                    </div>
                </div>
                <!-- wallet, & manage users widgets -->
                <!-- ============================================================== -->
                <!-- .row -->
                <div class="row">
                    <!-- col-md-9 -->
                    <div class="col-md-8 col-lg-9">
                        
                    </div>
                    <!-- /col-md-9 -->
                    <!-- col-md-3 -->
                    <div class="col-md-4 col-lg-3" style="display: none">
                        <div class="panel wallet-widgets">
                            <div class="panel-body">
                                <ul class="side-icon-text">
                                </ul>
                            </div>
                            <div id="morris-area-chart2" style="height:208px; display: none;"></div>
                            <ul class="wallet-list">
                            </ul>
                        </div>
                    </div>
                    <!-- /col-md-3 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Profile, & inbox widgets -->
                <!-- ============================================================== -->
                <!-- calendar & todo list widgets -->
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- Blog-component -->
                
                <!-- ============================================================== -->
                <!-- start right sidebar -->
                <!-- ============================================================== -->
                <!--<div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="gray" class="yellow-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="full-width"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="gray-dark" class="yellow-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme working">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/ritesh.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/john.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/pawandeep.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                <!-- ============================================================== -->
                <!-- end right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- /.container-fluid -->
            <?php 
                    $jumlah_karyawan = $this->db->query("SELECT * FROM employee WHERE status_hapus='0'");
                    $jml = $jumlah_karyawan->num_rows();
                    $jumlah_hari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

                ?>
            
<script type="text/javascript">
    $( document ).ready(function() {
    
    var ctx1 = document.getElementById("chart1").getContext("2d");
    var data1 = {
        labels: [
                <?php for($i=1; $i<=$jumlah_hari; $i++){
                    echo $i.',';
                } ?>
        ],
        datasets: [
            {
                label: "My Second dataset",
                fillColor: "rgba(243,245,246,0.9)",
                strokeColor: "#81F7F3",
                pointColor: "#81F7F3",
                pointStrokeColor: "#81F7F3",
                pointHighlightFill: "#81F7F3",
                pointHighlightStroke: "rgba(243,245,246,0.9)",
                data: [<?php for($i=1; $i<=$jumlah_hari; $i++){
                    echo $jml.',';
                } ?>]
            },
            {
                label: "My First dataset",
                fillColor: "#A9E2F3",
                strokeColor: "rgba(44,171,227,0.8)",
                pointColor: "rgba(44,171,227,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(44,171,227,1)",
                data: [<?php for($j=1; $j<=$jumlah_hari; $j++){
                        $tgl = $tahun.'-'.$bulan.'-'.$j;
                        $jml_hadir = $this->db->query("SELECT * FROM employee_absensi WHERE absensi_date='$tgl' GROUP BY id_absensi")->num_rows();
                        echo $jml_hadir.',';
                    } ?>]
            }
            
        ]
    };
    
    var chart1 = new Chart(ctx1).Line(data1, {
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.005)",
        scaleGridLineWidth : 0,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        bezierCurve : true,
        bezierCurveTension : 0.4,
        pointDot : true,
        pointDotRadius : 4,
        pointDotStrokeWidth : 1,
        pointHitDetectionRadius : 2,
        datasetStroke : true,
        tooltipCornerRadius: 2,
        datasetStrokeWidth : 2,
        datasetFill : true,
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true
    });
    
    
});
</script>   
<?php }else{
    redirect('index');
}?>