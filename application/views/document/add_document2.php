<link href="<?=base_url()?>/plugins/bower_components/nestable/nestable.css" rel="stylesheet" type="text/css" />
                <!--Nestable js -->
    <script src="<?=base_url()?>/plugins/bower_components/nestable/jquery.nestable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // Nestable
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);
        $('#nestable2').nestable({
            group: 1
        }).on('change', updateOutput);
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
        $('#nestable-menu').nestable();
    });
    </script>
    <!-- animation CSS -->
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
                            <a href="<?=base_url()?>document" type="button" class="btn btn-success btn-circle" style="color: #fff"><i class="fa fa-reply"></i> </a>
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
                            <h3 class="box-title m-b-0" style="font-weight: normal;"><?=$title;?></h3><br>
                            <div>
                                <div class="wizard-content">
                                    <div>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box p-l-20 p-r-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="floating-labels" method="post" action="<?=base_url()?>document/add_edit_data/<?=$id_document;?>" enctype="multipart/form-data">
                                                        
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input3" name="document_name" required value="<?php if($data_dokumen!=''){echo $data_dokumen[0]->document_name;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input3">Nama Dokumen</label>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <input type="text" class="form-control" id="input4" name="document_no" required value="<?php if($data_dokumen!=''){echo $data_dokumen[0]->document_no;}?>"><span class="highlight"></span> <span class="bar"></span>
                                                                  <label for="input4">No Dokumen</label>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                <div class="white-box">
                                                                    <input type="file" id="input-file-now" name="docfile" /> 
                                                                </div>
                                                              </div>
                                                              <div class="form-group m-b-40 col-sm-6">
                                                                  <div class="row">
                                                                        <div class="white-box">
                                                                            <h3 class="box-title">Nestable 1</h3>
                                                                            <div class="myadmin-dd dd" id="nestable">
                                                                                <ol class="dd-list">
                                                                                    <li class="dd-item" data-id="1">
                                                                                        <div class="dd-handle"> Item 1 </div>
                                                                                    </li>
                                                                                    <li class="dd-item" data-id="2">
                                                                                        <div class="dd-handle"> Item 2 </div>
                                                                                        <ol class="dd-list">
                                                                                            <li class="dd-item" data-id="3">
                                                                                                <div class="dd-handle"> Item 3 </div>
                                                                                            </li>
                                                                                            <li class="dd-item" data-id="4">
                                                                                                <div class="dd-handle"> Item 4 </div>
                                                                                            </li>
                                                                                            <li class="dd-item" data-id="5">
                                                                                                <div class="dd-handle"> Item 5 </div>
                                                                                                <ol class="dd-list">
                                                                                                    <li class="dd-item" data-id="6">
                                                                                                        <div class="dd-handle"> Item 6 </div>
                                                                                                    </li>
                                                                                                    <li class="dd-item" data-id="7">
                                                                                                        <div class="dd-handle"> Item 7 </div>
                                                                                                    </li>
                                                                                                    <li class="dd-item" data-id="8">
                                                                                                        <div class="dd-handle"> Item 8 </div>
                                                                                                    </li>
                                                                                                </ol>
                                                                                            </li>
                                                                                            <li class="dd-item" data-id="9">
                                                                                                <div class="dd-handle"> Item 9 </div>
                                                                                            </li>
                                                                                            <li class="dd-item" data-id="10">
                                                                                                <div class="dd-handle"> Item 10 </div>
                                                                                            </li>
                                                                                        </ol>
                                                                                    </li>
                                                                                </ol>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                          </div>
                                                          <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" style="width: 100px" type="submit" name="save">Simpan</button>
                                                          <a href="<?=base_url()?>document" class="btn btn-danger btn-rounded waves-effect waves-light m-t-20" style="width: 100px">Batal</a>
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

