<!Doctype html>
<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
{
	include "global_header.php";
	$sql="select idsaldo,nomakhir from saldobeta order by idsaldo desc limit 1";
	$hasil=mysqli_query($con,$sql);
	$baris=mysqli_fetch_assoc($hasil);
	if(isset($_POST['submittrans']))
	{
		if($_POST['voucher']=="" or $_POST['nominal']=="" or $_POST['modal']=="" or $_POST['pembeli']=="" or $_POST['tgl']=="" or $_POST['jual']=="" or $_POST['nomor']==""){
			echo "<script>alert('Ada data yang belum terisi');window.location.href='admin.php'</script>";
		}
		else{
			$akhir=$baris['nomakhir'];
			$idsal=$baris['idsaldo'];
			$modal=$_POST['modal'];
			$sisa=$akhir-$modal;
			$status="Belum Lunas";
			if($sisa<0){
				echo "<script>alert('Saldo anda tidak cukup')</script>";
			}
			elseif($sisa>=0){
				$sql="insert into transaksibeta(idtrans,idsaldo,kodeop,kodenom,modal,jual,nomor,pembeli,tanggal,status)value('$_POST[kodetrans]','$idsal','$_POST[voucher]','$_POST[nominal]','$modal',$_POST[jual],$_POST[nomor],'$_POST[pembeli]','$_POST[tgl]','$status')";
				mysqli_query($con,$sql);
				$sql1="update saldobeta set nomakhir='$sisa' where idsaldo='$baris[idsaldo]'";
				mysqli_query($con,$sql1);
				echo "<script>alert('Data berhasil disimpan');window.location.href='admin.php'</script>";
			}
			
		}
	}
?>

<?php
}
else
{
	echo "Anda belum login, silahkan login dulu.";
	echo "<a href='index.php'>Login</a>";
}
?>