<?php 
$title = 'Planing';
include "../include/header.php";
?>

<h2>Planing</h2>
<hr>
<div class="alert alert-info">
	Planing pembuatan kotak selamat 1 bulan degnan metode MRP
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				TOTAL STOK DI GUDANG
			</div>
			<div class="panel-body">
				<table class="table table-hover" >
					<thead>
						<tr class="active">
							<th>Jenis Bahan</th>
							<th>Stok</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$stok = mysqli_query($conn,"SELECT * FROM stok");
						foreach($stok as $stok1){ 
							?>
							<tr>
								<td><?php echo $stok1['bahan'] ?></td>
								<td><b><?php echo $stok1['jumlah'] ?></b></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				TOTAL PESANAN
			</div>
			<div class="panel-body">
				<table class="table table-hover" >
					<thead>
						<tr class="active">
							<th>Pemesan</th>
							<th>Jumlah Pesan</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$pesanan = mysqli_query($conn,"SELECT pesanan.*, costumer.nama FROM pesanan JOIN costumer ON pesanan.id_costumer=costumer.id_costumer ");
						foreach($pesanan as $pesanan){ 
							?>
							<tr>
								<td><?php echo $pesanan['nama'] ?></td>
								<td><?php echo $pesanan['jumlah_pesanan'] ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td><b>TOTAL</b></td>
							<td>
								<b>
									<?php  
									$total_pesanan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(jumlah_pesanan) as total_pesanan FROM pesanan"));
									echo $total_pesanan['total_pesanan'];
									?>
								</b>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php  
// mengecek planing di database
$query_planing = mysqli_query($conn, "SELECT * FROM planing");
if (mysqli_num_rows($query_planing) > 0) { 
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		Hasil Planing
	</div>
	<div class="panel-body">
		<h4 class="text-center"><b>Produksi per minggu</b></h4>
		<table class="table table-bordered">
			<tr>
				<th>Minggu 1</th>
				<th>Minggu 2</th>
				<th>Minggu 3</th>
				<th>Minggu 4</th>
			</tr>
			<?php 
			$planing = mysqli_fetch_assoc($query_planing); 
			?>
				<tr>
					<td><?php echo $planing['p1'] ?></td>
					<td><?php echo $planing['p2'] ?></td>
					<td><?php echo $planing['p3'] ?></td>
					<td><?php echo $planing['p4'] ?></td>
				</tr>
		</table>
		<br>
		<h4 class="text-center"><b>bahan harus di pesan</b></h4>
		<table class="table table-bordered">
			<tr>
				<th>Bahan</th>
				<th>Stok di gudang</th>
				<th>Kurang (harus di beli)</th>
			</tr>
			<?php 
			$peti = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM stok WHERE bahan = 'peti' "));
			$paku = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM stok WHERE bahan = 'paku' "));
			$kayu = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM stok WHERE bahan = 'kayu' "));
				?>
				<tr class="active">
					<td><?php echo $peti['bahan'] ?></td>
					<td><?php echo $peti['jumlah'] ?></td>
					<td>
						<?php
						$kurang_peti = $peti['jumlah']-$total_pesanan['total_pesanan'];
						echo $peti['jumlah']-$total_pesanan['total_pesanan'] 
						?>
					</td>
				</tr>
				<tr>
					<td style="padding-left: 30px!important"><?php echo $paku['bahan'] ?></td>
					<td><?php echo $paku['jumlah'] ?></td>
					<td><?php echo ($kurang_peti * 32) - $paku['jumlah'] ?></td>
				</tr>
				<tr>
					<td style="padding-left: 30px!important"><?php echo $kayu['bahan'] ?></td>
					<td><?php echo $kayu['jumlah'] ?></td>
					<td><?php echo $kurang_peti ?></td>
				</tr>
		</table>
	</div>
</div>
<?php } ?>


<?php  
if (isset($_POST['submit_planing'])) {
	// menyimpan inputan ke variable
	$p1 = $_POST['p1'];
	$p2 = $_POST['p2'];
	$p3 = $_POST['p3'];
	$p4 = $_POST['p4'];

	// total pesanan dari database
	$total_pes = $total_pesanan['total_pesanan'];

	// menjumlahkan inputan
	$toal_p = $p1 + $p2 + $p3 + $p4;

	// mengecek jika total imputan sama dewngan pesanan
	if ($toal_p == $total_pes) { 
		// menyimpan ke database
		mysqli_query($conn, "UPDATE planing SET p1='$p1', p2='$p2', p3='$p3', p4='$p4' WHERE id_planing = 1 ");

		// redirecy
		echo '<meta http-equiv="refresh" content="0"; URL="stok.php" />';

	}else {
		echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> Jumlah Pesanan Tidak Sama! jumalah harus = <b>'.$total_pes.'</b></div>';
	}
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Planing Ulang
			</div>
			<form method="post">

				<div class="panel-body">
					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Minggu Ke 1 (P1)</label>
							<input type="number" name="p1" class="form-control">
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Minggu Ke 2 (P2)</label>
							<input type="number" name="p2" class="form-control">
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Minggu Ke 3 (P3)</label>
							<input type="number" name="p3" class="form-control">
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Minggu Ke 4 (P4)</label>
							<input type="number" name="p4" class="form-control">
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="text-center">
						<button class="btn btn-primary btn-lg" name="submit_planing">SUBMIT</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



<?php 
include "../include/footer.php";
?>