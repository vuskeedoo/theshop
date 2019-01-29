<?php
session_start();
// Include config file
require_once "config.php";

$sql = "SELECT * FROM cart LIMIT 1";
$result = "";
$result = mysqli_query($link, $sql);
$row = mysqli_num_rows($result);
$sql = "SELECT cart.cartno, parts.pno, cart.qty FROM parts, cart WHERE cart.qty != 0 AND parts.pno = cart.pno AND cart.cno = \"".$_SESSION["cno"]."\"";
$result = mysqli_query($link, $sql);

$cartno = array();
$pno = array();
$qty = array();
$rowCount = 0;

if(isset($result)){
	while($row = mysqli_fetch_assoc($result)) {
		$cartno[$rowCount] = $row['cartno'];
		$pno[$rowCount] = $row['pno'];
		$qty[$rowCount] = $row['qty'];
		$rowCount++;
	}

	$sql = "INSERT INTO orders (cno, received, shipped) VALUES (?, CURDATE(), \"Not Shipped\")";
	if($stmt = mysqli_prepare($link, $sql)) {
	    mysqli_stmt_bind_param($stmt, "s", $_SESSION['cno']);
	    mysqli_stmt_execute($stmt);
	    mysqli_stmt_close($stmt);
	}

	$sql = "SELECT ono FROM orders WHERE cno =".$_SESSION['cno']." ORDER BY ono DESC LIMIT 1";
	$result = mysqli_query($link, $sql);
	if(isset($result)){
		while($row = mysqli_fetch_assoc($result)) {
			$ono = $row['ono'];
			$_SESSION['ono'] = $ono;
		}
	}

	for($x = 0; $x < $rowCount; $x++){
		$sql = "INSERT INTO odetails (ono, pno, qty) VALUES (".$ono.", ?, ?)";
		if($stmt = mysqli_prepare($link, $sql)) {
		    mysqli_stmt_bind_param($stmt, "ss", $pno[$x], $qty[$x]);
		    mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
	}

	$sql = "DELETE FROM cart WHERE cartno = ?";
	if($stmt = mysqli_prepare($link, $sql)) {
		$count = 0;
		do {
			mysqli_stmt_bind_param($stmt, "s", $cartno[$count]);
			mysqli_stmt_execute($stmt);
			$count++;
		} while ($count < $rowCount);
		mysqli_stmt_close($stmt);
	}
	$_SESSION['cartEmpty'] = "neworder";
	$_SESSION['logoutType'] = "checkout";
}

if(isset($_SESSION['logoutType'])) {
	if($_SESSION['logoutType'] == "checkout") {
		header("location: checkout.php");
	} else {
		// Redirect to login page
		header("location: login.php");
		exit;
	}
}

?>