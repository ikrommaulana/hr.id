<?php if($role_id==1){?>
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
                            <!--<a href="<?=base_url()?>biaya/add_edit_data/" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-plus"></i> </a>-->
                            <li><a href="javascript:void(0)">Biaya Perjalanan Dinas <?=$zona;?></a></li>
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
                                            <th>No</th>
                                            <th>Keterangan</th>
                                            <?php foreach($data_jabatan as $view){?>
                                            <th><?=$view->nama_jabatan;?></th>
                                            <?php }?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_biaya as $view){
                                            $data_detail = $this->db->query("SELECT * FROM biaya_dinas_detail2 WHERE id_biaya_dinas='$view->id_biaya_dinas' AND jenis_perjalanan='$id_biaya_dinas_zona' ORDER BY id_jabatan DESC")->result();
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->keterangan;?></td>
                                            <?php if($data_detail){ foreach($data_detail as $view){?>
                                            <td style="text-align: right"><?=$view->biaya;?></td>
                                            <?php }}else{ for($a=1; $a<=$jumlah_jabatan; $a++){?>
                                            <td style="text-align: right" class="<?=$a;?>">0</td>
                                            <?php }}?>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>biaya/add_edit_data/<?=$view->id_biaya_dinas?>" class="btn btn-mini" title="Edit Data"><i class="icon-pencil"></i></a>
                                                <!--<a href="<?=base_url()?>biaya/delete_data/<?=$view->id_biaya_dinas;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>-->
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
                <?php }else{
    redirect('error');
}?>