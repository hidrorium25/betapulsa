<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
{
	include "global_header.php";
	$sql="select*from saldo";
	$hasil=mysqli_query($con,$sql);
	if(isset($_POST['cari']))
	{
		if($_POST['saldo']!="" and $_POST['status']=="" and $_POST['nomor']=="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan
			from transaksi,operator,nominal 
			where idsaldo='$_POST[saldo]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		elseif($_POST['saldo']=="" and $_POST['status']=="" and $_POST['nomor']!="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan 
			from transaksi,operator,nominal 
			where nomor='$_POST[nomor]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		else if($_POST['saldo']=="" and $_POST['status']!="" and $_POST['nomor']=="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan 
			from transaksi,operator,nominal
			where status='$_POST[status]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		elseif($_POST['saldo']!="" and $_POST['status']=="" and $_POST['nomor']!="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan
			from transaksi,operator,nominal 
			where nomor='$_POST[nomor]' and idsaldo='$_POST[saldo]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		else if($_POST['saldo']!="" and $_POST['status']!="" and $_POST['nomor']=="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan 
			from transaksi,operator,nominal
			where idsaldo='$_POST[saldo]' and status='$_POST[status]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		else if($_POST['saldo']=="" and $_POST['status']!="" and $_POST['nomor']!="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan 
			from transaksi,operator,nominal
			where status='$_POST[status]' and nomor='$_POST[nomor]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		else if($_POST['saldo']!="" and $_POST['status']!="" and $_POST['nomor']!="")
		{
			$sql="select transaksi.modal,transaksi.jual,transaksi.nomor,transaksi.pembeli,transaksi.tanggal,transaksi.tanggalbyr,transaksi.status,operator.namaop,nominal.nilai, transaksi.Metode, transaksi.Keterangan 
			from transaksi,operator,nominal
			where idsaldo='$_POST[saldo]' and status='$_POST[status]' and nomor='$_POST[nomor]' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
			$hasil1=mysqli_query($con,$sql);
		}
		else
		{
			echo "<script>alert('Anda belum memasukkan data pencarian');window.location.href='laporan.php'</script>";
		}
	}

	$total=0;
	$totun=0;
	
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
  			<!--<li class="active"><a data-toggle="tab" href="#input">Input</a></li>-->
    		<li class="active"><a data-toggle="tab" href="#data">View</a></li>
  		</ul>
  		<div class="tab-content">
		<div id="data" class="tab-pane fade in active">
      			<h3>Laporan</h3>
	  			<?php 
				if(isset($_GET['action'])){
					echo "Berhasil Dihapus";
				} ?>
				<div class="target_layer">
				<form action="" method="POST">
				<table>
						<tr>
							<td>Saldo</td>
							<td>:</td>
							<td><select name="saldo">
								<option value="">==Silahkan pilih saldo==</option>
							<?php 
							if(isset($_POST['saldo']))
							{
								while($baris=mysqli_fetch_array($hasil))
								{
									echo "<option values='".$baris['idsaldo']."' ".($baris['idsaldo']==$baris['idsaldo'] ? "selected='selected'":'').">$baris[idsaldo]</option>";
								}	
							}
							else
							{
								while($baris=mysqli_fetch_array($hasil))
								{
									echo "<option values=".$baris['idsaldo'].">$baris[idsaldo]</option>";
								}
							}
							?></td>
							<td>Nomor</td>
							<td>:</td>
							<td><input type="text" name="nomor" placeholder="Masukkan Nomor Pelanggan" value="<?php 
							if(isset($_POST['cari']))
							{
								echo $_POST['nomor'];
							}
							?>"/></td>
						</tr>
						<tr>
							<td>Status</td>
							<td>:</td>
							<td>
							<select name="status">
								<option value="">==Silahkan Dipilih==</option>
								<option value="Lunas">Lunas</option>
								<option value="Belum Lunas">Belum Lunas</option>
							</select>
							</td>
							<td><input type="submit" name="cari" value="Cari" /></td>
						</tr>
					</table>
				</form>
					<?php
					//if(isset($_GET['id'])){
					$query="select transaksi.idtrans,transaksi.nomor,transaksi.jual,transaksi.pembeli,transaksi.tanggal,transaksi.status,operator.namaop,nominal.nilai from transaksi,operator,nominal where status='Belum Lunas' and transaksi.kodeop=operator.kodeop and transaksi.kodenom=nominal.kodenom";
					$hasil = mysqli_query($con, $query); ?>     
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Voucher</th>
							<th>Nominal</th>
							<th>Nomor Pembeli</th>
							<th>Pembeli</th>
							<th>Tanggal Beli</th>
							<th>Tanggal Bayar</th>
							<th>Modal</th>
							<th>Status</th>
							<th>Jual</th>
							<th>Keuntungan</th>
							<th>Metode</th>
							<th>Keterangan</th>							
						</tr>
						</thead>
						<tbody>
							<?php
							if(isset($_POST['cari']))
							{
								while($baris1=mysqli_fetch_array($hasil1))
								{
									$total += $baris1['jual'];
									$untung = $baris1['jual']-$baris1['modal'];
									$totun +=$untung;
									echo	"<tr>";
									echo		"<td>$baris1[namaop]</td>";
									echo		"<td>$baris1[nilai]</td>";
									echo		"<td>$baris1[nomor]</td>";
									echo		"<td>$baris1[pembeli]</td>";
									echo		"<td>$baris1[tanggal]</td>";
									echo		"<td>$baris1[tanggalbyr]</td>";
									echo		"<td>$baris1[modal]</td>";
									echo		"<td>$baris1[status]</td>";
									echo		"<td>$baris1[jual]</td>";
									echo		"<td>$untung</td>";
									echo		"<td>$baris1[Metode]</td>";
									echo		"<td>$baris1[Keterangan]</td>";
									echo	"</tr>";
								}
							}
							?>
							<tr>
								<td colspan="8">Total</td>
								<td><?php if($total==0)
								{
									echo $total;
								}
								else
								{
									echo $total;
								} ?></td>
								<td><?php if($totun==0)
								{
									echo $totun;
								}
								else
								{
									echo $totun;
								} ?></td>
							</tr>
						</tbody>
					</table>
				</div>
		    </div>
		  </div
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