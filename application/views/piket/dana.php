<?php
    $jenis_piket = $data_piket[0]->jenis_piket;// 1 luar kantor, 0 dalam kantor
    //start date
    $id_absensi = $data_employee[0]->id_absensi;
    $tgl_start = $data_piket[0]->start_date;
    $get_masuk = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_start'")->result();//29
    $get_keluar = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_start' ORDER BY id_employee_absensi DESC")->result();//29
    $jam_masuk = $get_masuk[0]->absensi_time;//29
    if($id_piket==37){
        $jam_keluar = '16:36:10';
    }else{
        $jam_keluar = $get_keluar[0]->absensi_time;//29    
    }
    
    $datetime1 = new DateTime($jam_keluar);
    $datetime2 = new DateTime($jam_masuk);
    $interval = $datetime1->diff($datetime2);
    $jml_jam1 = $interval->format('%h');
    if($jml_jam1>=5){
        $hari_1 = 1;
    }else{
        if($jenis_piket==1){
            $hari_1 = 1;
        }else{
            $hari_1 = 0;
        }
    }
    //start date
    //end date
    $tanggal1 = strtotime($data_piket[0]->start_date); 
    $dt1 = date("d F Y  ", $tanggal1);
    $tanggal2 = strtotime($data_piket[0]->end_date); 
    $dt2 = date("d F Y  ", $tanggal2);

    if($dt1!=$dt2){
        $tgl_end = $data_piket[0]->end_date;
        $get_masuk2 = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_end'")->result();//29
        $get_keluar2 = $this->db->query("SELECT * FROM employee_absensi WHERE id_absensi='$id_absensi' AND absensi_date='$tgl_end' ORDER BY id_employee_absensi DESC")->result();//29
        $jam_masuk2 = $get_masuk2[0]->absensi_time;//29
        $jam_keluar2 = $get_keluar2[0]->absensi_time;//29
        $datetime12 = new DateTime($jam_keluar2);
        $datetime22 = new DateTime($jam_masuk2);
        $interval2 = $datetime12->diff($datetime22);
        $jml_jam2 = $interval2->format('%h');
        if($jml_jam2>=5){
            $hari_2 = 1;
        }else{
            if($jenis_piket==1){
                $hari_2 = 1;
            }else{
                $hari_2 = 0;
            }
        }
    }else{
        $hari_2 = 0;
    }

    $biaya_piket = 500000;
    $jml_hari = $hari_1 + $hari_2;
    $jml_biaya = $biaya_piket * $jml_hari;

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


    $angka = $jml_biaya;
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
                <TABLE border='1'>
                    <tr>
                        <td style="width: 445px; border-right: none; padding: 10px">
                            <img src="<?=base_url()?>assets/img/lib.png" alt="logi lib" class="logo-lib" width="100px" />
                        </td>
                        <td style="width: 200px; border-left: none; text-align: right; padding: 10px">
                            <div style="padding: 40px 10px">
                                <div style="margin:30px 10px">Form Permintaan Dana</div>
                            </div>
                        </td>
                    </tr>
                </TABLE>
                <table border='1' style="margin-top: 40px; font-size: 12px" row-spacing='4'>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-bottom: none">Tanggal Pengajuan Dana</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-bottom: none">
                            <?=$dt1;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Tanggal Piket</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$dt1.' - '.$dt2;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Jenis Piket</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?php if($jenis_piket==1){echo 'Luar Kantor';}else{echo 'Dalam Kantor';}?>
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
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none">Tunjangan Piket</td>
                    </tr>
                </table>
                <table border='1' style="margin-top: 5px; font-size: 12px" row-spacing='4'>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-bottom: none">Dibayarkan Kepada</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-bottom: none"> Terlampir</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Jumlah</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            Rp. <?=number_format($jml_biaya);?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Terbilang</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$terbilang;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none; border-bottom: none">Keperluan</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none; border-bottom: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none; border-bottom: none">
                            <?=$data_piket[0]->keperluan;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; border-right: none; border-top: none">Surat Piket No</td>
                        <td style="width: 5px; padding: 10px; border-left: none; border-right: none; border-top: none"> :</td>
                        <td style="width: 390px; padding: 10px; border-left: none; border-top: none">
                            <?=$data_piket[0]->no_piket;?>
                        </td>
                    </tr>
                </table><br>
                <table border='1' style="font-size: 10px; <?php if(!$data_dir){?> margin-left: 135px<?php }?> <?php if($data_dir){if($data_dir[0]->id_employee==10009){?> margin-left: 135px<?php }}?> <?php if($data_dir){if($data_dir[0]->id_employee==10010){?> margin-left: 135px<?php }}?>">
                    <tr>
                        <td style="width: 108px; padding: 10px; text-align: center">Diketahui Oleh,</td>
                        <td colspan="4" style="width: 459px; padding: 10px; text-align: center">Disetujui Oleh,</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; padding: 10px; text-align: center">
                            <?php if($data_atasan[0]->sign_dig!=''){?>
                                <img src="<?=base_url()?>assets/images/sign/<?=$data_atasan[0]->sign_dig;?>" alt="tanda tangan" class="dark-logo" width="100px" /><br>
                            <?php }?>
                        </td>
                        <?php if($data_dir){if($data_dir[0]->id_employee!=10009){if($data_dir[0]->id_employee!=10010 && $data_employee[0]->id_employee!=10006 && $data_employee[0]->id_employee!=10000){?>
                        <!-- <td style="width: 135px; padding: 10px"> -->
                            <!-- <?php 
                                $id_dir = $data_dir[0]->id_employee;
                                $cek_approve = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='$id_dir' AND status='1'")->result();
                                if($cek_approve){
                                    $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='$id_dir'")->result();
                                    if($get_sign[0]->sd!=''){?>
                                        <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="90px" /><br>
                                    <?php }else{?>
                                        <span>tanda tangan kosong</span>
                                    <?php }}?> -->
                        <!-- </td> -->
                        <?php }}}?>
                        <?php if($approve_old==1){?>
                            <td style="width: 135px; padding: 10px">
                                <?php
                                    $cek_approve3 = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='10010' AND status='1'") ->result();
                                    if($cek_approve3){
                                        $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10010'")->result();
                                        if($get_sign[0]->sd!=''){?>
                                            <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="120px" /><br>
                                        <?php }else{?>
                                            <span>tanda tangan kosong</span>
                                        <?php }}?>
                            </td>
                        <?php }else{?>
                            <td colspan="4" style="width: 145px; padding: 10px; text-align: center">
                                <?php
                                    //$cek_approve3 = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='10050' AND status='1'") ->result();
                                    $cek_approve3 = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='10056' AND status='1'") ->result();
                                    if($cek_approve3){
                                        $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10056'")->result();
                                        if($get_sign[0]->sd!=''){?>
                                            <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="120px" /><br>
                                        <?php }else{?>
                                            <span>tanda tangan kosong</span>
                                        <?php }}?>
                            </td>
                        <?php }?>
                        <?php if($app_new==0){?>
                        <td style="width: 135px; padding: 10px">
                            <?php
                                $cek_approve2 = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='10009' AND status='1'") ->result();
                                if($cek_approve2){
                                    $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10009'")->result();
                                    if($get_sign[0]->sd!=''){?>
                                        <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="90px" /><br>
                                    <?php }else{?>
                                        <span>tanda tangan kosong</span>
                                    <?php }}?>
                        </td>
                        <td style="width: 135px; padding: 10px">
                            <?php
                                $cek_approve4 = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='10007' AND status='1'") ->result();
                                if($cek_approve4){
                                    $get_sign = $this->db->query("SELECT sign_dig as sd FROM employee WHERE id_employee='10007'")->result();
                                    if($get_sign[0]->sd!=''){?>
                                        <img src="<?=base_url()?>assets/images/sign/<?=$get_sign[0]->sd;?>" alt="tanda tangan" class="dark-logo" width="90px" /><br>
                                    <?php }else{?>
                                        <span>tanda tangan kosong</span>
                                    <?php }}?>
                        </td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td style="width: 108px; padding: 10px; text-align: center;"><?=$data_atasan[0]->firstname;?></td>
                        <?php //if($data_dir){if($data_dir[0]->id_employee!=10009){if($data_dir[0]->id_employee!=10010 && $data_employee[0]->id_employee!=10006 && $data_employee[0]->id_employee!=10000){?>
                        <!-- <td style="width: 135px; padding: 10px; text-align: center;"><?=$data_dir[0]->firstname;?></td> -->
                        <?php //}}}?>
                        <?php if($approve_old==1){?>
                            <td style="width: 135px; padding: 10px; text-align: center;">Irzan Hanafiah Pulungan</td>
                        <?php }else{?>
                            <td style="width: 135px; padding: 10px; text-align: center;" colspan="4">Yulius Amos</td>
                        <?php }?>
                        <?php if($app_new==0){?>
                        <td style="width: 135px; padding: 10px; text-align: center;">Teddy Tjahjono</td>
                        <td style="width: 135px; padding: 10px; text-align: center;">Risha Widjaya</td>
                        <?php }?>
                    </tr>
                </table>
                <br>
                <p>Keterangan :</p>
                <table border="1" style="font-size: 10px">
                    <tr>
                        <td style="width: 238px; padding: 10px; text-align: center">Hari Tanggal</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Jumlah Hari Bertugas</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Uang Piket Perhari (min 5 jam)</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Total</td>
                    </tr>
                    <tr>
                        <td style="width: 208px; padding: 10px"><?=$dt1.' - '.$dt2;?></td>
                        <td style="width: 135px; padding: 10px; text-align: center"><?=$jumlah_hari;?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><?=number_format($biaya_piket);?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><b><?=number_format($jml_biaya);?></b></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; text-align: center;" colspan="3"><b>Total</b></td>
                        <td style="width: 108px; padding: 10px; text-align: right"><b><?=number_format($jml_biaya);?></b></td>
                    </tr>
                </table><br>
                <?php if($jenis_piket==0){?>
                <table border="1" style="font-size: 10px">
                    <tr>
                        <td style="width: 238px; padding: 10px; text-align: center">Hari Tanggal</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Jam Masuk</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Jam Keluar</td>
                        <td style="width: 135px; padding: 10px; text-align: center">Total Jam</td>
                    </tr>
                    <tr style="background-color: <?php if($hari_1==0){echo '#FF0000';}?>">
                        <td style="width: 208px; padding: 10px"><?=$dt1;?></td>
                        <td style="width: 135px; padding: 10px; text-align: center"><?=$jam_masuk;?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><?=$jam_keluar;?></td>
                        <td style="width: 135px; padding: 10px; text-align: right"><b><?=$interval->format('%h jam %i menit');?></b></td>
                    </tr>
                    <?php if($dt1!=$dt2){
                        ?>
                        <tr style="background-color: <?php if($hari_2==0){echo '#FF0000';}?>">
                            <td style="width: 208px; padding: 10px"><?=$dt2;?></td>
                            <td style="width: 135px; padding: 10px; text-align: center"><?=$jam_masuk2;?></td>
                            <td style="width: 135px; padding: 10px; text-align: right"><?=$jam_keluar2;?></td>
                            <td style="width: 135px; padding: 10px; text-align: right"><b><?=$interval2->format('%h jam %i menit');?></b></td>
                        </tr>
                    <?php }?>
                </table>
                <?php }?>
            </div>
    </body>
</html>