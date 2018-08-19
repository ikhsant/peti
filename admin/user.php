<?php 
$title = 'User';
include "../include/header.php";
?>

<?php
$xcrud->table('user');
$xcrud->change_type('password', 'password', 'sha1', array('maxlength'=>10,'placeholder'=>'Masukan password'));
$xcrud->change_type('foto', 'image');
$xcrud->change_type('akses_level','select','','admin,operator');
echo $xcrud->render();
?>

<?php 
include "../include/footer.php";
?>