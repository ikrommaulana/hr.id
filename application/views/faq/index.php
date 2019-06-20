<?php if($role_id==1 || $role_id==2){?>
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
                <?=$this->session->flashdata('notifikasi')?>
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
                                                        <!-- .row -->
                                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                                        <script> 
                                                        $(document).ready(function(){
                                                            $("#flip1").click(function(){
                                                                $("#panel1").slideToggle("slow");
                                                            });

                                                            $("#flip2").click(function(){
                                                                $("#panel2").slideToggle("slow");
                                                            });
                                                        });
                                                        </script>
                                                        <style> 
                                                        .paneljudul, .panelisi {
                                                            padding: 5px;
                                                            text-align: left;
                                                            background-color: #f1f1f1;
                                                            border: solid 1px #c3c3c3;
                                                        }

                                                        .panelisi {
                                                            padding: 10px;
                                                            display: none;
                                                            background-color: #fff;
                                                        }
                                                        </style>

                                                        <div id="flip1" class="paneljudul">Cara mengajukan piket</div>
                                                        <div id="panel1" class="panelisi">
                                                            1.Klik menu piket<br>
                                                            2.Klik ajukan piket<br>
                                                            3.Isi form pengajuan<br>
                                                            4.Klik ajukan<br>
                                                            5.Piket dikerjakan minimal 5 jam, setelah piket karyawan membuat laporan dengan mengklik tombol buat laporan pada tabel piket<br>
                                                            6.Setelah laporan diterima atasan dan pengajuan dana piket telah disetujui, karyawan dapat mengajukan pencairan dana kepada bagian keuangan dengan mencetak surat piket 
                                                        </div>
                                                        <div id="flip2" class="paneljudul">Cara menugaskan piket</div>
                                                        <div id="panel2" class="panelisi">
                                                            1.Klik menu piket<br>
                                                            2.Klik ajukan piket<br>
                                                            3.Isi form pengajuan<br>
                                                            4.Klik ajukan
                                                        </div>
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
<?php }else{
    redirect('error');
}?>