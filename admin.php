<?php
ob_start();
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
{
	include "global_header.php";
	$set = 0;
	$tgl=date('Y-m-d');
	$sql="select idsaldo,nomakhir from saldobeta order by idsaldo desc limit 1";
	$hasil=mysqli_query($con,$sql);
	$baris=mysqli_fetch_assoc($hasil);
	$sql1="select*from operatorbeta";
	$hasil1=mysqli_query($con,$sql1);
	$sql3="select max(idtrans) as id from transaksibeta";
	$hasil3=mysqli_query($con,$sql3);
	$baris3=mysqli_fetch_array($hasil3);
	#Testing#
	#$idtrans="select*from transaksi";
	#$hasiltrans=mysqli_query($con,$idtrans);
	#$angka1=1;
	#while($baristrans=mysqli_fetch_array($hasiltrans))
	#{
	#	$angka = substr($baristrans['idtrans'],1,4);
	#	if($angka!=$angka1)
	#	{
	#		$NewID = "T".sprintf("%03s",$angka1);
	#	}
	#	else
	#	{
	#		$angka1++;
	#	}
	#}
	#testing#
	if(isset($_GET['kode']))
	{
		$sql="update transaksibeta set status='Lunas',tanggalbyr='$tgl' where idtrans='$_GET[kode]'";
		mysqli_query($con,$sql);
		header('location: admin.php');
	}
	else{}
	//if(isset($_GET['id'])){
	//	$set = 1;
	//	$id = $_GET['id'];
		
	//}
	if($baris3['id']==null)
	{
		$set=1;
	}
	else
	{
		$set=0;
	}
	if(isset($_POST['save']))
	{
		$query="select*from transaksibeta where idtrans='$_GET[id]'";
		$hasi = mysqli_query($con, $query);
		$save1=mysqli_fetch_array($hasi);
		$hargaawal=$save1['jual'];
		$nomakhir=$baris['nomakhir'];
		$salid=$baris['idsaldo'];
		$sal=$nomakhir+$hargaawal;
		$sql="update saldobeta set nomakhir=$sal where idsaldo='$salid'";
		mysqli_query($con,$sql);
		$up="update transaksibeta set jual='$_POST[jual]' where idtrans='$id'";
		mysqli_query($con,$up);
		$jual=$_POST['jual'];
		$sal1=$sal-$jual;
		$up1="update saldobeta set nomakhir='$sal1' where idsaldo='$salid'";
		mysqli_query($con,$up1);
		header('location: admin.php');
	}
	if(isset($_POST['cancel']))
	{
		header('location: admin.php');
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
	<script src='js/bootstrap.min.js'></script>
</head>
<body>
<div class="container">
	<?php
	if($set==1)
	{ ?>
  		<ul class="nav nav-tabs">
  			<li class="active"><a data-toggle="tab" href="#input">Input</a></li>
    		<li ><a data-toggle="tab" href="#data">View</a></li>
  		</ul>
  		<div class="tab-content">	
			<div id="input" class="tab-pane fade in active"">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-4" >
							<form action="Proses_Input.php" method="POST" enctype="multipart/form-data">
								<h3>Input</h3>
								<div class="form-group">
									<label>Kode Transaksi:</label>
									<input type="text" class="form-control" id="nama" name="kodetrans" value="<?php 
											$angka=$baris3['id']+1;
											$NewID = "T".sprintf("%03s",$angka);
											echo $NewID;
									?>" readonly />
								</div>
								<div class="form-group">
									<label>Sisa Saldo:</label>
									<input type="text" class="form-control" id="nomakhir" name="nomakhir" value="<?php echo "$baris[nomakhir]"; ?>"readonly />
								</div>
								<div class="form-group">
									<label>Voucher:</label>
									<select class="form-control" id="voucher" name="voucher" onchange="window.location='?op=' +this.value">
									<option value="">==Silahkan Pilih Voucher==</option>
									<?php
									while($baris1 = mysqli_fetch_array($hasil1))
									{ ?>
										<option value="<?php echo $baris1['kodeop'];?>" 
										<?php 
										if(isset($_GET['op']))
										{
											if($baris1['kodeop'] == $_GET['op'])
											{
												echo "selected = 'selected'";
											}
										}?>> <?php echo "$baris1[namaop]"; ?> </option>
										<?php
									} ?>
									</select>
								</div>
								<?php
								if(isset($_GET['op']))
									{
										$sql2 = "select * from nominalbeta where kodeop = '".$_GET['op']."' order by nilai ASC";
										$hasil2 = mysqli_query($con, $sql2);
										$op = $_GET['op'];
									}
								?>
								<div class="form-group">
								  <label>Nominal:</label>
								  <select class="form-control" id="nominal" name="nominal" onchange="window.location='?op=<?php echo $op; ?>'+'&nom=' +this.value"> 
									<option value="">::Pilih Nominal::</option>
									<?php
										while($baris2 = mysqli_fetch_array($hasil2))
										{?>
											<option value="<?php echo $baris2['kodenom'];?>" 
											<?php 
												if(isset($_GET['nom']))
												{
													if($baris2['kodenom'] == $_GET['nom'])
													{
														echo "selected = 'selected'";
													}
												}?>> <?php echo "$baris2[nilai]"; ?> </option>
										<?php
										}?>
									</select>
								</div>
								<?php
									if(isset($_GET['nom']))
									{
										$sqlpel="select*from pelangganbeta where provider='$_GET[op]' order by nama ASC";
										$hasilpel=mysqli_query($con,$sqlpel);
										$nom = $_GET['nom'];
									}
								?>
								<div class="form-group">
								  <label>Pembeli:</label>
								  <select class="form-control" id="pembeli" name="pembeli" onchange="window.location='?op=<?php echo $op; ?>'+'&nom=<?php echo $nom; ?>'+'&pel=' +this.value"> 
								<option value="">::Pilih Pembeli::</option>
								<?php
									while($barispel = mysqli_fetch_array($hasilpel))
									{?>
										<option value="<?php echo $barispel['nama'];?>" 
										<?php 
											if(isset($_GET['pel']))
											{
												if($barispel['nama'] == $_GET['pel'])
												{
													echo "selected = 'selected'";
												}
											}?>> <?php echo "$barispel[nama]"; ?> </option>
									<?php
									}?>
								</select>
								</div>
								<?php
								if(isset($_GET['pel']))
								{
									$sqlpel1="select nomor from pelangganbeta where nama='$_GET[pel]'";
									$hasilpel1=mysqli_query($con,$sqlpel1);
									$barispel1=mysqli_fetch_assoc($hasilpel1);
								} ?>
								<div class="form-group">
								  <label>Nomor Pembeli:</label>
								  <input type="text" class="form-control" id="nomor" name="nomor"  value="<?php
									if(isset($_GET['pel']))
									{
										echo $barispel1['nomor'];
									}
									else{ }
								?>" readonly />
								</div>
								<div class="form-group">
								  <label>Modal:</label>
								  <input type="text" class="form-control" id="modal" name="modal">
								</div>
								<div class="form-group">
								  <label>Jual:</label>
								  <input type="text" class="form-control" id="jual" name="jual">
								</div>
								<div class="form-group">
								  <label>Tanggal:</label>
								  <input type="text" id="tanggal" name="tgl">
								</div>
								<div class="form-group">
								   <input type="submit" value="Simpan" name="submittrans">
								</div>
							</form>		
						</div>
					</div>
				</div>
			</div>
			<div id="data" class="tab-pane fade>
				<h3>Transaksi</h3>
				<?php
					if(isset($_GET['action']))
					{
						echo "Berhasil Dihapus";
					} ?>
					<div class="target_layer">
					<?php
					//if(isset($_GET['id'])){
					$query="select transaksibeta.idtrans,transaksibeta.nomor,transaksibeta.jual,transaksibeta.pembeli,transaksibeta.tanggal,transaksibeta.status,operatorbeta.namaop,nominalbeta.nilai from transaksibeta,operatorbeta,nominalbeta where status='Belum Lunas' and transaksibeta.kodeop=operatorbeta.kodeop and transaksibeta.kodenom=nominalbeta.kodenom";
					$hasil = mysqli_query($con, $query); ?>   
					<form method="post" action="">
					<table class="table table-striped">
						<thead>
						<tr>
							<th style="display:none;">Idtrans</th>
							<th>Voucher</th>
							<th>Nominal</th>
							<th>Nomor Pembeli</th>
							<th>Harga Jual</th>
							<th>Pembeli</th>
							<th>Tanggal Beli</th>
							<th>Status</th>
							<th>Action</th>				 
						</tr>
						</thead>
						<tbody>
						<?php
							while($baris = mysqli_fetch_array($hasil))
							{
								if($id==$baris['idtrans'])
								{
									echo	"<tr>";
									echo 	"<td style='display:none;'>$baris[idtrans]</td>";
									echo	"<td>$baris[namaop]</td>";
									echo	"<td>$baris[nilai]</td>";
									echo	"<td>$baris[nomor]</td>";
									echo	"<td><input type='text' name='jual' value='$baris[jual]'</td>";
									echo	"<td>$baris[pembeli]</td>";
									echo	"<td>$baris[tanggal]</td>";
									echo	"<td>$baris[status]</td>";
									echo	"<td><input type='submit' name='save' value='Save'>|<input type='submit' name='cancel' value='Cancel'></td>";
									echo	"</tr>";
								}
								else
								{
									echo	"<tr>";
									echo 	"<td style='display:none;'>$baris[idtrans]</td>";
									echo	"<td>$baris[namaop]</td>";
									echo	"<td>$baris[nilai]</td>";
									echo	"<td>$baris[nomor]</td>";
									echo	"<td>$baris[jual]</td>";
									echo	"<td>$baris[pembeli]</td>";
									echo	"<td>$baris[tanggal]</td>";
									echo	"<td>$baris[status]</td>";
									echo	"<td><a href='admin.php?id=$baris[idtrans]'>Edit</a>|<a href='del.php?kode=$baris[idtrans]'>Hapus</a>|<a href='admin.php?kode=$baris[idtrans]'>Lunas</a></td>";
									echo	"</tr>";
								}
							} ?>
						</tbody>
					</table>
					</form>
				</div>
			</div>
		</div>
	<?php } 
	else{ ?>
		<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#input">Input</a></li>
				<li ><a data-toggle="tab" href="#data">View</a></li>
			</ul>
			<div class="tab-content">
				
		<div id="input" class="tab-pane fade in active">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4" >
						<form action="Proses_Input.php" method="POST" enctype="multipart/form-data">
							<h3>Input</h3>
							<div class="form-group">
								<label>Kode Transaksi:</label>
								<input type="text" class="form-control" id="nama" name="kodetrans" value="<?php
									if($baris3['id']==null)
										{
											
										}
										else{
											$angka=substr($baris3['id'],1,3)+1;
											$NewID = "T".sprintf("%03s",$angka);
											echo $NewID;
										}
								 ?>" readonly />
							</div>
							<div class="form-group">
								<label>Sisa Saldo:</label>
								<input type="text" class="form-control" id="nomakhir" name="nomakhir" value="<?php echo "$baris[nomakhir]" ?>"readonly />
							</div>
							<div class="form-group">
								<label>Voucher:</label>
								<select class="form-control" id="voucher" name="voucher" onchange="window.location='?op=' +this.value">
								<option value="">==Silahkan Pilih Voucher==</option>
								<?php
								while($baris1 = mysqli_fetch_array($hasil1))
								{ ?>
									<option value="<?php echo $baris1['kodeop'];?>" 
									<?php 
										if(isset($_GET['op']))
										{
											if($baris1['kodeop'] == $_GET['op'])
											{
												echo "selected = 'selected'";
											}
										}?>> <?php echo "$baris1[namaop]"; ?> </option>
								<?php
								} ?>
								</select>
							</div>
							<?php
							if(isset($_GET['op']))
								{
									$sql2 = "select * from nominalbeta where kodeop = '".$_GET['op']."' order by nilai ASC";
									$hasil2 = mysqli_query($con, $sql2);
									$op = $_GET['op'];
								}
							?>
							<div class="form-group">
								<label>Nominal:</label>
								<select class="form-control" id="nominal" name="nominal" onchange="window.location='?op=<?php echo $op; ?>'+'&nom=' +this.value"> 
								<option value="">::Pilih Nominal::</option>
								<?php
									while($baris2 = mysqli_fetch_array($hasil2))
									{?>
										<option value="<?php echo $baris2['kodenom'];?>" 
										<?php 
											if(isset($_GET['nom']))
											{
												if($baris2['kodenom'] == $_GET['nom'])
												{
													echo "selected = 'selected'";
												}
											}?>> <?php echo "$baris2[nilai]"; ?> </option>
									<?php
									}?>
								</select>
							</div>
							<?php
								if(isset($_GET['nom']))
								{
									$sqlpel="select*from pelangganbeta where provider='$_GET[op]' order by nama ASC";
									$hasilpel=mysqli_query($con,$sqlpel);
									$nom = $_GET['nom'];
								}
							?>
							<div class="form-group">
							  <label>Pembeli:</label>
							  <select class="form-control" id="pembeli" name="pembeli" onchange="window.location='?op=<?php echo $op; ?>'+'&nom=<?php echo $nom; ?>'+'&pel=' +this.value"> 
							<option value="">::Pilih Pembeli::</option>
							<?php
								while($barispel = mysqli_fetch_array($hasilpel))
								{?>
									<option value="<?php echo $barispel['nama'];?>" 
									<?php 
										if(isset($_GET['pel']))
										{
											if($barispel['nama'] == $_GET['pel'])
											{
												echo "selected = 'selected'";
											}
										}?>> <?php echo "$barispel[nama]"; ?> </option>
								<?php
								}?>
							</select>
							</div>
							<?php
								if(isset($_GET['pel']))
								{
									$sqlpel1="select nomor from pelangganbeta where nama='$_GET[pel]'";
									$hasilpel1=mysqli_query($con,$sqlpel1);
									$barispel1=mysqli_fetch_assoc($hasilpel1);
								}
							?>
							<div class="form-group">
							  <label>Nomor Pembeli:</label>
							  <input type="text" class="form-control" id="nomor" name="nomor"  value="<?php
								if(isset($_GET['pel']))
								{
									echo $barispel1['nomor'];
								}
								else{ }
							?>" readonly />
							</div>
							<div class="form-group">
							  <label>Modal:</label>
							  <input type="text" class="form-control" id="modal" name="modal">
							</div>
							<div class="form-group">
							  <label>Jual:</label>
							  <input type="text" class="form-control" id="jual" name="jual">
							</div>
							<div class="form-group">
							  <label>Tanggal:</label>
							  <input type="text" id="tanggal" name="tgl">
							</div>
							<div class="form-group">
							   <input type="submit" value="Simpan" name="submittrans">
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
						$query="select transaksibeta.idtrans,transaksibeta.nomor,transaksibeta.jual,transaksibeta.pembeli,transaksibeta.tanggal,transaksibeta.status,operatorbeta.namaop,nominalbeta.nilai from transaksibeta,operatorbeta,nominalbeta where status='Belum Lunas' and transaksibeta.kodeop=operatorbeta.kodeop and transaksibeta.kodenom=nominalbeta.kodenom";
						$hasil = mysqli_query($con, $query); ?>     
						<table class="table table-striped">
							<thead>
							<tr>
								<th style="display:none;">Idtrans</th>
								<th>Voucher</th>
								<th>Nominal</th>
								<th>Nomor Pembeli</th>
								<th>Harga Jual</th>
								<th>Pembeli</th>
								<th>Tanggal Beli</th>
								<th>Status</th>
								<th>Action</th>				 
							</tr>
							</thead>
							<tbody>
								<?php
									while($baris = mysqli_fetch_array($hasil))
									{
										echo	"<tr>";
										echo 	"<td style='display:none;'>$baris[idtrans]</td>";
										echo	"<td>$baris[namaop]</td>";
										echo	"<td>$baris[nilai]</td>";
										echo	"<td>$baris[nomor]</td>";
										echo	"<td>$baris[jual]</td>";
										echo	"<td>$baris[pembeli]</td>";
										echo	"<td>$baris[tanggal]</td>";
										echo	"<td>$baris[status]</td>"; ?>
										<td><a href="admin.php?id=<?php echo $baris['idtrans'] ?>">Edit</a>|<a href="del.php?kode=$baris['idtrans']">Hapus</a>|<a href="#" class='open_modal' id='<?php echo  $baris['idtrans']; ?>'>Lunas</a></td>
										<?php echo	"</tr>";
									}
							//}
								?>
							</tbody>
				</table>
			</div>
		</div>
	  </div>
	<?php } ?>
</div>
<!-- Modal Popup untuk Edit--> 
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit--> 
<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "modal_edit.php",
    			   type: "GET",
    			   data : {idtrans: m,},
    			   success: function (ajaxData){
      			   $("#ModalEdit").html(ajaxData);
      			   $("#ModalEdit").modal('show',{backdrop: 'true'});
      		   }
    		   });
        });
      });
</script>
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