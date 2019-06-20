<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>History Cuti <?=$data_karyawan[0]->firstname;?></h2><br>                                                                           
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>Jenis Cuti</th>
        <th>Tanggal</th>
        <th>Keperluan</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach($data_cuti as $view){
        $id_cuti = $view->id_cuti;
        $jenis_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
      ?>
      <tr>
        <td><?=$no;?></td>
        <td><?=$jenis_cuti[0]->jenis_cuti;?></td>
        <td>
            <?php 
                $tanggal1 = strtotime($view->start_date); $dt = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($view->end_date); $dt2 = date("d F Y  ", $tanggal2);
                echo $dt.' - '.$dt2 ;?>
        </td>
        <td><?=$view->reason;?></td> 
      </tr>
      <?php $no++;}?>
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
