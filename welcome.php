<html>
<head>
<style>
/* https://bootswatch.com/lux/ */
<?php
// Initialize the session
session_start();

require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit; 
}

// Grab customer information
$sql = "SELECT cno, name, street, city, state, zip, phone, email FROM customers WHERE email = ?";
if($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $cno, $name, $street, $city, $state, $zip, $phone, $email);

    if(mysqli_stmt_num_rows($stmt) == 1) {
        while(mysqli_stmt_fetch($stmt)) {
            $_SESSION["cno"] = $cno;
        }
    }
}
mysqli_stmt_close($stmt);
mysqli_close($link);

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
      <button class="btn btn-info btn-sm" type="submit">Search</button>
    </form>
</nav>
</head>
<body>
  <div class="jumbotron">
  <h1 class="display-10">Welcome to The Shop!</h1>
  <p class="lead">Customer Email: <b><?php echo htmlspecialchars($_SESSION["email"]); ?><br>Customer ID: <?php echo htmlspecialchars($_SESSION["cno"]); ?></b></p>
  <hr class="my-4">
  <p>Your one stop shop for all your meow-vie needs! Use the search box above to begin shopping!</p>
</div>
</body>
</html>