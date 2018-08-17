<?php 
$title = 'Data Costumer'; 
include '../include/header.php';
?>

<?php
$xcrud->table('costumer');
echo $xcrud->render();
?>

<?php  
include '../include/footer.php';
?>