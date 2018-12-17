<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
{
	include "global_header.php";
	$sql="select max(idsaldo) as id from saldobeta";
	$hasil=mysqli_query($con,$sql);
	$baris=mysqli_fetch_array($hasil);
	$sql1="select*from saldobeta order by idsaldo desc limit 1";
	$hasil1=mysqli_query($con,$sql1);
	$baris1=mysqli_fetch_array($hasil1);
	if(isset($_POST['simpan'])){
		if($_POST['nomawal']=="" or $_POST['tgl']==""){
			echo "<script>alert('Ada data yang belum terisi')</script>";
		}
		else{
			$sisasal=$baris1['nomakhir'];
			$awal=$_POST['nomawal'];
			$total=$awal+$sisasal;
			$sql="insert into saldobeta(idsaldo,nomawal,nomakhir,tanggal)values('$_POST[id]','$total','$total','$_POST[tgl]')";
			mysqli_query($con,$sql);
			echo "<script>alert('Saldo baru berhasil disimpan');window.location.href = 'saldo.php'</script>";
			
			//header('Location: input.php');
		}
	}
	$sql7="select*from saldobeta order by tanggal DESC";
	$hasil7=mysqli_query($con,$sql7);
?>
<!Doctype html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Saldo</title>   
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
					<form action="" method="POST" enctype="multipart/form-data">
						<h3>Input</h3>
						<div class="form-group">
						  <label>Id saldo:</label>
						  <input type="text" class="form-control" id="id" name="id" value="<?php
							if($baris['id']==null){
									$angka=1;
									$NewID = "S".sprintf("%03s",$angka);
									echo $NewID;
								}
								else{
									$angka = substr($baris['id'],1,4);
									$angka++;
									$NewID = "S".sprintf("%03s",$angka);
									echo $NewID;
							}
							?>" readonly />
						</div>
						<div class="form-group">
						  <label>Saldo Terakhir:</label>
						  <input type="text" class="form-control" id="nomakhir" name="nomakhir"  value="<?php 
						  	if($baris1["nomakhir"]==""){
							echo "0";
							}else{
								echo "$baris1[nomakhir]";
							} ?>" readonly />
						</div>
						<div class="form-group">
						  <label>Nominal Awal:</label>
						  <input type="text" class="form-control" id="nomawal" name="nomawal" required="required" oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
						</div>
						<div class="form-group">
						  <label>Tanggal:</label>
						  <input type="text" name="tgl" id="tanggal" required="required" oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
						</div>
						<div class="form-group">
						  <input type="submit" name="simpan" value="Simpan" />
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
					$query="select transaksi.idtrans,transaksi.nomor,transaksi.jual,transaksi.pembeli,transaksi.tanggal,transaksi.status,operator.namaop,nominal.nilai from transaksi,operator,nominal where status='Belum Lunas' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
					$hasil = mysqli_query($con, $query); ?>     
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Sisa Saldo</th>
							<th>Nominal Pengisian</th>
							<th>Tanggal Pengisian</th>	 
						</tr>
						</thead>
						<tbody>
							<?php while($baris7=mysqli_fetch_array($hasil7))
							{
								echo	"<tr>";
								echo		"<td>$baris7[nomakhir]</td>";
								echo		"<td>$baris7[nomawal]</td>";
								echo		"<td>$baris7[tanggal]</td>";
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