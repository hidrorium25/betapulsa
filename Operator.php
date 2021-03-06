<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
{
	include "global_header.php";
	if(isset($_POST['simpan'])){
		$sql="insert into operatorbeta(kodeop,namaop)values('$_POST[op]','$_POST[namaop]')";
		mysqli_query($con,$sql);
	}
	
?>
<!Doctype html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Transaksi</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/tgl.css" />
	<script src='js/jquery-1.12.3.min.js'></script>
	<script src='js/bootstrap.min.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/zebra_datepicker.js"></script>
	<script>
			$(document).ready(function(){
				$('#tanggal').Zebra_DatePicker({
				format: 'Y-F-d',
				months : ['01','02','03','04','05','06','07','08','09','10','11','12'],
				days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
				days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
				});
			});
	</script>
</head>
<body>
	<div class="container">
  		<ul class="nav nav-tabs">
  			<li class="active"><a data-toggle="tab" href="#input">Input</a></li>
    		<li><a data-toggle="tab" href="#data">View</a></li>
  		</ul>
  		<div class="tab-content">
    		
    <div id="input" class="tab-pane fade in active">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4" >
					<form action="" method="POST">
						<h3>Input Operator</h3>
						<div class="form-group">
						  <label>Kode Operator:</label>
						  <input type="text" class="form-control" id="op" placeholder="Kode Operator" name="op" required="required" oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
						</div>
						<div class="form-group">
						  <label>Nama Operator:</label>
						  <input type="text" class="form-control" id="namaop" name="namaop" placeholder="Nama Operator" required="required" oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
						</div>
						<div class="form-group">
						   <input type="submit" value="Simpan" name="simpan">
						</div>
					</form>		
				</div>
			</div>
		</div>
    </div>
    <div id="data" class="tab-pane fade">
      			<h3>Transaksi</h3>
	  			<?php 
				if(isset($_GET['action'])){
					echo "Berhasil Dihapus";
				} ?>
				<div class="target_layer">
					<?php
					//if(isset($_GET['id'])){
					$query="select*from operatorbeta";
					$hasil = mysqli_query($con, $query); ?>     
					<table class="table table-striped">
						<thead>
						<tr>
							<th>kodeop</th>
							<th>namaop</th>
							<th>Action</th>				 
						</tr>
						</thead>
						<tbody>
							<?php
								while($baris = mysqli_fetch_array($hasil))
								{
									echo	"<tr>";
									echo	"<td>$baris[kodeop]</td>";
									echo	"<td>$baris[namaop]</td>";
									echo	"<td><a href='#'>Edit</a>|<a href='#'>Hapus</a>";
									echo	"</tr>";
								}
						//}
							?>
						</tbody>
			</table>
		</div>
    </div>
  </div>
</div>
</body>
</html>
<?php
}
else
{
	echo "Anda belum login, silahkan login dulu.";
	echo "<a href='index.php'>Login</a>";
}
?>