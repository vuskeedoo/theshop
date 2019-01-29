<html>
<head>
<?php
session_start();
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $street = $city = $state = $zip = $phone = $email = $password = $confirm_password = "";
$name_err = $street_err = $city_err = $state_err = $zip_err = $phone_err = $email_err = $password_err = $confirm_password_err = "";

$email = $_SESSION["email"];

// Get values
$sql = "SELECT cno, name, street, city, state, zip, phone, email FROM customers WHERE email = ?";

if($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $cno, $name, $street, $city, $state, $zip, $phone, $email);

    if(mysqli_stmt_num_rows($stmt) == 1) {
        while(mysqli_stmt_fetch($stmt)) {
            $_SESSION["cno"] = $cno;
            $_SESSION["name"] = $name;
            $_SESSION["street"] = $street;
            $_SESSION["city"] = $city;
            $_SESSION["state"] = $state;
            $_SESSION["zip"] = $zip;
            $_SESSION["phone"] = $phone;
            $_SESSION["email"] = $email;
        }
    }
}

mysqli_stmt_close($stmt);
mysqli_close($link);

?>
<style>
/* https://bootswatch.com/lux/ */
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
        <a class="nav-link active" href="profile.php">Update Profile<span class="sr-only">(current)</span></a>
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
  <div style="padding:50px; margin:auto;"><h1>Edit Profile</h1></div>
  <div style="width: 50%; margin: auto;">
        <p></p>
        <form action="updateprofile.php" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($street_err)) ? 'has-error' : ''; ?>">
                <label>Street</label>
                <input type="text" name="street" class="form-control" placeholder="<?php echo $street; ?>">
                <span class="help-block"><?php echo $street_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="city" class="form-control" placeholder="<?php echo $city; ?>">
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                <label>State</label>
                <input type="text" name="state" class="form-control" placeholder="<?php echo $state; ?>">
                <span class="help-block"><?php echo $state_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($zip_err)) ? 'has-error' : ''; ?>">
                <label>Zip</label>
                <input type="text" name="zip" class="form-control" placeholder="<?php echo $zip; ?>">
                <span class="help-block"><?php echo $zip_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email Address</label>
                <input type="text" name="email" class="form-control" placeholder="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit">
            </div>
        </form>
    </div>
</body>
</html>