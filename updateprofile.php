<?php
session_start();
require_once ("config.php");


if($_POST['name'] != null) {
	$_SESSION['name'] = $_POST['name'];
}
if($_POST['street'] != null) {
	$_SESSION['street'] = $_POST['street'];
}
if($_POST['city'] != null) {
	$_SESSION['city'] = $_POST['city'];
}
if($_POST['state'] != null) {
	$_SESSION['state'] = $_POST['state'];
}
if($_POST['zip'] != null) {
	$_SESSION['zip'] = $_POST['zip'];
}
if($_POST['phone'] != null) {
	$_SESSION['phone'] = $_POST['phone'];
}
if($_POST['email'] != null) {
	$_SESSION['email'] = $_POST['email'];
}

print_r($_SESSION);

$sql = "UPDATE customers SET name = ?, street = ?, city = ?, state = ?, zip = ?, phone = ?, email = ? WHERE cno = ".$_SESSION['cno'];
if($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "sssssss", $_SESSION['name'], $_SESSION['street'], $_SESSION['city'], $_SESSION['state'], $_SESSION['zip'], $_SESSION['phone'], $_SESSION['email']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
}
header("location: profile.php");

?>