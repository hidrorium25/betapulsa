<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
{
	include "global_header.php";
	$sql="select*from operatorbeta";
	$hasil=mysqli_query($con,$sql);
	$sql1 = "select*from pelangganbeta order by nama ASC";
	$hasil1 = mysqli_query($con,$sql1);
	if(isset($_POST['simpan']))
	{
		$sql = "insert into pelangganbeta values('$_POST[nama]','$_POST[nomor]','$_POST[provider]')";
		mysqli_query($con,$sql);
	}
	
?>
<!Doctype html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Data Pelanggan</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/tgl.css" />
	<script src='js/jquery-1.12.3.min.js'></script>
	<script src='js/bootstrap.min.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/zebra_datepicker.js"></script>
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
						<h3>Input Data Pelanggan</h3>
						<div class="form-group">
						  <label>Nama Pelanggan:</label>
						  <input type="text" class="form-control" id="nama" placeholder="Nama Pelanggan" name="nama" oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" required="required" oninput="setCustomValidity('')" />
						</div>
						<div class="form-group">
						  <label>Nomor Pelanggan:</label>
						  <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Nomor Pelanggan" required="required" oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
						</div>
						<div class="form-group">
						  <label>Provider:</label>
						  <select name="provider" class="form-control" id="provider">
								<option value="">==Pilih Provider==</option>
								<?php
								while($baris = mysqli_fetch_array($hasil))
								{ ?>
									<option value="<?php echo $baris['kodeop'];?>" 
									><?php echo $baris['namaop']; ?> </option>
								<?php
								} ?>
							</select>
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
      			<h3>Data Pelanggan</h3>
	  			<?php 
				if(isset($_GET['action'])){
					echo "Berhasil Dihapus";
				} ?>
				<div class="target_layer">
					<?php
					//if(isset($_GET['id'])){
					$query="select transaksi.idtrans,transaksi.nomor,transaksi.jual,transaksi.pembeli,transaksi.tanggal,transaksi.status,operator.namaop,nominal.nilai from transaksi,operator,nominal where status='Belum Lunas' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
					$hasil = mysqli_query($con, $query); ?>     
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Nama</th>
							<th>Nomor</th>
							<th>Action</th>
						<tr>			 
						</tr>
						</thead>
						<tbody>
							<?php
							while($baris1=mysqli_fetch_array($hasil1))
							{
								echo	"<tr>";
								echo	"<td>$baris1[nama]</td>";
								echo	"<td>$baris1[nomor]</td>";
								echo	"<td><a href='#'>Edit</a>|<a href='#'>Hapus</a></td>";
								echo	"</tr>";
							}
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