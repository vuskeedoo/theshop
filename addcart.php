<?php
session_start();
// Include config file
require_once "config.php";

if($stmt = mysqli_prepare($link, $sql)) {
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['cno']);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt, $name, $street, $city, $state, $zip);

  if(mysqli_stmt_num_rows($stmt) == 1) {
    while(mysqli_stmt_fetch($stmt)) {
        $_SESSION["cno"] = $cno;
    }
  }
 }

$rowCount = $_SESSION['rowCount'];

print_r($_SESSION);
print_r($_POST);
echo "<br>";
$pno = array();
$qty = array();
$pno = $_POST['pno'];
$qty = $_POST['quantity'];
$cno = $_SESSION['cno'];
print_r($pno);
echo "<br>";
print_r($qty);
echo "<br>";
if(isset($_POST)) {
	for($x = 0; $x < $rowCount; $x++){
		print($cno);
		$sql = "INSERT INTO cart (cno, pno, qty) VALUES (".$cno.", ?, ?)";
		if($stmt = mysqli_prepare($link, $sql)) {
			if($qty[$x] > 0) {
			    mysqli_stmt_bind_param($stmt, "ss", $pno[$x], $qty[$x]);
			    mysqli_stmt_execute($stmt);
			}
		}
	}
}
header("location: cart.php");

?>