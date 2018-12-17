<?php
include "koneksi.php";
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand">Form Admin</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="admin.php">Transaksi</a></li>
        <li><a href="saldo.php">Saldo</a></li>
        <li><a href="Operator.php">Operator</a></li>
        <li><a href="kodepulsa.php">Kode Pulsa</a></li>
        <li><a href="pelanggan.php">Pelanggan</a></li>
        <li><a href="Laporan.php">Laporan</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>