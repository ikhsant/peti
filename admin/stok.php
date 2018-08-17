<?php 
$title = 'Data Stok'; 
include '../include/header.php';
?>

<h2>Data Stok</h2>
<hr>

<div class="panel panel-default" style="max-width: 600px; margin: auto;">
<table class="table table-hover" >
	<thead>
		<tr class="active">
			<th>Jenis Bahan</th>
			<th>Stok</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$stok = mysqli_query($conn,"SELECT * FROM stok");
		foreach($stok as $stok){ 
			?>
			<tr>
				<td><?php echo $stok['bahan'] ?></td>
				<td><b><?php echo $stok['jumlah'] ?></b></td>
				<td>
					<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $stok['id_stok'] ?>"><i class="fa fa-plus"></i> Tambah</button>
					<button class="btn btn-warning" data-toggle="modal" data-target="#myModal2<?php echo $stok['id_stok'] ?>"><i class="fa fa-minus"></i> Kurangi</button>

					<!-- Modal -->
					<div id="myModal<?php echo $stok['id_stok'] ?>" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Tambah Stok <?php echo $stok['bahan'] ?></h4>
								</div>
								<form method="post">
									<div class="modal-body">
										<div class="form-group">
											<label>Jumlah</label>
											<input type="number" name="jumlah" class="form-control" required>
											<input type="hidden" name="id_stok" value="<?php echo $stok['id_stok'] ?>">
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" name="submit_tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>

						<!-- Modal -->
					<div id="myModal2<?php echo $stok['id_stok'] ?>" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Kurangi Stok <?php echo $stok['bahan'] ?></h4>
								</div>
								<form method="post">
									<div class="modal-body">
										<div class="form-group">
											<label>Jumlah</label>
											<input type="number" name="jumlah" class="form-control" required>
											<input type="hidden" name="id_stok" value="<?php echo $stok['id_stok'] ?>">
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" name="submit_kurang" class="btn btn-warning"><i class="fa fa-minus"></i> Kurangi</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
</div>

<?php
// menambah stok ketika di tekan tamhah
if(isset($_POST['submit_tambah'])){
	$id_stok 	= $_POST['id_stok'];
	$jumlah 	= $_POST['jumlah'];

	// menyimapan ke database
	$sql_tambah = mysqli_query($conn,"UPDATE stok SET jumlah = (jumlah + '$jumlah') WHERE id_stok = '$id_stok' ");
	if ($sql_tambah) {
		echo '<meta http-equiv="refresh" content="0"; URL="stok.php" />';
	}else{
		echo "Gagal Menambah Stok";
	}
}
?>

<?php
// mengurangi stok ketika di tekan tamhah
if(isset($_POST['submit_kurang'])){
	$id_stok 	= $_POST['id_stok'];
	$jumlah 	= $_POST['jumlah'];

	// menyimapan ke database
	$sql_tambah = mysqli_query($conn,"UPDATE stok SET jumlah = (jumlah - '$jumlah') WHERE id_stok = '$id_stok' ");
	if ($sql_tambah) {
		echo '<meta http-equiv="refresh" content="0"; URL="stok.php" />';
	}else{
		echo "Gagal Menambah Stok";
	}
}
?>

<?php  
include '../include/footer.php';
?>