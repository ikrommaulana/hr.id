  <?php
    $title_header = 'Permit';
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
            <div class="container" style="margin-bottom: 270px">
                <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Setup Approval Permit</h4>
                            </div>
                            <div class="w-box-content">
                                <div class="row-fluid" style="padding: 50px 0px 0px 0px">
                                    <div class="span3"></div>
                                    <div class="span3">Jumlah Approval</div>
                                    <div class="span3">
                                        <select name="approval" id="approval" onchange="return approval();" style="width:20%">
                                            </option value="0">- 0 -</option>
                                                <?php
                                                for($i=0;$i<=10;$i++){
                                                    if($this->input->post('approval')==$i){
                                                        echo "<option value=".$i." selected>".$i."</option>";
                                                    }else{
                                                        echo "<option value=".$i.">".$i."</option>";
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="span3"></div>
                                </div>
                                
                                <form method="post" action="<?=base_url()?>permit_/set_approval">
                                <?=$this->input->post('approval');?>
                                <div id="check_data"><br><br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br><br>

<script type="text/javascript">
    function approval(){
        id = $("#approval").val();
        $.get( "<?= base_url(); ?>permit/data_approval" , { option : id } , function ( data ) {
                $( '#check_data' ) . html ( data ) ;
            } ) ;
    }
</script>