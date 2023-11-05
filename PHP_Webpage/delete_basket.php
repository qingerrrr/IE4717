<?php
session_start();
include '../PHP_Function/db_connection.php';
if (!isset($_SESSION["name"])) {
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
if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
    $sql = $conn->prepare("SELECT * FROM books WHERE bookId = ?");
    $sql->bind_param("i", $bookId);
    $currentbookId = $bookId;
}

include '../PHP_Function/db_connection.php';
    $sql = $conn->prepare("SELECT * FROM books where bookId = ?;");
    $sql->bind_param("i", $currentbookId);
    $sql->execute(); // Execute the prepared statement      
    $result = $sql->get_result();
    $result = $result->fetch_assoc();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unoguerta</title>
    
    <link rel="stylesheet" href="../CSS/styleModal.css" />
    <link rel="stylesheet" href="../CSS/responsiveModal.css" />
</head>

<body>
    <div class="data_main">
        <div class="container">
            <div class="delete_overlay"></div>
            <!-- delete modal -->
            <div
              class="modal fade"
              id="deleteModal"
              tabindex="-1"
              aria-labelledby="deleteModalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-body">
                    <h5>Confimation to Delete</h5>
                    <h2 id="bookName" class="mb-4"></h2>


                    <div class="add_btn_last">
                        <button type = 'submit' class = 'btn_submit' id = 'btn_submit'>Delete</button>
                        <script type="text/javascript">
                            document.getElementById('btn_submit').addEventListener('click', function() {
                            // Specify the name of the cookie to    
                            <?php
                                if (isset($_COOKIE['cart'])) {
                                    $cookieArray = $_COOKIE['cart'];
                                    
                                    // Specify the specific entry you want to delete
                                    $entryToDelete = $currentbookId;
                                    
                                    // Check if the entry exists in the array and delete it
                                    if (array_key_exists($entryToDelete, $cookieArray)) {
                                        unset($cookieArray[$entryToDelete]);
                                        print_r('delete successful');
                                        // Set the modified array back as a cookie
                                        setcookie("cart[$currentbookId]", serialize($cookieArray), time() - 3600, "/");
                                        // setcookie('cart', serialize($cookieArray), time() + 3600, '/');
                                    }else{
                                        print_r('delete unsuccessful');
                                    }
                                }
                            ?>
                        });
                        window.location.href = 'basket.php';
                    </script>
                    <br />
                    <a href="basket.php"
                    class="btn_submit"
                    id="dont_delete"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    >
                      Back
                    </a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>



</body>
</html>