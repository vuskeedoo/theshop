<html>
<head>
<style>
<?php
session_start();
// Include config file
require_once "config.php";
print_r($_SESSION);
if($_SERVER["REQUEST_METHOD"] == "POST" && (!empty(trim($_POST["searchKeyword"])))){

  $param_searchKeyword = trim($_POST["searchKeyword"]);
  $sql = "SELECT pno, pname, price, qoh FROM parts WHERE pname LIKE '%".$param_searchKeyword."%'";

  $result = mysqli_query($link, $sql);
}
?>
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
  <div style="padding:50px; margin:auto;"><h1>Search Results</h1></div>
  <div style="width: 70%; margin: auto;">
      <form style="padding-top: 20px; padding-bottom: 100px;" class="form-inline my-2 my-lg-0" action="addcart.php" method="post">
      <table class="table table-hover">
      <thead>
        <tr class="table-info">
          <th scope="col" width="20%">PNO</th>
          <th scope="col" width="50%">PRODUCT NAME</th>
          <th scope="col" width="20%">PRICE</th>
          <th scope="col" width="10%">QUANITY</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $rowCount = 0;
        if(isset($result)){
            while($row = mysqli_fetch_assoc($result)) {
              $rowCount++;
              echo "<tr>";
              echo "<td><input type=\"hidden\" name=\"pno[]\" value=".$row['pno'].">".$row['pno']."</td>";
              echo "<td>".$row['pname']."</td>";
              echo "<td>$".number_format($row['price'],2)."</td>";
              echo "<td><input class=\"form-control mr-sm-2\" type=\"number\" name=\"quantity[]\"></td>";
              echo "</tr>";
            }
          }
          $_SESSION['rowCount'] = $rowCount;
        ?>
      </tbody>
    </table>
      <button class="btn btn-primary" type="submit">Add To Cart</button>
    </form>
  </div>
</body>
</html>