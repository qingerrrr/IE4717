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
  </head>


  <body>
    <div class="shipping">
      <div class="container">
        <div class="custom_row">
          <div class="column_6">
            <form class="shipping_form">
              <h5>Contact Information</h5>
              <div class="email_group">
                <input type="email" class="input_box" placeholder="Email" />
              </div>
              <h5>Shipping To</h5>
              <div>
                <input
                  type="text"
                  class="input_box"
                  placeholder="Country/Region"
                />
              </div>
              <div>
                <input type="text" class="input_box" placeholder="Name" />
              </div>
              <div>
                <input type="text" class="input_box" placeholder="Phone" />
              </div>
              <div>
                <input type="text" class="input_box" placeholder="Address" />
              </div>
              <div>
                <input
                  type="text"
                  class="input_box"
                  placeholder="Postal Code"
                />
              </div>
              <button type="submit" class="btn_submit">Ready to Ship</button>
            </form>
          </div>
          <div class="column_6">
            <table class="table tbale_shipping">
              <h5 class="ms-2">Your Basket</h5>
              <tbody>
              <th scope="col">Title</th>
              <th scope="col">Quantity</th>
              <th class="text-last" scope="col">Cost</th>
              <?php
              $sumBooks= 0;
              foreach ($bookArray as $book) {
                  echo '<tr>';
                  echo '<td>' . $book['bookName'] . '</td>';
                  echo '<td>' . $book['qty'] . '</td>';
                  echo '<td>' .'$'. $book['price'] * $book['qty'] . '</td>';
                  echo '</tr>';
                  $sumBooks = $sumBooks + $book['price'] * $book['qty'];
              }
              ?>
                <tr class="border-top">
                  <td colspan="3" class="text-last text_total">
                    <?php
                      echo 'Total Cost $'. $sumBooks.'<span id="basketTotal"></span>'
                    ?>
                  
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </body>


</html>
