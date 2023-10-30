<?php
session_start();

if (!isset($_SESSION["name"])){
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

//Cookie
if (isset($_COOKIE['cart'])) {
    // Calculate the number of items in the cart
    $cartNum = count($_COOKIE['cart']);
    $BookData = $_COOKIE['cart'];
} else {
    $cartNum = 0;
}
$bookArray = [];
foreach ($BookData as $value => $serialized) {
    $bookArray[$value] = unserialize($serialized);
}
// print_r($bookArray);
if (isset($bookArray['bookName'])) {
    $bookNames[] = $bookArray['bookName'];
}
// print_r($bookArray);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Unoguerta</title>
    <!-- styles -->
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="../CSS/responsive.css" />
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="../CSS/global.css"> -->
    <!-- <link rel="stylesheet" href="../CSS/catalogue.css"> -->
  </head>


  <body>
    <div class="basket">
    <div class="navigationBarContainer">
                <nav class="navBarContent">
                    <span></span>
                    <h1><a href="../PHP_Webpage/home.php">DUNOT</a></h1>
                    <span class="icons">
                        <a href="../PHP_Webpage/catalogue.php"><i class="fa fa-book fa-2x" aria-hidden="true"></i></a>
                    <?php
                    if ($cartNum > 0) {
                        echo "<div class='shoppingBag' data-count='" . $cartNum . "'>";                        
                    }else{
                        echo "<div class='shoppingBag'>";
                    }
                    ?>

                        <div class="shoppingBag">
                            <a href="../PHP_Webpage/basket.php"><i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i></a>
                        </div>
                        <a href="../PHP_Webpage/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
                    </span>
                </nav>
            </div>
      <div class="container">


        <h1>Book Ship</h1>
        <table class="table tableAdd", style = "margin-top: 50px;">
          <thead class="table-dark">
            <tr>
              <th scope="col">Title</th>
              <th scope="col">Quantity</th>
              <th scope="col">Cost</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach ($bookArray as $book) {
                echo '<tr>';
                echo '<td>' . $book['bookName'] . '</td>';
                echo '<td>' . $book['qty'] . '</td>';
                echo '<td>' .'$'. $book['price'] * $book['qty'] . '</td>';
                echo '</tr>';
            }
            ?>
          </tbody>
        </table>
        <div class="basket_btn">
          <a href="./shipping.php" class="btn_submit">Check Out</a>
        </div>
      </div>
    </div>

  </body>
</html>
