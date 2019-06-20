<!DOCTYPE html>
<html lang="en">
<head>
  <title>List Reset</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>List Reset</h2>          
  <table class="table table-striped">
    <thead>
      <tr>
      	<th>No</th>
        <th>Email</th>
        <th>Token</th>
        <th>Expired</th>
        <th>Is Tag</th>
      </tr>
    </thead>
    <tbody>
    <?php $no=1; foreach($data as $view){?>
      <tr>
      	<td><?=$no;?></td>
        <td><?=$view->email;?></td>
        <td><?=$view->token;?></td>
        <td><?=$view->expired_date;?></td>
        <td><?=$view->is_tag;?></td>
      </tr>
     <?php $no++;}?>
    </tbody>
  </table>
</div>

</body>
</html>
