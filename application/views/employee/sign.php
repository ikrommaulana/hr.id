<?php
    if(!empty($data_sign[0]->sign_dig)){
        $sign = $data_sign[0]->sign_dig;
    }else{
        $sign = '';
    };
?>
<style type="text/css">
    .container{
    margin-top:20px;
}
.image-preview-input,.image-preview-input2,.image-preview-input3 {
    position: relative;
    overflow: hidden;
    margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input input[type=file],.image-preview-input2 input[type=file],.image-preview-input3 input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.image-preview-input-title,.image-preview-input-title2,.image-preview-input-title3 {
    margin-left:2px;
}
.popover-content img{
    padding-right: 30px
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
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
                        <ol class="breadcrumb">
                            <a href="<?=base_url()?>employee" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-reply"></i> </a>
                            <li><a href="javascript:void(0)">Kembali</a></li>
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
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0" style="font-weight: normal;">Digital Signature</h3><br>
                            <div>
                                <div class="wizard-content">
                                    <div>
                                        <?php if($sign!=''){?>
                                        <div class="row">
                                            <div style="width: 150px; height: 150px; border:1px solid #dedede; margin-left: 40px" class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                                            <div style="margin:10px"><img class="img-responsive" alt="user" src="<?=base_url()?>assets/images/sign/<?=$sign;?>">
                                            </div>    
                                            </div>
                                        </div>
                                        <?php }?>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>employee/add_sign/<?=$id_employee;?>" enctype="multipart/form-data">
                                                        
                                                
                                                          <!--<div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                <div class="white-box">
                                                                    <input type="file" id="input-file-now" name="docfile" /> 
                                                                </div>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  
                                                              </div>
                                                          </div>-->
                                                          <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <div class="input-group image-preview">
                                                                <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                                                                <span class="input-group-btn">
                                                                    <!-- image-preview-clear button -->
                                                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                                        <span class="glyphicon glyphicon-remove"></span> Clear
                                                                    </button>
                                                                    <!-- image-preview-input -->
                                                                    <div class="btn btn-default image-preview-input">
                                                                        <span class="glyphicon glyphicon-folder-open"></span>
                                                                        <span class="image-preview-input-title3">Browse</span>
                                                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            </div>
                                                            <div class="col-sm-6"></div>
                                                        </div><br><br>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Simpan</button>
                                                          <a href="<?=base_url()?>employee" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
                                                        </form>
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

                <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
    </script>
    