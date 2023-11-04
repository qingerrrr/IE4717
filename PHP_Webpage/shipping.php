<?php
session_start();

if (!isset($_SESSION["name"])) {
  echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
  die();
}

if (isset($_SESSION['name'])) {
  $userName = $_SESSION['name'];
  // print_r("The name from the session is: " . $userName);
} else {
  print("The 'name' key is not set in the session.");
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
  <link rel="stylesheet" href="../CSS/catalogue.css">
</head>


<body>
  <div class="shipping">
    <div class="navigationBarContainer">
      <nav class="navBarContent">
        <span></span>
        <h1><a href="../PHP_Webpage/home.php">DUNOT</a></h1>
        <span class="icons">
          <a href="../PHP_Webpage/catalogue.php"><i class="fa fa-book fa-2x" aria-hidden="true"></i></a>
          <?php
          if ($cartNum > 0) {
            echo "<div class='shoppingBag' data-count='" . $cartNum . "'>";
          } else {
            echo "<div class='shoppingBag'>";
          }
          ?>
          <a href="../PHP_Webpage/basket.php"><i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i></a>
    </div>
    <a href="../PHP_Webpage/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
    </span>
    </nav>
  </div>

  <div class="container">
    <div class="custom_row">
      <div class="column_6">
        <form class="shipping_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="shippingForm">
          <h5>Contact Information</h5>
          <p class="errormsg" id="errorOverall">Invalid inputs, please check again.</p>
          <div class="email_group">
            <input type="email" id="email" class="input_box" placeholder="Email" , name="email" required />
          </div>
          <p class="errormsg" id="errorUser">Only letters (a-z, A-Z), numbers, underscores
                        and full stops are allowed</p>
          <h5>Ship To</h5>
          <div>
            <input type="text" id="country" class="input_box" placeholder="Country/Region" name="country" required/>
          </div>
          <div>
            <input type="text" id="Name" class="input_box" placeholder="Name" name="recipientName" required/>
          </div>
          <div>
            <input type="text" id="Phone" class="input_box" placeholder="Phone" name="Phone" required/>
          </div>
          <div>
            <input type="text" id="Address" class="input_box" placeholder="Address" name="recipient_address" required/>
          </div>
          <div>
            <input type="text" id="postalcode" class="input_box" placeholder="Postal Code" name="postalCode" required/>
          </div>
          <button type="submit" class="btn_submit" id = "submitButton" disabled>Ready to Ship</button>
          <!-- <a href="./shipping.php" class="btn_submit" form="shippingForm">Ready Ship</a> -->
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
            $sumBooks = 0;
            foreach ($bookArray as $book) {
              echo '<tr>';
              echo '<td>' . $book['bookName'] . '</td>';
              echo '<td>' . $book['qty'] . '</td>';
              echo '<td>' . '$' . $book['price'] * $book['qty'] . '</td>';
              echo '</tr>';
              $sumBooks = $sumBooks + $book['price'] * $book['qty'];
            }
            ?>
            <tr class="border-top">
              <td colspan="3" class="text-last text_total" , name='totalCost'>
                <?php
                echo 'Total Cost $' . $sumBooks . '<span id="basketTotal"></span>'
                  ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

  <script>
        //Define variables
        var emailNode = document.getElementById('email');
        //nameNode.addEventListener("change", checkName);
        emailNode.addEventListener("keyup", validateForm);

        var countryNode = document.getElementById('country');
        //pwNode.addEventListener("change", validateForm);
        countryNode.addEventListener("keyup", validateForm);

        var nameNode = document.getElementById('Name');
        //pwNode.addEventListener("change", validateForm);
        nameNode.addEventListener("keyup", validateForm);

        var phoneNode = document.getElementById('Phone');
        //pwNode.addEventListener("change", validateForm);
        phoneNode.addEventListener("keyup", validateForm);

        var addressNode = document.getElementById('Address');
        //pwNode.addEventListener("change", validateForm);
        addressNode.addEventListener("keyup", validateForm);

        var postalcodeNode = document.getElementById('postalcode');
        //pwNode.addEventListener("change", validateForm);
        postalcodeNode.addEventListener("keyup", validateForm);
        //name phone address postalcode

        var submitButton = document.getElementById("submitButton");
        var errorOverall = document.getElementById('errorOverall');
        var errorUser = document.getElementById("errorUser");
        //Functions
        function validateForm() {
            errorOverall.style.visibility = 'hidden';

            if (checkEmail()) {
                submitButton.removeAttribute("disabled");
                alert("correct");
                return true;

            } else {
                submitButton.setAttribute("disabled", "true");
                alert("wrong");
                return false;
            }
        }

        function checkEmail(event) {
            errorOverall.style.visibility = 'hidden';

            var input = emailNode.value;

            var regexp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            var pos = regexp.test(input);
            alert(pos);

            if (input == "") {
                return false;

            } else if (!pos) {
                errorUser.style.visibility = "visible";
                emailNode.classList.add("error-border");
                return false;

            } else {
                errorUser.style.visibility = "hidden";
                emailNode.classList.remove("error-border");
                return true;
            }
        }


    <?php
    include '../PHP_Function/db_connection.php';

    // // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['email'];
      $country = $_POST['country'];
      $Name = $_POST['recipientName'];
      $Address = $_POST['recipient_address'];
      $postalcode = $_POST['postalCode'];
      // $totalCost = $_POST['totalCost'];
      $totalCost = $sumBooks;

      $sql = "";

      //Perform checking with SQL Db
      $sql = $conn->prepare("SELECT * FROM orders WHERE userName=?;");
      $sql->bind_param("s", $userName);
      $sql->execute(); // Execute the prepared statement      
    
      $result = $sql->get_result(); // Get the result set from the executed statement                                 
      // print_r($userName, $email,$country,$Name, $Address, $postalcode, $totalCost);
    
      //Insert to Orders
      $sql = $conn->prepare("INSERT INTO orders (userName, email, country, recipientName, recipient_address, postalCode, totalCost) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $sql->bind_param("sssssss", $userName, $email, $country, $Name, $Address, $postalcode, $totalCost);
      $sql->execute();

      // Stock update
      foreach ($bookArray as $book) {
        $tempString = $book['bookName'];
        $bookName = $tempString;
        $qty = $book['qty'];
        $sql = $conn->prepare("UPDATE books SET stock = stock - ? WHERE bookName = ?");
        $sql->bind_param('is', $qty, $bookName);
        if ($sql->execute()) {
          //echo "Stock updated successfully;";
        } else {
          //echo "Error updating stock: " . $sql->errorInfo()[2] . ";";
        }
      }

      //Insert to order items
    
      $query = "SELECT MAX(orderId) AS latestOrderId FROM orders";
      $result = $conn->query($query);
      if ($result) {
        $row = $result->fetch_assoc();
        $latestOrderId = $row['latestOrderId'];
        if ($latestOrderId !== null) {
          //echo "The latest orderId is: " . $latestOrderId . ";";
        } else {
          //echo "No orders found.;";
        }

        $result->free();
      } else {
        //echo "Error executing the query: " . $conn->error . ";";
      }

      foreach ($bookArray as $book) {
        $bookId = $book['bookId'];
        $bookName = $book['bookName'];
        $subtotal = $book['price'] * $book['qty'];
        $sql = $conn->prepare("INSERT INTO orders_items (orderId, bookId, bookName, qty, subtotal) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('iisid', $latestOrderId, $bookId, $bookName, $book['qty'], $subtotal);
        $sql->execute();
      }
      //Create Session                
      $_SESSION['name'] = $userName;

      //Unset Cookie
      if (isset($_COOKIE['cart'])) {
        // unset cookies 
        foreach ($_COOKIE['cart'] as $bookId => $value) {
          unset($_COOKIE['cart'][$bookId]);
          setcookie("cart[$bookId]", "", time() - 3600, "/");
        }
      }

      echo "window.location.href = 'thankyou.php';";



      $sql->close();
      $conn->close();
    } else {
      echo "Form submission error.";
    }
    ?>


</body>


</html>