  <?php
    $title_header = 'Privileges';
  ?>   
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12 mrgn-btm10">
                            <a href="<?=base_url()?>privileges/add_edit_data/0" type="button" class="btn btn-success" >Create Privileges</a>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>List Of <?=$title_header;?></h4>
                            </div>
                            <div class="w-box-content">
                                <table class="table table-vam table-striped" id="dt_gal">
                                    <thead>
                                        <tr>
                                            <td style="width:0px; display:none">
                                                <input type="hidden" name="row_sel" class="row_sel" />
                                            </td>
                                            <th style="text-align:center">No</th>
                                            <th>Privileges Name</th>
                                            <th>Status</th>
                                            <th>Create Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_privileges as $view){?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td ><?=$view->privileges_name;?></td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status==1){ 
                                                        $status = 'Enable';
                                                        echo 'label label-success';
                                                    }else { 
                                                        $status = 'Disable';
                                                        echo 'label label-important';
                                                    }?>"><?=$status;?>
                                                </div>
                                            </td>
                                            <td><?php $tanggal = strtotime($view->created_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td><?php $tanggal = strtotime($view->updated_date); $dt = date("d F Y  ", $tanggal); if($view->updated_date=='0000-00-00'){echo '-';}else{echo $dt;}?></td>
                                            <td>
                                                <div class="btn-group">
                                                    
                                                <a href="<?=base_url()?>privileges/add_edit_data/<?=$view->id_privileges;?>" class="btn btn-mini" title="Edit privileges"><i class="icon-pencil"></i></a>
                                                <a href="<?=base_url()?>privileges/delete_data/<?=$view->id_privileges;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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
            </div><br><br><br>

            