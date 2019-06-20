<?php
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }

    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }           
        return $hasil;
    }


    $angka = $biaya;
    $angka2 = $biaya2;
    $terbilang = terbilang($angka).' Rupiah';
?>
<html lang="en">
     <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     </head>
     <body>
            <div class="container">
                <TABLE border='1' cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 465px; border-right: none; padding: 10px">
                            <img src="<?=base_url()?>assets/img/lib.png" alt="logi lib" class="logo-lib" width="100px" />
                        </td>
                        <td style="width: 200px; border-left: none; text-align: right; padding: 10px">
                            <div style="padding: 40px 10px">
                                <div style="margin:30px 10px">Form Permintaan Dana</div>
                            </div>
                        </td>
                    </tr>
                </TABLE>
                <table border='1' cellpadding="0" cellspacing="0" style="margin-top: 40px; font-size: 12px" row-spacing='4'>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-bottom: none">Tanggal Pengajuan Dana</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-bottom: none">
                            <?php $tanggal = strtotime($data_dinas[0]->created_date); $dta = date("d F Y  ", $tanggal); echo $dta;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Tanggal Perjalanan</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?php $tanggal1 = strtotime($data_dinas[0]->start_date); $dt1 = date("d F Y  ", $tanggal1);
                                  $tanggal2 = strtotime($data_dinas[0]->end_date); $dt2 = date("d F Y  ", $tanggal2);   echo $dt1.' - '.$dt2;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Diajukan Oleh</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$data_employee[0]->firstname;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Departemen Pengajuan</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$data_divisi;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none">Anggaran</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none">Liga 1</td>
                    </tr>
                </table>
                <table border='1' cellpadding="0" cellspacing="0" style="margin-top: 40px; font-size: 12px" row-spacing='4'>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-bottom: none">Dibayarkan Kepada</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-bottom: none"> Terlampir</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Jumlah</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            Rp. <?=number_format($biaya);?> <?php if($biaya2!=0){echo ' + $ '.number_format($biaya2);}?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Terbilang</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$terbilang;?> <?php if($biaya2!=0){echo ' + $ '.number_format($biaya2);}?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Keperluan</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$data_dinas[0]->keperluan;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none">Surat Tugas No</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none">
                            <?=$data_dinas[0]->no_surat;?>
                        </td>
                    </tr>
                </table><br>
                <table border='1' cellpadding="0" cellspacing="0" style="font-size: 10px; <?php if(!$data_dir){?> margin-left: 135px<?php }?> <?php if($data_dir){if($data_dir[0]->id_employee==10009){?> margin-left: 135px<?php }}?> <?php if($data_dir){if($data_dir[0]->id_employee==10010){?> margin-left: 135px<?php }}?>">
                    <tr>
                        <td style="width: 108px; padding: 10px">Diketahui Oleh,</td>
                        <td colspan="4" style="width: 459px; padding: 10px; text-align: center">Disetujui Oleh,</td>
                    </tr>
                    <tr>
                        <!--tanda tangan atasan-->
                        <td style="width: 108px; padding: 10px; text-align: center">
                            <?php if($data_atasan[0]->sign_dig!=''){?>
                                <img src="<?=base_url()?>assets/images/sign/<?=$data_atasan[0]->sign_dig;?>" alt="tanda tangan" class="dark-logo" width="100px" /><br>
                            <?php }?>
                        </td>
                        <!--- tanda tangan finance --->
                        <?php if($approve_old==1){?>
                            <td style="width: 108px; padding: 10px; text-align: center">
                                <?php
                                    $cek_approve3 = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND id_approver='10010' AND status='1'") ->result();
                                    if($cek_approve3){
                                        $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10010'")->result();
                                        if($get_sign[0]->sd!=''){?>
                                            <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="120px" /><br>
                                        <?php }else{?>
                                            <span>tanda tangan kosong</span>
                                        <?php }}?>
                            </td>
                        <?php }else{?>
                            <td style="width: 108px; padding: 10px; text-align: center">
                                <?php
                                    $cek_approve3 = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND id_approver='10056' AND status='1'") ->result();
                                    if($cek_approve3){
                                        $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10056'")->result();
                                        if($get_sign[0]->sd!=''){?>
                                            <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="120px" /><br>
                                        <?php }else{?>
                                            <span>tanda tangan kosong</span>
                                        <?php }}?>
                            </td>
                        <?php }?>
                        <!--- tanda tangan finance --->
                        <!--- tanda tangan CEO di delete soon --->
                        <?php 
                            $cek_approve2 = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND id_approver='10009' AND status='1'") ->result();
                         if($cek_approve2){?>
                        <td style="width: 108px; padding: 10px; text-align: center">
                            <?php
                                 $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10009'")->result();
                                    if($get_sign[0]->sd!=''){?>
                                        <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="100px" /><br>
                                    <?php }else{?>
                                        <span>tanda tangan kosong</span>
                                    <?php }?>
                        </td>
                        <?php }?>
                        <!--- tanda tangan CEO di delete soon--->
                        <?php if($data_dir){if($data_dir[0]->id_employee!=10009){if($data_dir[0]->id_employee!=10010){?>
                        <td style="width: 108px; padding: 10px; text-align: center">
                            <?php 
                                $id_dir = $data_dir[0]->id_employee;
                                $cek_approve = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND id_approver='$id_dir' AND status='1'")->result();
                                if($cek_approve){
                                    $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='$id_dir'")->result();
                                    if($get_sign[0]->sd!=''){?>
                                        <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="100px" /><br>
                                    <?php }else{?>
                                        <span>tanda tangan kosong</span>
                                    <?php }}?>
                        </td>
                        <?php }}}?>
                    </tr>
                    <tr>
                        <td style="width: 108px; padding: 10px; text-align: center;"><?=$data_atasan[0]->firstname;?></td>
                        <?php if($approve_old==1){?>
                            <td style="width: 108px; padding: 10px; text-align: center;">Irzan Hanafiah Pulungan</td>
                        <?php }else{?>
                            <td style="width: 108px; padding: 10px; text-align: center;">Yulius Amos</td>
                        <?php }?>
                        <?php if($cek_approve2){?>
                        <td style="width: 108px; padding: 10px; text-align: center;">Teddy Tjahjono</td>
                        <?php }?>
                        <?php if($data_dir){if($data_dir[0]->id_employee!=10009){if($data_dir[0]->id_employee!=10010){?>
                        <td style="width: 108px; padding: 10px; text-align: center;"><?=$data_dir[0]->firstname;?></td>
                        <?php }}}?>
                    </tr>
                </table>
                <br><br><br>
                <p>Keterangan :</p>
                <table border="1" cellpadding="0" cellspacing="0" style="font-size: 10px">
                    <tr>
                        <td style="width: 108px; padding: 10px; text-align: center">Hari Tanggal</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Jumlah Hari Bertugas <br>(hari)</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Uang Transport</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Uang Makan</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Uang Pulsa</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Total</td>
                    </tr>
                    <tr>
                        <td style="width: 108px; padding: 10px"><?=$dt1.' - '.$dt2;?></td>
                        <td style="width: 135px; padding: 10px; text-align: center"><?=$jumlah_hari;?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><?=number_format($biaya_transport);?></td>
                        <?php 
                            $data_makan_libur = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas=4")->result();
                            $makan_libur = (isset($data_makan_libur[0]->biaya))? $data_makan_libur[0]->biaya : 0;
                            if($total_holiday!=''){
                                if($data_makan_libur){
                                    $um_holiday = $total_holiday * $makan_libur;
                                }else{
                                    $um_holiday = $total_holiday * 300000; // pengajuan lama/manual
                                }
                            }else{
                                $um_holiday = 0;
                            }

                            $bm = ($biaya_makan * $jumlah_hari) + $um_holiday;
                        ?>
                        <td style="width: 135px; padding: 10px; text-align: right"><?php if($biaya2!=0){echo '$ ';}?><?=number_format($bm);?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><?=number_format($biaya_pulsa);?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><b><?=number_format($biaya);?><?php if($biaya2!=0){echo ' + $ '.number_format($biaya2);}?></b></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; text-align: center;" colspan="5"><b>Total</b></td>
                        <td style="width: 108px; padding: 10px; text-align: right"><b><?=number_format($biaya);?><?php if($biaya2!=0){echo ' + $ '.number_format($biaya2);}?></b></td>
                    </tr>
                </table>
            </div>
    </body>
</html>