<?php
	include "koneksi.php";
	$tgl=date('Y-m-d');
	$modal_id=$_POST['modal_id'];
	$modal_name = $_POST['modal_name'];
	$metode = $_POST['metode'];
	$ket = $_POST['ket'];
	$modal=mysqli_query($con,"UPDATE transaksi SET Metode='$metode',Keterangan='$ket',status='Lunas',tanggalbyr='$tgl' WHERE idtrans = '$modal_id'");
	header('location:admin.php');
?>