<!--
Author : Aguzrybudy
Created : Selasa, 19-April-2016
Title : Crud Menggunakan Modal Bootsrap
-->
<?php
    include "koneksi.php";
	$tgl=date('Y-m-d');
	$modal_id=$_GET['idtrans'];
	$modal=mysqli_query($con,"SELECT * FROM transaksi WHERE idtrans='$modal_id'");
	while($r=mysqli_fetch_array($modal)){
?>

<div class="modal-dialog">
    <div class="modal-content">

    	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Edit Data Menggunakan Modal Boostrap (popup)</h4>
        </div>

        <div class="modal-body">
        	<form action="proses_edit.php" name="modal_popup" enctype="multipart/form-data" method="POST">
        		
                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="nama">Nama</label>
                    <input type="hidden" name="modal_id"  class="form-control" value="<?php echo $r['idtrans']; ?>" />
     				<input type="text" name="modal_name"  class="form-control" value="<?php echo $r['pembeli']; ?>" disabled/>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Metode">Metode Pembayaran</label>
     				<select name="metode" class="form-control">
						<option>Pilih Metode Pembayaran</option>
						<option value="Tunai">Tunai</option>
						<option value="Transfer">Transfer</option>
					</select>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Ket">Keterangan</label>       
     				<textarea name="ket"  style="resize:none" class="form-control"></textarea>
                </div>

	            <div class="modal-footer">
	                <button class="btn btn-success" type="submit">
	                    Confirm
	                </button>

	                <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
	               		Cancel
	                </button>
	            </div>

            	</form>

             <?php } ?>

            </div>

           
        </div>
    </div>