<html>
<head>
<style>
/* https://bootswatch.com/lux/ */
<?php
session_start();
// Include config file
require_once "config.php";
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

$sql = "SELECT cart.cartno, parts.pno, parts.pname, parts.price, cart.qty FROM parts, cart WHERE cart.qty != 0 AND parts.pno = cart.pno AND cart.cno = \"".$_SESSION["cno"]."\"";

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
        <a class="nav-link" href="orderstatus.php">Check Order Status</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Update Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="cart.php">View/Edit Cart<span class="sr-only">(current)</span></a>
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
  <div style="padding:50px; margin:auto;"><h1>Shopping Cart</h1></div>
  <div style="width: 80%; margin: auto;">
  <form style="padding-top: 20px;" class="form-inline my-2 my-lg-0">
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
        //print_r($_SESSION);
        $rowCount = 0;
        $maxTotal = 0;
        $subTotal = 0;
          if(isset($result)){
              while($row = mysqli_fetch_assoc($result)) {  
                $rowCount++;
                echo "<tr>";
                echo "<input type=\"hidden\" name=\"cartno[]\" value=".$row['cartno'].">";
                echo "<td><input type=\"hidden\" name=\"pno[]\" value=".$row['pno'].">".$row['pno']."</td>";
                echo "<td><input type=\"hidden\" name=\"pname[]\" value=".$row['pname'].">".$row['pname']."</td>";
                echo "<td><input type=\"hidden\" name=\"price[]\" value=".$row['price'].">$".$row['price']."</td>";
                echo "<td><input class=\"form-control mr-sm-2\" type=\"number\" name=\"quantity[]\" value=\"".number_format($row['qty'], 2)."\"</td>";
                $total = $row['qty']*$row['price'];
                echo "<td>$".number_format($total, 2)."</td>";
                echo "</tr>";
                $subTotal = $total + $subTotal;
              }
            }
          $_SESSION['rowCount'] = $rowCount;
        ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td>Subtotal:</td>
          <?php echo "<td>$".number_format($subTotal, 2)."</td>";?>
        </tr>
          <td></td>
          <td></td>
          <td></td>
          <td>Tax (9.75%):</td>
          <?php $taxTotal = 0.00; echo "<td>$".number_format(($subTotal*0.975), 2)."</td>";?>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td>Shipping Cost:</td>
          <?php echo "<td>$4.20</td>";?>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="table-success">Total Cost:</td>
          <?php echo "<td class=\"table-success\">$".number_format((($subTotal*0.975)+4.20), 2)."</td>";?>
        </tr>
      </tbody>
    </table>
    <div class="text-right">
    <button class="btn btn-primary" formaction="updatecart.php" formmethod="post" type="submit">Update Cart</button>
    &nbsp&nbsp&nbsp&nbsp&nbsp
    <button class="btn btn-primary" formaction="updatecheckout.php" type="submit">Checkout</button>
  </div>
    </form>
    </div>
  </div>
</body>
</html>