<?php
// Initialize the session
session_start();

require_once ("config.php");

if(isset($_POST['logoutType'])) {
	$_SESSION['logoutType'] = $_POST['logoutType'];
	print_r($_SESSION);

	if($_SESSION['logoutType'] == "checkout") {
		header("location: updatecheckout.php");
	} else if ($_SESSION['logoutType'] == "savecart") {
		$_SESSION = array();
		// Destroy the session.
		session_destroy();
		// Redirect to login page
		header("location: login.php");
		exit;
	} else if ($_SESSION['logoutType'] == "emptycart") { // empty cart & logout
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
		$_SESSION = array();
		// Destroy the session.
		session_destroy();
		// Redirect to login page
		header("location: login.php");
		exit;
	}
}
?>