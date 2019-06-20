  <?php
    $title_header = 'Event';
  ?>
      
<script>
  $(document).on( "click", '.edit_button',function(e) {
        var id_event= $(this).data('id-event');
        var event_name = $(this).data('event-name');
        var event_description = $(this).data('event-description');
        var event_date = $(this).data('event-date');
        var status = $(this).data('status');
        
        $(".id-event").val(id_event);
        $(".event-name").val(event_name);
        $(".event-description").val(event_description);
        $(".event-date").val(event_date);
        $(".status").val(status);
        
    document.getElementById("info").innerHTML = 'Update Data <?=$title_header;?>';
    });
</script>
<script>
  $(document).on( "click", '.add-data',function(e) {    
    document.getElementById("info").innerHTML = 'Add Data <?=$title_header;?>';
    });
</script>
<style type="text/css">
    input{width:100%;}
    select{width:103%;}
</style>
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12 mrgn-btm10">
                            <button type="button" class="btn btn-success add-data" data-toggle="modal" data-target="#myModal">Add Data</button>
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
                                            <th>Event Name</th>
                                            <th>Description</th>
                                            <th>Event Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_event as $view){?>
                                        <tr>
                                            <td style="display:none"></td>
                                            <td style="text-align:center"><?=$no;?></td>
                                            <td ><?=$view->event_name;?></td>
                                            <td><?=$view->event_description;?></td>
                                            <td><?php $tanggal = strtotime($view->event_date); $dt = date("d F Y  ", $tanggal); echo $dt;?></td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status=='1'){
                                                        $status = 'Enable';
                                                        echo 'label label-success';
                                                    }else { 
                                                        $status = 'Disable';
                                                        echo 'label label-important';
                                                    }?>"><?=$status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    
                                                <a href="#" 
                                                    class="btn btn-mini edit_button" title="Edit"
                                                    data-toggle="modal" data-target="#myModal"
                                                    data-id-event="<?=$view->id_event;?>"
                                                    data-event-name="<?=$view->event_name;?>"
                                                    data-event-description="<?=$view->event_description;?>"
                                                    data-event-date="<?=$view->event_date;?>"
                                                    data-status="<?=$view->status;?>"
                                                ><i class="icon-pencil"></i></a>
                                                <a href="<?=base_url()?>event/delete_data/<?=$view->id_event;?>" onclick="return confirm('Are you sure to delete data?')" class="btn btn-mini" title="Delete"><i class="icon-trash"></i></a>
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

            <!-- Bootstrap modal -->
            <style type="text/css">
            .notif{padding:0 10px 0 30px; position:absolute; right:0; margin:-25px 80px 0 0; border-radius:60% 0 0 60%; background:#F5A9BC; font-size:10px; color:#fff}
            .main{display:none; }
            .alamat{display:none; }
            .telp{display:none; }
            textarea{width:100%;}
            </style>
                    <div class="modal fade hide in" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static" style="width:900px; margin-left:-450px">
                        <div class="modal-dialog" >
                            <div class="modal-content" style="height:auto ">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="info" style="color:#999"></h4>
                                </div>
                                <div class="modal-body form" style="background:#f1f1f1">
                                    <div class="col-sm-12">
                                    <form method="post" action="<?=base_url()?>event/add_edit_data" id="form" class="form-horizontal">
                                        <input type="hidden" value="" name="id_event" class="id-event" />
                                        <div class="form-body" style="width:500px; margin:0 auto;">
                                            <div class="form-group">
                                                <label for="validate-email">Event Name</label>
                                                <div class="input-group" data-validate="email">
                                                    <input type="text" class="form-control event-name" name="event_name" id="validate-email" required>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Description</label>
                                                <div class="input-group clockpicker">
                                                    <textarea class="form-control event-description" name="event_description"></textarea>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="validate-email">Event Date</label>
                                                <div class="input-group clockpicker">
                                                    <input type="date" class="form-control event-date" id="datepicker" name="event_date">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <div class="input-group status">
                                                    <select name="status" class="form-control status" required>
                                                    <option value="">- choose status -</option>
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                    </select>
                                                </div>
                                                <div class="notif ma main">required</div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                            <div style="float:left; margin:10px 0 0 200px; padding:10px 0">
                                <button type="submit" name="save" class="btn btn-success" style="width:150px">Submit</button>
                                <a type="button" class="btn btn-danger" data-dismiss="modal" style="width:140px">Cancel</a>
                            </div></form>
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    </div>
                    <!-- End Bootstrap modal -->
<script type="text/javascript">      
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#datepicker').datepicker({ 
    minDate: today
});
</script>