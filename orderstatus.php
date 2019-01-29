<html>
<head>
<style>
/* https://bootswatch.com/lux/ */
<?php
session_start();
// Include config file
require_once "config.php";

$cno = $_SESSION["cno"];
$sql = "SELECT ono, received, shipped FROM orders WHERE cno = \"".$cno."\"";

$result = mysqli_query($link, $sql);
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
        <a class="nav-link active" href="orderstatus.php">Check Order Status<span class="sr-only">(current)</span></a>
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
  <div style="padding:50px; margin:auto;"><h1>Order Status</h1></div>
  <div style="width: 80%; margin: auto;">
    <table class="table table-hover">
      <thead>
        <tr class="table-info">
          <th scope="col">ORDER NO</th>
          <th scope="col">RECEIVED</th>
          <th scope="col">SHIPPED</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //print_r($_SESSION);
          if(isset($result)){
              while($row = mysqli_fetch_assoc($result)) {  
                echo "<tr>";
                echo "<td><a href=\"checkout.php?orderid=".$row['ono']."\">".$row['ono']."</a></td>";
                echo "<td>".$row['received']."</td>";
                echo "<td>".$row['shipped']."</td>";
                echo "</tr>";
              }
            }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>