<?php foreach($user_role_data as $view){
  if($view->view_setup==1 || $view->update_setup==1){
?>
<style type="text/css">
    /*!
 * bootstrap-vertical-tabs - v1.1.0
 * https://dbtek.github.io/bootstrap-vertical-tabs
 * 2014-06-06
 * Copyright (c) 2014 Ä°smail Demirbilek
 * License: MIT
 */
.tabs-left, .tabs-right {
  border-bottom: none;
  padding-top: 2px;
}
.tabs-left {
  border-right: 1px solid #ddd;
}
.tabs-right {
  border-left: 1px solid #ddd;
}
.tabs-left>li, .tabs-right>li {
  float: none;
  margin-bottom: 2px;
}
.tabs-left>li {
  margin-right: -1px;
}
.tabs-right>li {
  margin-left: -1px;
}
.tabs-left>li.active>a,
.tabs-left>li.active>a:hover,
.tabs-left>li.active>a:focus {
  border-bottom-color: #ddd;
  border-right-color: transparent;
}

.tabs-right>li.active>a,
.tabs-right>li.active>a:hover,
.tabs-right>li.active>a:focus {
  border-bottom: 1px solid #ddd;
  border-left-color: transparent;
}
.tabs-left>li>a {
  border-radius: 4px 0 0 4px;
  margin-right: 0;
  display:block;
}
.tabs-right>li>a {
  border-radius: 0 4px 4px 0;
  margin-right: 0;
}
.vertical-text {
  margin-top:50px;
  border: none;
  position: relative;
}
.vertical-text>li {
  height: 20px;
  width: 120px;
  margin-bottom: 100px;
}
.vertical-text>li>a {
  border-bottom: 1px solid #ddd;
  border-right-color: transparent;
  text-align: center;
  border-radius: 4px 4px 0px 0px;
}
.vertical-text>li.active>a,
.vertical-text>li.active>a:hover,
.vertical-text>li.active>a:focus {
  border-bottom-color: transparent;
  border-right-color: #ddd;
  border-left-color: #ddd;
}
.vertical-text.tabs-left {
  left: -50px;
}
.vertical-text.tabs-right {
  right: -50px;
}
.vertical-text.tabs-right>li {
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.vertical-text.tabs-left>li {
  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  -ms-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
}
</style>
<div class="container">
    <div id='loadingmessage' style='display:none; position:absolute; margin:150px 0 0 500px; z-index:9999999'>
        <img src='<?= base_url()?>assets/img/squares.gif'/>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="w-box w-box-blue">
                <div class="w-box-header">
                    <h4><i class="icon-cog"></i> Setup</h4>
                </div>
                <div class="w-box-content cnt_a" style="padding:20px 20px; height:300px">
                    <div class="col-xs-3" style="width:300px;">
                        <!-- required for floating -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs-left">
                            <li class="<?=$dashboard_active;?>"><a href="#home" data-toggle="tab"><i class="icon-home" style="margin-right:7px"></i> Dashboard</a></li>
                            <li class="<?=$due_active;?>"><a href="#profile" data-toggle="tab"><i class="icon-calendar" style="margin-right:7px"></i> Due Date</a></li>
                            <li class="<?=$warn_active;?>"><a href="#messages" data-toggle="tab"><i class="icon-bell" style="margin-right:7px"></i> Warning</a></li>
                            <li><a href="#settings" data-toggle="tab"><i class="icon-comment" style="margin-right:7px"></i> Email</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-9" style="margin:-170px 0 0 330px">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane <?=$dashboard_active;?>" id="home">
                                <div class="col-sm-12">
                                    <form action="<?=base_url()?>setup/update_dashboard" id="form" method="post" class="form-horizontal">
                                        <input type="hidden" value="<?=$dashboard[0]->id_dashboard;?>" name="id"/>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="dashboard">Welcome Text</label>
                                                <div class="input-group" data-validate="number">
                                                    <textarea <?php if($user_role_data[0]->update_setup!=1){echo 'disabled';};?> class="form-control" name="dashboard" rows="3" style="width:500px"><?=$dashboard[0]->text;?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div style="float:left; margin-top:10px;">
                                <?php if($user_role_data[0]->update_setup==1){?>
                                    <button type="submit" name="save" value="save" class="btn btn-success" style="width:150px">Save</button>
                                <?php };?>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane <?=$due_active;?>" id="profile">
                                <div class="col-sm-12">
                                    <form action="<?=base_url()?>setup/update_due" id="form2" method="post" class="form-horizontal">
                                        <input type="hidden" value="<?=$due_date[0]->id_due_date;?>" name="id"/>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="validate-email">Will Due Date :</label>
                                                <div class="input-group" data-validate="email">
                                                    <span style="color:#BDBDBD">time H- </span><input <?php if($user_role_data[0]->update_setup!=1){echo 'disabled';};?> type="number" value="<?=$due_date[0]->will;?>" class="form-control" name="will" id="validate-email"> <span style="color:#BDBDBD">days</span>
                                                </div>
                                            </div><hr>
                                            <div class="form-group">
                                                <label for="validate-email">Due Date :</label>
                                                <div class="input-group" data-validate="email">
                                                    <span style="color:#BDBDBD">time H- </span><input <?php if($user_role_data[0]->update_setup!=1){echo 'disabled';};?> type="number" value="<?=$due_date[0]->due;?>" class="form-control" name="due" id="validate-email"> <span style="color:#BDBDBD">days</span>
                                                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div style="float:left; margin-top:10px;">
                                <?php if($user_role_data[0]->update_setup==1){?>
                                    <button type="submit" name="save" value="save" class="btn btn-success" style="width:150px">Save</button>
                                <?php };?>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane <?=$warn_active;?>" id="messages">
                                <div class="col-sm-12">
                                    <form action="<?=base_url()?>setup/update_warn" id="form3" method="post" class="form-horizontal">
                                        <input type="hidden" value="<?=$due_date[0]->id_due_date;?>" name="id"/>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="validate-email">Warning :</label>
                                                <div class="input-group" data-validate="email">
                                                    <span style="color:#BDBDBD">interval </span><input <?php if($user_role_data[0]->update_setup!=1){echo 'disabled';};?> type="number" class="form-control" name="warning" id="validate-email" value="<?=$due_date[0]->warning;?>"> <span style="color:#BDBDBD">minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div style="float:left; margin-top:10px;">
                                <?php if($user_role_data[0]->update_setup==1){?>
                                    <button type="submit" name="save" value="save" class="btn btn-success" style="width:150px">Save</button>
                                <?php };?>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="settings">Settings Tab.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{
  redirect('error');
}};?>