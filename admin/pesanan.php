<?php 
$title = 'Data Pesanan'; 
include '../include/header.php';
?>

<?php
$xcrud->table('pesanan');
$xcrud->relation('id_costumer','costumer','id_costumer','nama');
echo $xcrud->render();
?>

<?php  
include '../include/footer.php';
?>