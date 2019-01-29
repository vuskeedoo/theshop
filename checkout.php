<html>
<head>
<style>
/* https://bootswatch.com/lux/ */
<?php
session_start();
// Include config file
require_once "config.php";

// Check if cart is empty
$sql = "SELECT * FROM cart WHERE qty != 0 LIMIT 1";
$result = "";
$result = mysqli_query($link, $sql);
$row = mysqli_num_rows($result);

// If GET request to page, assign order #
if(isset($_GET['orderid'])) {
  $_SESSION['ono'] = $_GET['orderid'];
  $_SESSION['cartEmpty'] = "checkout";
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
        <a class="nav-link active" href="checkout.php">Checkout<span class="sr-only">(current)</span></a>
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
  <div style="padding:50px; margin:auto;"><h1>Checkout</h1></div>
  <div style="width: 80%; margin: auto;">
    <?php
    // If not empty, query for customer information.
    $sql = "SELECT name, street, city, state, zip FROM customers WHERE cno = ?";
    if($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $_SESSION['cno']);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      mysqli_stmt_bind_result($stmt, $name, $street, $city, $state, $zip);

      if(mysqli_stmt_num_rows($stmt) == 1) {
        while(mysqli_stmt_fetch($stmt)) {
        }
      }
      mysqli_stmt_close($stmt);
      }
      // print_r($_GET);
      // print_r($_SESSION);
      echo "<div><h4>Invoice for: <p class=\"text-primary\">".$name."</p></h4></div>";
      echo "<div><h5>Shipping Address: <p class=\"text-primary\">".$street." ".$city." ".$state." ".$zip."</p></h5><div>";
      echo "<div><h5>Order Number:</h5> <h5 class=\"text-primary\">".$_SESSION['ono']."</h5></div>";
    ?>
    <table class="table table-hover">
      <thead>
        <tr class="table-info">
          <th scope="col">PNO</th>
          <th scope="col">PRODUCT NAME</th>
          <th scope="col">PRICE</th>
          <th scope="col">QUANTITY</th>
          <th scope="col">COST</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(($_SESSION['cartEmpty'] == "checkout") || ($_SESSION['cartEmpty'] == "neworder")) {
          $sql = "SELECT DISTINCT parts.pno, parts.pname, parts.price, odetails.qty FROM parts, odetails, orders WHERE parts.pno = odetails.pno AND odetails.ono = ".$_SESSION['ono']." AND orders.cno = \"".$_SESSION["cno"]."\"";
          $result = mysqli_query($link, $sql);
          if(isset($result)){
              while($row = mysqli_fetch_assoc($result)) {  
                echo "<tr>";
                echo "<td>".$row['pno']."</td>";
                echo "<td>".$row['pname']."</td>";
                echo "<td>$".$row['price']."</td>";
                echo "<td>".$row['qty']."</td>";
                $total = $row['qty']*$row['price'];
                echo "<td>$".$total."</td>";
                echo "</tr>";
              }
            }
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>