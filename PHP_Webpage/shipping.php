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
          <!-- <div class="shoppingBag"> -->
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
          <!-- <p class="errormsg" id="errorOverall">Invalid inputs, please check again.</p>
         -->
          <div class="email_group">
            <input type="text" id="email" class="input_box" placeholder="Email" , name="email" required />
            <span id="emailError" class="error" style="color: red;"></span>
          </div>
          <!-- <p class="errormsg" id="errorUser">Only letters (a-z, A-Z), numbers, underscores
                        and full stops are allowed</p> -->
          <h5>Ship To</h5>
          <div>
            <input type="text" id="country" class="input_box" placeholder="Country/Region" name="country" required />
            <span id="countryError" class="error" style="color: red;"></span>
          </div>
          <div>
            <input type="text" id="Name" class="input_box" placeholder="Name" name="recipientName" required />
            <span id="nameError" class="error" style="color: red;"></span>
          </div>
          <div>
            <input type="text" id="Phone" class="input_box" placeholder="Phone" name="Phone" required />
            <span id="phoneError" class="error" style="color: red;"></span>
          </div>
          <div>
            <input type="text" id="Address" class="input_box" placeholder="Address" name="recipient_address" required />
          </div>
          <div>
            <input type="text" id="postalcode" class="input_box" placeholder="Postal Code" name="postalCode" required />
            <span id="pcError" class="error" style="color: red;"></span>
          </div>
          <button type="submit" class="btn_submit_2" id="submitButton" disabled>Ready to Ship</button>
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
                <?php echo 'Total Cost $' . $sumBooks ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

  <script>
    var checkEmail = false;
    var checkCountry = false;
    var checkName = false;
    var checkPhone = false;
    var checkPC = false;

    document.getElementById('email').addEventListener('input', function () {
      const emailInput = this.value;
      const emailRegex = /^(?:[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}|[a-zA-Z0-9._-]+@localhost)$/;

      const emailError = document.getElementById('emailError');
      const submitBtn = document.getElementById('submitButton');


      if (emailRegex.test(emailInput)) {
        emailError.textContent = '';
        submitBtn.removeAttribute('disabled');
        checkEmail = true;
      } else {
        emailError.textContent = 'Invalid email format, please follow the format : youremail@mailcompany.com, yourname@mail.co';
        submitBtn.setAttribute('disabled', true);
        checkEmail = false;
      }
    });

    document.getElementById('country').addEventListener('input', function () {
      const countryInput = this.value;
      const countryRegex = /^[A-Za-z ]+$/;

      const countryError = document.getElementById('countryError');
      const submitBtn = document.getElementById('submitButton');

      if (countryRegex.test(countryInput)) {
        countryError.textContent = '';
        submitBtn.removeAttribute('disabled');
        checkCountry = true;
      } else {
        countryError.textContent = 'Invalid country, can only contain letters and spaces';
        submitBtn.setAttribute('disabled', true);
        checkCountry = false;
      }
    });

    document.getElementById('Name').addEventListener('input', function () {
      const nameInput = this.value;
      const nameRegex = /^[A-Za-z ]+$/;

      const nameError = document.getElementById('nameError');
      const submitBtn = document.getElementById('submitButton');


      if (nameRegex.test(nameInput)) {
        nameError.textContent = '';
        submitBtn.removeAttribute('disabled');
        checkName = true;
      } else {
        nameError.textContent = 'Invalid name, can only contain letters and spaces';
        submitBtn.setAttribute('disabled', true);
        checkName = false;
      }
    });

    document.getElementById('Phone').addEventListener('input', function () {
      const phoneInput = this.value;
      const phoneRegex = /^\d{8}$/;

      const phoneError = document.getElementById('phoneError');
      const submitBtn = document.getElementById('submitButton');

      if (phoneRegex.test(phoneInput)) {
        phoneError.textContent = '';
        submitBtn.removeAttribute('disabled');
        checkPhone = true;
      } else {
        phoneError.textContent = 'Invalid phone number, only allow 8 digits and numbers only';
        submitBtn.setAttribute('disabled', true);
        checkPhone = false;
      }
    });

    document.getElementById('postalcode').addEventListener('input', function () {
      const pcInput = this.value;
      const pcRegex = /^\d{6}$/;

      const pcError = document.getElementById('pcError');
      const submitBtn = document.getElementById('submitButton');

      if (pcRegex.test(pcInput)) {
        pcError.textContent = '';
        submitBtn.removeAttribute('disabled');
        checkPC = true;
      } else {
        pcError.textContent = 'Invalid postal code, only allow 6 digits and numbers only';
        submitBtn.setAttribute('disabled', true);
        checkPC = false;
      }
    });
    document.addEventListener('keyup', function (event) {
      const submitBtn = document.getElementById('submitButton');

      if (checkEmail && checkCountry && checkName && checkPhone && checkPC) {
        submitBtn.removeAttribute('disabled');
        console.log('Button enabled');
      } else {
        submitBtn.setAttribute('disabled', true);
        console.log('Button disabled');
      }
    });


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
      //$_SESSION['name'] = $userName;            
    

      // exit;   
      $sql->close();
      $conn->close();
      echo "window.location.href = 'unset_cookie.php';";

    } else {
      // echo "Form submission error.";
    }
    ?>
  </script>

</body>


</html>