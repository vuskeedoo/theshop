<?php
session_start();
// Include config file
require_once "config.php";

$rowCount = $_SESSION['rowCount'];

print_r($_POST);
echo "<br>";
$cartno = array();
$pno = array();
$pname = array();
$qty = array();
$cartno = $_POST['cartno'];
$pno = $_POST['pno'];
$qty = $_POST['quantity'];

if(isset($_POST)) {
	for($x = 0; $x < $rowCount; $x++){
		$sql = "UPDATE cart SET qty = ? WHERE cartno = ".$cartno[$x];
		//print($cartno[$x]);
		if($stmt = mysqli_prepare($link, $sql)) {
		    mysqli_stmt_bind_param($stmt, "s", $qty[$x]);
		    mysqli_stmt_execute($stmt);
		    //mysqli_stmt_bind_result($stmt, $cno, $name, $street, $city, $state, $zip, $phone, $email);
		}
	}
}
header("location: cart.php");

?>