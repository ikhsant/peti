<?php  
include '../include/header.php';
?>

<?php 
// notif pesan
if (!empty($_SESSION['pesan'])) { ?>
	<div class="alert alert-success">
		<i class="fa fa-check"></i> <?php echo $_SESSION['pesan']; ?>
	</div>
	<br>
	<?php 
	$_SESSION['pesan'] = '';
} 

// notif pesan ewrror
if (!empty($_SESSION['error'])) { ?>
	<div class="alert alert-danger">
		<i class="fa fa-check"></i> <?php echo $_SESSION['error']; ?>
	</div>
	<br>
	<?php 
	$_SESSION['error'] = '';
} 
?>

<?php  
$peti = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM stok WHERE bahan = 'peti'"));
$paku = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM stok WHERE bahan = 'paku'"));
$kayu = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM stok WHERE bahan = 'kayu'"));
?>

<script type="text/javascript" src="../assets/js/Chart.min.js"></script>
<h1>Dashboard</h1>
<hr>
<div class="col-md-6">

	<div class="panel panel-default">
		<div class="panel-heading">
			Chart STOK
		</div>
		<div class="panel-body">
			<canvas id="myChart" height="200px"></canvas>
		</div>
	</div>
</div>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			Bahan Yang harus di pesan
		</div>
		<div class="panel-body">
			<table class="table table-bordered">
				<tr>
					<th>Bahan</th>
					<th>Stok di gudang</th>
					<th>Kurang (harus di beli)</th>
				</tr>
				<?php 
				$total_pesanan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(jumlah_pesanan) as total_pesanan FROM pesanan"));

				?>
				<tr class="active">
					<td><?php echo $peti['bahan'] ?></td>
					<td><?php echo $peti['jumlah'] ?></td>
					<td>
						<?php
						$kurang_peti = $peti['jumlah']-$total_pesanan['total_pesanan'];
						echo $peti['jumlah']-$total_pesanan['total_pesanan'].' (yang harus di buat)'
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
</div>


<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ["Peti", "Paku", "Kayu"],
			datasets: [{
				label: '# Stok',
				data: [<?php echo $peti['jumlah'] ?>, <?php echo $paku['jumlah'] ?>, <?php echo $kayu['jumlah'] ?>],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)'
				],
				borderWidth: 1
			}]
		},

	});
</script>
<?php  
include '../include/footer.php';
?>