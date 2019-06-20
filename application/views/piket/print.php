<html lang="en">
     <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     </head>
     <body>
            <div class="container"> 
                <TABLE>
                    <tr>
                        <td style="width: 230px;">
                            <img src="<?=base_url()?>assets/img/lib.png" alt="logi lib" class="logo-lib" width="180px" />
                        </td>
                        <td style="width: 215px; text-align: center; color: #000">
                            <h4><b>FORM PENUGASAN PIKET</b></h4>
                            <p style="color: #000; margin-top: -20px">(FORM PENGAJUAN PIKET)</p>
                        </td>
                        <td style="width: 200px; text-align: right; font-size: 12px"><br><br><?=$data_piket[0]->no_piket;?></td>
                    </tr>
                </TABLE>
                <TABLE  style="margin-top: 10px">
                    <tr>
                        <td style="width: 645px">
                            <hr style="margin-top: 5px; color: #000;">
                            <hr style="margin-top: -17px; color: #000;">
                        </td>
                    </tr>
                </TABLE>
                <table style="margin-top: 60px">
                    <tr>
                        <td style="width: 150px;">Nama</td>
                        <td style="width: 5px;"> :</td> 
                        <td style="padding-left: 10px"><?=$data_employee[0]->firstname;?></td>
                    </tr>
                </table>
                <table style="margin-top: 10px">
                    <tr>
                        <td style="width: 150px;">Departemen / Divisi</td>
                        <td style="width: 5px;"> :</td>
                        <td style="padding-left: 10px"><?=$data_employee[0]->division_name;?></td>
                    </tr>
                </table>
                <table style="margin-top: 10px">
                    <tr>
                        <td style="width: 150px;">Tanggal Pengajuan</td>
                        <td style="width: 5px;"> :</td>
                        <td style="padding-left: 10px">
                            <?php $tanggal1 = strtotime($data_piket[0]->start_date); $dt1 = date("d F Y  ", $tanggal1); $tanggal2 = strtotime($data_piket[0]->end_date); $dt2 = date("d F Y  ", $tanggal2); echo $dt1.' - '.$dt2;?>
                        </td>
                    </tr>
                </table>
                <table style="margin-top: 10px">
                    <tr>
                        <td style="width: 150px;">Uraian Pekerjaan</td>
                        <td style="width: 5px;"> :</td>
                        <td style="padding-left: 10px"><?=$data_piket[0]->keperluan;?></td>
                    </tr>
                </table>
                <table style="margin-top: 100px; color: #000">
                    <tr>
                        <td>
                            <?php $nama_jabatan = $data_approver[0]->nama_jabatan;
                                  if($nama_jabatan=='CEO' || $nama_jabatan=='COO' || $nama_jabatan=='CMO' || $nama_jabatan=='CLE' || $nama_jabatan=='CFO' || $nama_jabatan=='Secretary Director'){
                                    $division_name = '';
                                  }else{
                                    $division_name = $data_employee[0]->division_name;
                                  }
                            ?>
                            <h5>Yang Menugaskan,</h5><br>
                            <?php if($data_approver[0]->sign_dig!=''){?>
                                <img src="<?=base_url()?>assets/images/sign/<?=$data_approver[0]->sign_dig;?>" alt="tanda tangan" class="dark-logo" width="120px" /><br>
                            <?php }else{?>
                            <br><br><br><br><br>
                            <?php }?>
                            <?=strtoupper($data_approver[0]->firstname);?><br>
                            <?=$nama_jabatan.' '.$data_employee[0]->division_name;?>
                        </td>
                    </tr>
                </table> 
            </div>
    </body>
</html>