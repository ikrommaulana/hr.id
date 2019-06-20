<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" />
<style type="text/css">
    /*-------------------------
Please follow me @maridlcrmn
/*-------------------------*/


.material-button-anim {
  position: relative;
  padding: 65px 15px 27px;
  text-align: center;
  max-width: 320px;
  margin: 0 auto 20px;
}

.material-button {
    position: relative;
    top: 0;
    z-index: 1;
    width: 70px;
    height: 70px;
    font-size: 1.5em;
    color: #fff;
    background: #2C98DE;
    border: none;
    border-radius: 50%;
    box-shadow: 0 3px 6px rgba(0,0,0,.275);
    outline: none;
}
.material-button-toggle {
    z-index: 3;
    width: 90px;
    height: 90px;
    margin: 0 auto;
}
.material-button-toggle span {
    -webkit-transform: none;
    transform:         none;
    -webkit-transition: -webkit-transform 3s cubic-bazier(.175,.67,.83,.67);
    transition:         transform 3s cubic-bazier(.175,.67,.83,.67);
}
.material-button-toggle.open {
    -webkit-transform: scale(1.3,1.3);
    transform:         scale(1.3,1.3);
    -webkit-animation: toggleBtnAnim 3s;
    animation:         toggleBtnAnim 3s;
}
.material-button-toggle.open span {
    -webkit-transform: rotate(45deg);
    transform:         rotate(45deg);
    -webkit-transition: -webkit-transform 3s cubic-bazier(.175,.67,.83,.67);
    transition:         transform 3s cubic-bazier(.175,.67,.83,.67);
}

#options {
  height: 70px;
}
.option {
    position: relative;
}
.option .option1,
.option .option2,
.option .option3 {
    filter: blur(5px);
    -webkit-filter: blur(5px);
    -webkit-transition: all .175s;
    transition:         all .175s;
}
.option .option1 {
    -webkit-transform: translate3d(90px,90px,0) scale(.8,.8);
    transform:         translate3d(90px,90px,0) scale(.8,.8);
}
.option .option2 {
    -webkit-transform: translate3d(0,90px,0) scale(.8,.8);
    transform:         translate3d(0,90px,0) scale(.8,.8);
}
.option .option3 {
    -webkit-transform: translate3d(-90px,90px,0) scale(.8,.8);
    transform:         translate3d(-90px,90px,0) scale(.8,.8);
}
.option.scale-on .option1, 
.option.scale-on .option2,
.option.scale-on .option3 {
    filter: blur(0);
    -webkit-filter: blur(0);
    -webkit-transform: none;
    transform:         none;
    -webkit-transition: all .175s;
    transition:         all .175s;
}
.option.scale-on .option2 {
    -webkit-transform: translateY(-28px) translateZ(0);
    transform:         translateY(-28px) translateZ(0);
    -webkit-transition: all .175s;
    transition:         all .175s;
}

@keyframes toggleBtnAnim {
    0% {
        -webkit-transform: scale(1,1);
        transform:         scale(1,1);
    }
    25% {
        -webkit-transform: scale(1.4,1.4);
        transform:         scale(1.4,1.4); 
    }
    75% {
        -webkit-transform: scale(1.2,1.2);
        transform:         scale(1.2,1.2);
    }
    100% {
        -webkit-transform: scale(1.3,1.3);
        transform:         scale(1.3,1.3);
    }
}
@-webkit-keyframes toggleBtnAnim {
    0% {
        -webkit-transform: scale(1,1);
        transform:         scale(1,1);
    }
    25% {
        -webkit-transform: scale(1.4,1.4);
        transform:         scale(1.4,1.4); 
    }
    75% {
        -webkit-transform: scale(1.2,1.2);
        transform:         scale(1.2,1.2);
    }
    100% {
        -webkit-transform: scale(1.3,1.3);
        transform:         scale(1.3,1.3);
    }
}

