  <?php
    $title_header = 'document';
  ?>
 <style type="text/css">
    input{width:100%;}
    select{width:103%;}
    .popover{
        z-index: 9999999
    }
    .popover-title{
        padding: 8px 14px 8px 44px
    }
</style>
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                    <form method="post" action="<?=base_url()?>recruitment/upload_doc/<?=$id_recruitment;?>" id="form" class="form-horizontal" enctype="multipart/form-data">
                        <div class="span4 mrgn-btm10">
                            <div class="input-group" style="border:1px solid #dedede; border-radius:5px 5px">  
                                <label class="btn btn-default" for="my-file-selector">
                                    <input id="my-file-selector" type="file" name="docfile" style="display:none; width:90px" onchange="$('#upload-file-info').html($(this).val());" required>
                                    Search File...
                                </label>
                                <span class='label label-info' id="upload-file-info"></span>
                            </div> 
                        </div>
                        <div class="span4 mrgn-btm10">
                            <input type="text" class="form-control" name="description" placeholder="type description here..." required> 
                        </div>
                        <div class="span4 mrgn-btm10">
                            <button type="submit" name="upload" class="btn btn-success add-data">Upload</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4><?=$data_recruitment[0]->firstname."'s ";?> <?=$title_header;?></h4>
                            </div>
                            <div class="w-box-content">
                                <table class="table table-vam table-striped" id="dt_gal">
                                    <thead>
                                        <tr>
                                            <td style="width:0px; display:none">
                                                <input type="hidden" name="row_sel" class="row_sel" />
                                            </td>
                                            <th style="text-align:center;">No</th>
                                            <th>Description</th>
                                            <th>Type Of File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_dokumen as $view){?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td><?=$view->description;?></td>
                                            <td><?=$view->doc_type;?></td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url();?>assets/document_file_recruit/<?=$view->doc_name;?>" class="btn btn-mini" title="Document"><i class="icon-arrow-down"></i></a>
                                                <a href="<?=base_url()?>recruitment/delete_doc/<?=$view->id_recruitment_doc;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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