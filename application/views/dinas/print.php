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
                        <td style="width: 445px;">
                            <img src="<?=base_url()?>assets/img/lib.png" alt="logi lib" class="logo-lib" width="180px" />
                        </td>
                    </tr>
                </TABLE>
                <TABLE>
                    <tr>
                        <td style="width: 200px;"></td>
                        <td style="width: 245px; text-align: center; color: #000">
                            <h3><b>SURAT TUGAS</b></h3>
                            <hr style="margin-top: 5px; color: #000;">
                            <hr style="margin-top: -17px; color: #000;">
                            <h4 style="color: #000; margin-top: -40px">NOMOR : <?=$data_dinas[0]->no_surat;?></h4>
                        </td>
                        <td style="width: 200px;"></td>
                    </tr>
                </TABLE>
                <table style="margin-top: 40px">
                    <tr>
                        <td style="width: 150px;">Pertimbangan</td>
                        <td style="width: 5px;"> :</td>
                        <td style="width: 200px; padding-left: 10px"> <?=$data_dinas[0]->keperluan;?></td>
                    </tr>
                </table>
                <table style="margin-top: 40px">
                    <tr>
                        <td style="width: 180px;"></td>
                        <td style="width: 265px; text-align: center; color: #000">
                            <h4><u>PT LIGA INDONESIA BARU</u></h4>
                        </td>
                        <td style="width: 180px;"></td>
                    </tr>
                </table>
                <table style="margin-top: 40px">
                    <tr>
                        <td style="width: 180px;"></td>
                        <td style="width: 265px; text-align: center; color: #000">
                            <h4><i>MENUGASKAN :</i></h4>
                        </td>
                        <td style="width: 180px;"></td>
                    </tr>
                </table>
                <table style="margin: 40px 0 0 110px;"  border='1' cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 10px; padding: 4px; color: #000"><h5>No</h5></td>
                        <td style="width: 150px; padding: 4px; text-align: center; color: #000"><h5>Nama</h5></td>
                        <td style="padding: 4px;text-align: center; color: #000"><h5>Hari Tanggal</h5></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px">1</td>
                        <td style="padding: 4px"><?=$data_employee[0]->firstname;?></td>
                        <td style="padding: 4px"><?php $tanggal1 = strtotime($data_dinas[0]->start_date); $dt1 = date("d F Y  ", $tanggal1); $tanggal2 = strtotime($data_dinas[0]->end_date); $dt2 = date("d F Y  ", $tanggal2); echo $dt1.' - '.$dt2;?></td>
                    </tr>
                </table>
                <table style="margin-top: 40px">
                    <tr>
                        <td>Untuk :<br>- <?=$data_dinas[0]->keperluan.' pada '.$dt1.' sampai '.$dt2;?><br><br>
                        Terhadap yang bersangkutan agar melaksanakan tugas dengan sebaik-baiknya dan melaporkan hasil pelaksanaan tugas kepada manajemen PT Liga Indonesia Baru.</td>
                    </tr>
                </table>
                <table style="margin-top: 20px">
                    <tr>
                        <?php 
                        $id_dinas = $data_dinas[0]->id_dinas;
                        $data_approved = $this->db->query("SELECT updated_date as tg FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
                        $tanggal3 = strtotime($data_approved[0]->tg); $dt3 = date("d F Y  ", $tanggal3);?>
                        <td>
                            Jakarta, <?=$dt3;?>
                        </td>
                    </tr>
                </table>
                <table style="margin-top: 20px; color: #000">
                    <tr>
                        <td>
                            <?php $nama_jabatan = $data_approver[0]->nama_jabatan;
                                  if($nama_jabatan=='CEO' || $nama_jabatan=='COO' || $nama_jabatan=='CMO' || $nama_jabatan=='CLE' || $nama_jabatan=='CFO' || $nama_jabatan=='Secretary Director'){
                                    $division_name = '';
                                  }else{
                                    $division_name = $data_employee[0]->division_name;
                                  }
                            ?>
                            <h4>PT LIGA INDONESIA BARU<BR><i><?=strtoupper($nama_jabatan.' '.$division_name);?></i></h4><br>
                            <?php if($data_approver[0]->sign_dig!=''){?>
                                <img src="<?=base_url()?>assets/images/sign/<?=$data_approver[0]->sign_dig;?>" alt="tanda tangan" class="dark-logo" width="120px" /><br>
                            <?php }else{?>
                            <br><br><br><br><br>
                            <?php }?>
                            <?=strtoupper($data_approver[0]->firstname);?>
                        </td>
                    </tr>
                </table>
            </div>
    </body>
</html>