.panel-table {
    display:table;
}
.panel-table > .panel-heading {
    display: table-header-group;
    background: transparent;
}
.panel-table > .panel-body {
    display: table-row-group;
}
.panel-table > .panel-body:before,
.panel-table > .panel-body:after {
    content:none;
}
.panel-table > .panel-footer {
    display: table-footer-group;
    background: transparent;
}
.panel-table > div > .tr {
    display: table-row;
}
.panel-table > div:last-child > .tr:last-child > .td {
    border-bottom: none;
}
.panel-table .td {
    display: table-cell;
    padding: 15px;
    border: 1px solid #ddd;
    border-top: none;
    border-left: none;
}
.panel-table .td:last-child {
    border-right: none;
}
.panel-table > .panel-heading > .tr > .td,
.panel-table > .panel-footer > .tr > .td {
    background-color: #f5f5f5;
}
.panel-table > .panel-heading > .tr > .td:first-child {
    border-radius: 4px 0 0 0;
}
.panel-table > .panel-heading > .tr > .td:last-child {
    border-radius: 0 4px 0 0;
}
.panel-table > .panel-footer > .tr > .td:first-child {
    border-radius: 0 0 0 4px;
}
.panel-table > .panel-footer > .tr > .td:last-child {
    border-radius: 0 0 4px 0;
}
</style>
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
                <?php
                    $id_employee = $this->session->userdata('user_id');
                    $data_user = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                    $gbr = $data_user[0]->image;
                    $jml_todo_on = count($todolist_on);
                ?>
                <div class="row">
                    <div class="col-md-4 col-xs-12" style="position: fixed">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="<?=base_url()?>assets/images/<?php if($gbr){echo $gbr;}else{echo 'admin.png';}?>">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="<?=base_url()?>assets/images/<?php if($gbr){echo $gbr;}else{echo 'admin.png';}?>" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white"><?=$data_user[0]->firstname;?></h4>
                                        <h5 class="text-white"><?=$data_user[0]->email;?></h5> </div>
                                </div>
                            </div>
                            <!--<div class="user-btm-box">
                                <div class="col-md-4 col-sm-4">
                                    <p style="font-size: 70px"><a href="<?=base_url()?>permit"><i class="ti-briefcase fa-fw" title="Ajukan Cuti"></i></a></p>
                                    <h6></h6>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p style="font-size: 70px"><a href="<?=base_url()?>piket"><i class="ti-layout fa-fw" title="Ajukan Piket"></i></a></p>
                                    <h6></h6>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p style="font-size: 70px"><a href="<?=base_url()?>dinas"><i class="ti-car fa-fw"></i></a></p>
                                    <h6></h6>
                                </div>
                            </div>-->
                            <div class="row">
                              <div class="col-md-12 col-sm-12">
                                <div class="material-button-anim">
                                  <ul class="list-inline" id="options">
                                    <li class="option"><a href="<?=base_url()?>permit_">
                                      <button class="material-button option1" type="button">
                                        <span class="fa fa-briefcase" aria-hidden="true"></span>
                                        <p style="font-size:12px">cuti</p>
                                      </button></a>
                                    </li>
                                    <li class="option"><a href="<?=base_url()?>piket">
                                      <button class="material-button option2" type="button">
                                        <span class="fa fa-book" aria-hidden="true"></span>
                                        <p style="font-size:12px">piket</p>
                                      </button></a>
                                    </li>
                                    <li class="option"><a href="<?=base_url()?>dinas">
                                      <button class="material-button option3" type="button">
                                        <span class="fa fa-car" aria-hidden="true"></span>
                                        <p style="font-size:12px">dinas</p>
                                      </button></a>
                                    </li>
                                  </ul><br>
                                  <button class="material-button material-button-toggle" type="button" data-toggle="modal" data-target="#Modal2">
                                    <span class="fa fa-plus" aria-hidden="true"></span>
                                    <p style="font-size:12px">tugas</p>
                                  </button>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade bs-example-modal-lg" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top: 50px">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="padding: 30px">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myLargeModalLabel">Buat Tugas</h4> 
                                </div>
                                <form class="floating-labels" method="post" action="<?=base_url()?>index/add_edit_tugas/" enctype="multipart/form-data">
                                <div class="modal-body"><br>
                                    <div class="row">
                                        <div class="form-group m-b-40 col-sm-6">
                                            <input type="text" class="form-control" id="input3" name="tugas" required ><span class="highlight"></span> <span class="bar"></span>
                                            <label for="input3">Tugas</label>
                                        </div>
                                        <div class="form-group m-b-40 col-sm-6">
                                            <input type="text" class="form-control" id="datepicker-autoclose" name="batas_waktu" required><span class="highlight"></span> <span class="bar"></span>
                                            <label for="datepicker-autoclose">Batas Waktu</label>
                                        </div>
                                    </div>
                                    <p>Untuk :</p><br>
                                    <div class="row">
                                        <?php if($id_jabatan==5 || $id_jabatan==4){?> <!--staff, manager-->
                                        <div class="form-group m-b-40 col-sm-6">
                                            <select class="form-control p-0" id="input5" required name="division">
                                                <option value=""></option>
                                                <?php foreach($data_divisi as $view){?>
                                                <option value="<?=$view->id_division;?>"><?=$view->division_name;?></option>
                                                <?php }?>
                                            </select><span class="highlight"></span> <span class="bar"></span>
                                            <label for="input5">Departemen Lain</label>
                                        </div>
                                        <?php }?>
                                        <?php if($id_jabatan==4){
                                            $satu_divisi = $this->db->query("SELECT * FROM employee WHERE id_employee!='$user_id' AND id_division='$id_division' AND id_position='5' ORDER BY firstname ASC")->result();
                                            ?> <!--manager-->
                                        <div class="form-group m-b-40 col-sm-6">
                                            <select class="form-control p-0" id="input6" required name="bawahan">
                                                <option value=""></option>
                                                <?php if($satu_divisi){foreach($satu_divisi as $view){?>
                                                <option value="<?=$view->id_employee;?>"><?=$view->firstname;?></option>
                                                <?php }}?>
                                            </select><span class="highlight"></span> <span class="bar"></span>
                                            <label for="input6">Bawahan</label>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="text-right">
                                            <button type="submit" name="save" class="btn btn-success waves-effect waves-light m-r-10"onclick="return check()">Simpan</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <script>
                              $(function() {
                                $("#input4").mydatepicker({autoclose: true});
                              });
                            </script>
                                    <!-- /.modal-content -->
                        </div>
                                <!-- /.modal-dialog -->
                    </div>
                    <script>
                  function check(){
                    $(".form-control").removeAttr('required');
                    return true;
                  }
                  </script>

                    <div class="col-md-8 col-xs-12" style="float: right; min-height: 500px">
                        <div class="white-box">
                            <ul class="nav nav-tabs tabs customtab">
                                <?php if($upmanager=='0'){?>
                                <li class="<?php if($tab==''){echo 'active';}?> tab">
                                    <a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Uraian pekerjaan hari ini</span> </a>
                                </li>
                                <?php }?>
                                <li class="tab">
                                    <a href="#direktori" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Direktori</span> </a>
                                </li>
                                <li class=" <?php if($tab==4){echo 'active';}?> tab">
                                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Pengaturan</span> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <?php if($upmanager=='0'){?>
                                <div class="tab-pane <?php if($tab==''){echo 'active';}?>" id="home">
                                    <?php
                                        $tgl = date('Y-m-d');
                                        $cek_todo_today = $this->db->query("SELECT * FROM todolist WHERE id_employee='$id_employee' AND created_date='$tgl'")->result();
                                        $jum_todo_today = count($cek_todo_today);
                                        
                                        //$data_todo = $this->db->query("SELECT * FROM todolist WHERE id_employee='$id_employee' GROUP BY created_date ORDER BY id_todolist DESC")->result();
                                        $data_todo = $this->db->query("SELECT * FROM todolist WHERE id_employee='$id_employee' GROUP BY created_date ORDER BY id_todolist DESC LIMIT 7")->result();

                                    ?>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#todoModal"> Buat Uraian pekerjaan hari ini</button>
                                    <?php foreach($data_tugas as $view){
                                        $tanggal = strtotime($view->created_date); 
                                        $dt = date("d", $tanggal); 
                                        $dt2 = date("F Y  ", $tanggal);
                                        $dibuat = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->created_by'")->result();
                                    ?>
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div class="sl-left" style="background-color: #58FAF4"> <img src="" alt="<?=$dt;?>" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="javascript:void(0)" class="text-info"><?=$dt2;?></a> <span class="sl-date"> dibuat oleh <?=$dibuat[0]->firstname;?></span>
                                                    <table>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Dalam Proses</th>
                                                            <th>Selesai</th>
                                                            <th>Batas Waktu</th>
                                                        </tr>
                                                        <?php $no=1; foreach($data_tugas as $view2){
                                                            $tgl = strtotime($view2->batas_waktu); 
                                                            $dt3 = date("d F Y", $tgl); 
                                                            ?>
                                                        <tr>
                                                            <td><?=$no.' - ';?></td>
                                                            <td style="min-width: 350px; padding-left: 10px"><?=$view2->tugas;?></td>
                                                            <td></td>
                                                            <td style="min-width: 100px; text-align: center">
                                                                <input type="radio" name="tugas<?=$view2->id_tugas;?>" id="dalamt<?=$no;?>" value="<?=$view2->id_tugas;?>" <?php if($view2->status==0){echo 'checked';}?> onclick="return dalamt<?=$no;?>();"> 
                                                            </td>
                                                            <td style="min-width: 100px">
                                                                <input type="radio" name="tugas<?=$view2->id_tugas;?>" id="selesait<?=$no;?>" value="<?=$view2->id_tugas;?>" <?php if($view2->status==1){echo 'checked';}?>  onclick="return selesait<?=$no;?>();"> 
                                                            </td>
                                                            <td><?=$dt3;?></td>
                                                        </tr>
                                                        <script type="text/javascript">
                                                            function dalamt<?=$no;?>(){
                                                                id = $("#dalamt<?=$no;?>").val();
                                                                $.get( "<?= base_url(); ?>index/data_tugas_dalam" , { option : id } , function ( data ) {
                                                                    
                                                                  } ) ;
                                                            }
                                                        </script>
                                                        <script type="text/javascript">
                                                            function selesait<?=$no;?>(){
                                                                id = $("#selesait<?=$no;?>").val();
                                                                $.get( "<?= base_url(); ?>index/data_tugas_selesai" , { option : id } , function ( data ) {
                                                                    
                                                                  } ) ;
                                                            }
                                                        </script>
                                                        <?php $no++;}?>
                                                    </table>
                                                </div>
                                            </div><br>
                                        </div>
                                    </div>
                                    <?php }?>

                                    <?php foreach($data_todo as $view){
                                        $tanggal = strtotime($view->created_date); 
                                        $dt = date("d", $tanggal); 
                                        $dt2 = date("F Y  ", $tanggal);
                                        $data_todo2 = $this->db->query("SELECT * FROM todolist WHERE id_employee='$id_employee' AND created_date='$view->created_date'")->result();
                                        $now = date('Y-m-d');
                                    ?>
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="" alt="<?=$dt;?>" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="javascript:void(0)" class="text-info"><?=$dt2;?></a> <span class="sl-date"></span>
                                                    <table>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Dalam Proses</th>
                                                            <th>Selesai</th>
                                                            <th></th>
                                                        </tr>
                                                        <?php $no=1; foreach($data_todo2 as $view2){?>
                                                        <tr>
                                                            <td><?=$no;?></td>
                                                            <td style="min-width: 350px; padding-left: 10px"><?=$view2->keterangan;?></td>
                                                            <td></td>
                                                            <td style="min-width: 100px; text-align: center">
                                                                <input type="radio" name="todo<?=$view2->id_todolist;?>" id="dalam<?=$no;?>" value="<?=$view2->id_todolist;?>" <?php if($view2->status==0){echo 'checked';}?> <?php if($view2->created_date!=$now){echo 'disabled';}?> onclick="return dalam<?=$no;?>();"> 
                                                            </td>
                                                            <div class="row" id="check_data4"></div>
                                                            <td style="min-width: 100px">
                                                                <input type="radio" name="todo<?=$view2->id_todolist;?>" id="selesai<?=$no;?>" value="<?=$view2->id_todolist;?>" <?php if($view2->status==1){echo 'checked';}?> <?php if($view2->created_date!=$now){echo 'disabled';}?>  onclick="return selesai<?=$no;?>();"> 
                                                            </td>
                                                            <td style="min-width: 80px">
                                                                <div class="btn-group">
                                                                <?php if($view2->created_date==$now){?>
                                                                <a href="#" class="btn btn-mini" title="Perbarui" style="color: #dedede" onmouseover="this.style.color='#000'"  onmouseleave="this.style.color='#dedede'"><i class="icon-pencil"></i></a>
                                                                <a href="<?=base_url()?>index/hapus_todolist/<?=$view2->id_todolist;?>" onclick="return confirm('Anda yakin akan menghapus data ?')" class="btn btn-mini" title="Hapus" style="color: #dedede" onmouseover="this.style.color='#000'"  onmouseleave="this.style.color='#dedede'"><i class="icon-trash"></i></a>
                                                                <?php }?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <script type="text/javascript">
                                                            function dalam<?=$no;?>(){
                                                                id = $("#dalam<?=$no;?>").val();
                                                                $.get( "<?= base_url(); ?>index/data_todo_dalam" , { option : id } , function ( data ) {
                                                                    $( '#check_data4' ) . html ( data ) ;
                                                                  } ) ;
                                                            }
                                                        </script>
                                                        <script type="text/javascript">
                                                            function selesai<?=$no;?>(){
                                                                id = $("#selesai<?=$no;?>").val();
                                                                $.get( "<?= base_url(); ?>index/data_todo_selesai" , { option : id } , function ( data ) {
                                                                    
                                                                  } ) ;
                                                            }
                                                        </script>
                                                        <?php $no++;}?>
                                                    </table>
                                                </div>
                                            </div><br>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                                <?php }?>
                                
                                <div class="tab-pane <?php if($tab==2){echo 'active';}?>" id="messages">
                                    <?php $data_joblist = $this->db->query("SELECT * FROM joblist WHERE id_employee='$id_employee'ORDER BY id_joblist DESC")->result();

                                    ?>
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <?php $no=1; foreach($data_joblist as $view){
                                                $tanggal = strtotime($view->created_date); 
                                                $dt2 = date("d F Y  ", $tanggal);
                                            ?>
                                            <div class="sl-left"> <img src="" alt="<?=$no;?>" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="javascript:void(0)" class="text-info"></a> <span class="sl-date"><?=$dt2;?></span>
                                                    <table>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>action</th>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td><?=$no.' - ';?></td>
                                                            <td style="min-width: 400px; padding-left: 10px"><?=$view->keterangan;?></td>
                                                            <td style="min-width: 100px">
                                                                <?php if($view->status==0){echo 'On progress';}else{echo 'Done';}?>
                                                            </td>
                                                            <td>
                                                                <?php if($view->status==0){?>
                                                                    <a href="<?=base_url()?>index/joblist/1/<?=$view->id_joblist;?>" type="button" title="Done" class="btn btn-info btn-circle"><i class="fa fa-check"></i> </a>
                                                                <?php }else{?>
                                                                    <a href="<?=base_url()?>index/joblist/0/<?=$view->id_joblist;?>" type="button" title="On progress" class="btn btn-warning btn-circle"><i class="fa fa-times"></i> </a>
                                                                <?php }?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div><br>
                                            <?php $no++;}?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="direktori">
                                    <div class="row el-element-overlay m-b-40">
                                        <div class="col-md-12">
                                            <h4>Satu Departemen</h4>
                                            <hr>
                                        </div>
                                        <?php
                                            $data_karyawan = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.id_division='$id_division' AND a.id_position=b.id_jabatan ORDER BY a.id_position DESC")->result();
                                            $data_karyawan_all = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.id_division!='$id_division' AND a.id_position=b.id_jabatan ORDER BY a.id_position DESC")->result(); 
                                        ?>
                                        <!-- /.usercard -->
                                        <?php foreach($data_karyawan as $view){
                                            $divisi = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                            ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <div class="white-box">
                                                <div class="el-card-item">
                                                    <div class="el-card-avatar el-overlay-1"> <img src="<?=base_url()?>assets/images/<?php if($data_karyawan){if($view->image!=''){echo $view->image;}else{echo 'admin.png';}}?>" />
                                                        <div class="el-overlay">
                                                            <ul class="el-info">
                                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?=base_url()?>assets/images/<?php if($data_karyawan){if($view->image!=''){echo $view->image;}else{echo 'admin.png';}}?>"><i class="icon-magnifier"></i></a></li>
                                                                <li><a class="btn default btn-outline" href="<?=base_url()?>index"><i class="icon-link"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="el-card-content">
                                                        <h3 class="box-title"><?php if($data_karyawan){echo $view->firstname.' '.$view->lastname;}else{echo 'No name';}?></h3> <small><?php if($data_karyawan){echo $view->nama_jabatan.' ';}else{echo ' - ';} if($divisi){echo $divisi[0]->division_name;}?> </small>
                                                        <br/> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <!-- /.usercard-->
                                        <div class="col-md-12">
                                            <h4>Semua</h4>
                                            <hr>
                                        </div>
                                        <!-- /.usercard -->
                                        <?php foreach($data_karyawan_all as $view){
                                            $divisi = $this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result();
                                            ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <div class="white-box">
                                                <div class="el-card-item">
                                                    <div class="el-card-avatar el-overlay-1"> <img src="<?=base_url()?>assets/images/<?php if($data_karyawan){if($view->image!=''){echo $view->image;}else{echo 'admin.png';}}?>" />
                                                        <div class="el-overlay">
                                                            <ul class="el-info">
                                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="<?=base_url()?>assets/images/<?php if($data_karyawan){if($view->image!=''){echo $view->image;}else{echo 'admin.png';}}?>"><i class="icon-magnifier"></i></a></li>
                                                                <li><a class="btn default btn-outline" href="<?=base_url()?>index"><i class="icon-link"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="el-card-content">
                                                        <h3 class="box-title"><?php if($data_karyawan){echo $view->firstname.' '.$view->lastname;}else{echo 'No name';}?></h3> <small><?php if($data_karyawan){echo $view->nama_jabatan.' ';}else{echo ' - ';} if($divisi){echo $divisi[0]->division_name;}?></small>
                                                        <br/> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <!-- /.usercard-->
                                    </div>
                                </div>
                                <div class="tab-pane <?php if($tab==4){echo 'active';}?>" id="profile">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Nama</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->firstname.' '.$user[0]->lastname;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Handphone</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->phone;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Email</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->email;?></p>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6"> <strong>Jabatan</strong>
                                            <br>
                                            <p class="text-muted"><?=$nama_jabatan;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Jenis Kelamin</strong>
                                            <br>
                                            <p class="text-muted"><?php if($user[0]->gender==1){echo 'Laki-Laki';}else{echo 'Wanita';}?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Status Perkawinan</strong>
                                            <br>
                                            <p class="text-muted"><?php if($user[0]->marital_status==1){echo 'Menikah';}else{echo 'Belum Menikah';}?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Agama</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->religion;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Tempat Lahir</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->place_birth;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Mulai Bergabung</strong>
                                            <br>
                                            <p class="text-muted"><?php $tanggal = strtotime($user[0]->join_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Tanggal Lahir</strong>
                                            <br>
                                            <p class="text-muted"><?php $tanggal = strtotime($user[0]->date_birth); $dt = date("d F Y  ", $tanggal); echo $dt;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Jenis Kelamin</strong>
                                            <br>
                                            <p class="text-muted"><?php if($user[0]->gender==1){echo 'Laki-laki';}else{echo 'Perempuan';};?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>KK</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->no_kk;?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>KTP</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->identity_no;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Tanggal Berlaku KTP</strong>
                                            <br>
                                            <p class="text-muted"><?php $tanggal = strtotime($user[0]->expired_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"> <strong>Jabatan</strong>
                                            <br>
                                            <?php 
                                                $id_jabatan = $user[0]->id_position;
                                                $get_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
                                                if($get_jabatan){
                                                    $nama_jabatan = $get_jabatan[0]->nama_jabatan;
                                                }else{
                                                    $nama_jabatan = '';
                                                }
                                            ?>
                                            <p class="text-muted"><?=$nama_jabatan;?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6"> <strong>Alamat</strong>
                                            <br>
                                            <p class="text-muted"><?=$user[0]->address;?></p>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal form-material"  enctype="multipart/form-data" method="post" action="<?=base_url()?>index/update_profile/<?=$id_employee;?>">
                                        <div class="form-group">
                                            <label class="col-md-12">Nama</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nama" class="form-control form-control-line" value="<?=$user[0]->firstname;?>" required> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Email</label>
                                            <div class="col-md-12">
                                                <input type="email" class="form-control form-control-line" value="<?=$user[0]->email;?>" name="email" id="example-email" required> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Handphone</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-line" value="<?=$user[0]->phone;?>" name="handphone"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12">Status Perkawinan</label>
                                            <div class="col-sm-12">
                                                <select name="status_perkawinan" class="form-control form-control-line">
                                                    <option value="0" <?php if($user!=0){if($user[0]->marital_status==0){echo 'selected';}}?>>Belum Menikah</option>
                                                    <option value="1" <?php if($user!=0){if($user[0]->marital_status==1){echo 'selected';}}?>>Sudah Menikah</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12">Agama</label>
                                            <div class="col-sm-12">
                                                <select name="agama" class="form-control form-control-line">
                                                    <option value="Islam" <?php if($user!=0){if($user[0]->religion=='Islam'){echo 'selected';}}?>>Islam</option>
                                                    <option value="Kristen Protestan" <?php if($user!=0){if($user[0]->religion=='Kristen Protestan'){echo 'selected';}}?>>Kristen Protestan</option>
                                                    <option value="Kristen Katolik" <?php if($user!=0){if($user[0]->religion=='Kristen Katolik'){echo 'selected';}}?>>Kristen Katolik</option>
                                                    <option value="Hindu" <?php if($user!=0){if($user[0]->religion=='Hindu'){echo 'selected';}}?>>Hindu</option>
                                                    <option value="Budha" <?php if($user!=0){if($user[0]->religion=='Budha'){echo 'selected';}}?>>Budha</option>
                                                    <option value="Kongwucu" <?php if($user!=0){if($user[0]->religion=='Kongwucu'){echo 'selected';}}?>>Kongwucu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Alamat</label>
                                            <div class="col-md-12">
                                                <textarea rows="5" name="alamat" class="form-control form-control-line"><?=$user[0]->address;?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Photo</label>
                                            <div class="col-md-12">
                                                <input type="file" name="image"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success" type="submit" name="save">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php if($upmanager=='0'){?>
                        <input type="hidden" name="jum_todo_today" id="jum_todo_today" value="<?=$jum_todo_today;?>">
                        <?php }?>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                if($('#jum_todo_today').val()=='0'){
                                    $('#todoModal').modal('show');
                                }
                            });
                        </script>


                        <div class="row"><div class="col-sm-12">

                        <!--
                            The idea is to use mostly Bootstrap markup,
                            peppered with a few "tr" and "td" classes,
                            so you can turn any basic bootstrap panel
                            into a columnar panel.
                        -->
                        <?php
                            $tgl_sekarang = date('Y-m-d');
                            $jam_sekarang = date('H:i:s');
                            $meeting1 = $this->db->query("SELECT * FROM meeting_room_booking a, meeting_room c, employee b WHERE a.meeting_date>='$tgl_sekarang' AND a.id_meeting_room='4' AND a.id_meeting_room=c.id_meeting_room AND a.created_by=b.id_employee ORDER BY a.id_meeting_room_booking DESC")->result();
                            $meeting2 = $this->db->query("SELECT * FROM meeting_room_booking a, meeting_room c, employee b WHERE a.meeting_date>='$tgl_sekarang' AND a.id_meeting_room='3' AND a.id_meeting_room=c.id_meeting_room AND a.created_by=b.id_employee ORDER BY a.id_meeting_room_booking DESC")->result();
                            $meeting3 = $this->db->query("SELECT * FROM meeting_room_booking a, meeting_room c, employee b WHERE a.meeting_date>='$tgl_sekarang' AND a.id_meeting_room='2' AND a.id_meeting_room=c.id_meeting_room AND a.created_by=b.id_employee ORDER BY a.id_meeting_room_booking DESC")->result();

                        ?>
                        <div class="panel panel-default panel-table">
                            <div class="panel-heading">
                                <div class="tr">
                                    <div class="td" style="min-width: 300px">Golden Goal Room</div>
                                    <div class="td" style="min-width: 260px">Silver Goal Room</div>
                                    <div class="td" style="min-width: 300px">Board Meeting Room</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="tr">
                                    <div class="td">
                                        <?php if($meeting1){ foreach($meeting1 as $view){
                                            $tanggal = strtotime($view->meeting_date); 
                                            $dt = date("d F Y  ", $tanggal);
                                            $mulai = $view->meeting_start;
                                            $akhir = $view->meeting_end;
                                            ?>
                                            <p>- <?=$dt.' '.$mulai.' - '.$akhir;?></p>
                                            <p style="margin-left: 10px"><?=$view->description;?></p>
                                        <?php }}else{?>
                                            <h4>Tidak ada agenda</h4>
                                        <?php }?>
                                    </div>
                                    <div class="td">
                                        <?php if($meeting2){ foreach($meeting2 as $view){
                                            $tanggal = strtotime($view->meeting_date); 
                                            $dt = date("d F Y  ", $tanggal);
                                            $mulai = $view->meeting_start;
                                            $akhir = $view->meeting_end;
                                            ?>
                                            <p>- <?=$dt.' '.$mulai.' - '.$akhir;?></p>
                                            <p><?=$view->description;?></p>
                                        <?php }}else{?>
                                            <h4>Tidak ada agenda</h4>
                                        <?php }?>
                                    </div>
                                    <div class="td">
                                        <?php if($meeting3){foreach($meeting3 as $view){
                                            $tanggal = strtotime($view->meeting_date); 
                                            $dt = date("d F Y  ", $tanggal);
                                            $mulai = $view->meeting_start;
                                            $akhir = $view->meeting_end;
                                            ?>
                                            <p>- <?=$dt.' '.$mulai.' - '.$akhir;?></p>
                                            <p><?=$view->description;?></p>
                                        <?php }}else{?>
                                            <h4>Tidak ada agenda</h4>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="tr">
                                    <div class="td"></div>
                                    <div class="td"></div>
                                    <div class="td"></div>
                                </div>
                            </div>
                        </div>

                        </div></div><br>

                        <!--<script> 
                            $(document).ready(function(){
                                $("#sli").animate({left: '20px'},1000);
                            });
                        </script>
                        <script> 
                            $(document).ready(function(){
                                $("#canc").click(function(){
                                    $("#sli").slideUp("slow");
                                });
                            });
                        </script>
                        <div id="sli" style="background:#fff; box-shadow: 10px 10px 10px 0px #dedede; height:500px;width:550px;position:absolute;right: 100px; bottom: 0; padding: 20px 20px" >
                            
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h3 class="box-title m-b-0">To Do List</h3><br>
                                    <form method="post" action="<?=base_url()?>index/add_todo/<?=$id_employee;?>">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="todo1" id="exampleInputuname">
                                                <div class="input-group-addon"><i class="ti">1</i></div>
                                            </div><br>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="todo2" id="exampleInputuname">
                                                <div class="input-group-addon"><i class="ti">2</i></div>
                                            </div><br>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="todo3" id="exampleInputuname">
                                                <div class="input-group-addon"><i class="ti">3</i></div>
                                            </div><br>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="todo4" id="exampleInputuname">
                                                <div class="input-group-addon"><i class="ti">4</i></div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button></form>
                                            <a id="canc" class="btn btn-inverse waves-effect waves-light">Cancel</a>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!-- /.row -->
                <!-- Modal -->

                <div class="row" style="z-index: 9000">
                    <div class="col-md-4">
                            <!-- sample modal content -->
                            <!-- /.modal -->
                            <?php
                            $url=$_SERVER['REQUEST_URI'];
                            ?>
                            <div id="mymodal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <form method="post" action="<?=base_url()?>employee/ganti_password/<?=$id_employee;?>">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="padding:30px">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="info" style="color:#999">Ganti Password</h4> 
                                        </div>
                                        <div class="modal-body">
                                                <input type="hidden" name="pg" value="<?=$url;?>">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Password lama :</label>
                                                    <input type="password" id="password_lama" onkeyup="return check2()" name="password_lama" class="form-control room-name" id="recipient-name" required> 
                                                    <span id='check_data' style="color: red" ></span>
                                                </div>
                                                    
                                                <div class="form-group">
                                                    <label class="control-label">Password baru :</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" class="form-control password" id="password" required> <span class="input-group-addon"><i class="icon-key"></i></span>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Confirm password baru :</label>
                                                    <div class="input-group">
                                                        <input type="password" id="confirm_password" class="form-control" onkeyup="check(this)" name="confirm" required> <span class="input-group-addon"> <i class="icon-key"></i> </span>
                                                    </div>
                                                    <span id='message' style="position: absolute;"></span>
                                                    <script type="text/javascript">
                                                  $('#confirm_password').on('keyup', function () {
                                                      if ($(this).val() == $('#password').val()) {
                                                          $('#message').html('').css('color', 'red');
                                                          document.getElementById('submit').disabled = false;
                                                      } else {
                                                          $('#message').html('password tidak sama').css('color', 'red');
                                                          document.getElementById('submit').disabled = true;
                                                      } 
                                                  });
                                              </script>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                            <button type="submit" id="submit" name="booking" class="btn btn-danger waves-effect waves-light">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                    function check2(){
                        id = $("#password_lama").val();
                        $.get( "<?= base_url(); ?>employee/check_pass_lama" , { option : id } , function ( data ) {
                            $( '#check_data' ) . html ( data ) ;
                            salah = data;
                            if(salah=='Password lama salah !'){
                                document.getElementById('submit').disabled = true;
                            }else{
                                document.getElementById('submit').disabled = false;
                            }
                          } ) ;
                    }
                </script>

                <style type="text/css">
                    .blink_me {
                          animation: blinker 3s linear infinite;
                        }

                        @keyframes blinker {  
                          50% { opacity: 0; }
                        }
                </style>
                <div class="modal fade" id="todoModal" tabindex="-1" role="dialog" aria-labelledby="todoModalLabel" aria-hidden="true">
                <span type="button" style="margin:55px 0 0 310px; font-size: 100px; position: absolute; color: #999"><i class="fa fa-edit blink_me"></i> </span>
                    <div class="modal-dialog" style="border: 2px solid #fff; padding: 5px; margin-top: 150px; border-radius:50px 0 0 0">
                        <div class="modal-content" style="border-radius:40px 0 0 0">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4 class="modal-title" style="margin:10px 0 0 20px" id="memberModalLabel">Uraian pekerjaan hari ini !</h4>      
                                    </div>
                                    <div class="col-md-2">
                                        <select name="jum_todo" id="jml" class="form-control" onchange="return jml();">
                                            </option value="0">- Jumlah -</option>
                                            <?php
                                            for($i=1;$i<=10;$i++){
                                              if($this->input->post('jml')==$i){
                                                echo "<option value=".$i." selected>".$i."</option>";
                                              }else{
                                                echo "<option value=".$i.">".$i."</option>";
                                              }
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?=base_url()?>index/add_todo/<?=$id_employee.'/'.$jml_todo_on;?>">
                                    <div class="form-group" style="padding: 0 40px 0 40px">
                                        <?=$this->input->post('jml_todo');?>
                                            <div class="input-group" style="width: 505px; margin-left: -15px">
                                                <input type="text" class="form-control" name="todo1" id="exampleInputuname">
                                                <div class="input-group-addon" style="padding: 0 14px 0 14px"><i class="ti">1</i></div>
                                            </div>
                                        <div class="row" id="check_data"></div><br>
                                        <div>
                                            <p>Tugas yang belum selesai :</p>
                                            <?php $no=1; foreach($todolist_on as $view){
                                                    $todo_on = $this->db->query("SELECT * FROM todolist WHERE keterangan='$view->keterangan' AND status='1'")->result();
                                                    if(!$todo_on){

                                                ?>
                                                <table>
                                                    <tr>
                                                        <td style="width: 500px">- <?=$view->keterangan;?></td>
                                                        <td><input type="checkbox" name="<?=$no;?>" value="<?=$view->keterangan;?>"></td>
                                                    </tr>
                                                </table>
                                            <?php $no++;}}?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </form>
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
                <script type="text/javascript">
                    function jml(){
                        id = $("#jml").val();
                        $.get( "<?= base_url(); ?>index/data_todo" , { option : id } , function ( data ) {
                            $( '#check_data' ) . html ( data ) ;
                          } ) ;
                    }
                </script>
                
                
                <script type="text/javascript">
                    $(document).ready(function () {
                        $(this).toggleClass('open');
                        $('.option').toggleClass('scale-on');
                       
                    });
                </script>
                