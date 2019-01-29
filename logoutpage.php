<html>
<head>
<style>
<?php
	session_start();
	// Include config file
	require_once "config.php";

  $sql = "SELECT * FROM cart WHERE qty != 0 LIMIT 1";
  $result = "";
  $result = mysqli_query($link, $sql);
  $row = mysqli_num_rows($result);
  if($row == 0) {
    $_SESSION['logoutType'] = "emptycart";
    $_SESSION = array();
    // Destroy the session.
    session_destroy();
    // Redirect to login page
    header("location: login.php");
    exit;
  }

?>
<?php include 'css/bootstrap.css'; ?>
<?php include 'css/bootstrap.min.css'; ?>
</style>
<title>The Shop</title>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/shop/welcome.php">The Shop</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="checkout.php">Checkout</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orderstatus.php">Check Order Status</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Update Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php">View/Edit Cart</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logoutpage.php">Logout</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="searchResults.php" method="post">
      <input class="form-control mr-sm-2" type="text" name="searchKeyword" placeholder="Search Keyword">
      <button class="btn btn-info type="submit">Search</button>
    </form>
</nav>
</head>
<body>
	<div style="padding:50px; margin:auto;"><h1>Logout Page</h1></div>
	  <div style="width: 80%; margin: auto;">
	<form action="logout.php" method="post">
		<fieldset class="form-group">
		<legend>Please select on option before logging out.</legend>
      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="logoutType" id="optionsRadios1" value="checkout" checked="">
          Checkout
        </label>
      </div>
      <div class="form-check">
      <label class="form-check-label">
          <input type="radio" class="form-check-input" name="logoutType" id="optionsRadios2" value="savecart">
          Save cart and log out
        </label>
      </div>
      <div class="form-check disabled">
      <label class="form-check-label">
          <input type="radio" class="form-check-input" name="logoutType" id="optionsRadios3" value="emptycart">
          Empty cart and log out
        </label>
      </div><br>
  	<input class="btn btn-info" type="submit" name="submit" value="Submit">
	</fieldset>
</form>
</div>
</body>
</html>
