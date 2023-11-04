<?php
//Ensure user is logged in
session_start();

if (!isset($_SESSION["adminName"])) {
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

include '../PHP_Function/db_connection.php';
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
                    <form class="deletebook" action="<?php echo $_SERVER['PHP_SELF']."?bookId=".$currentbookId; ?>" method="POST" id="deletebook">
                    <h2 id="bookName" class="mb-4"></h2>

                    <div class="add_btn_last">
                        <button type = 'submit' class = 'btn_submit' onclick="showPopup()">Delete</button>
                    <br />
                    <a href="admin_addbook.php"
                    class="btn_submit"
                    id="dont_delete"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    >
                      Back
                    </a>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>


  <script>
    <?php
      include '../PHP_Function/db_connection.php';

      // // Check if the form is submitted
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $sql = "";
                               

          //Delete
          $sql = $conn->prepare("DELETE FROM books WHERE bookId = ?");
          $sql->bind_param("i", $currentbookId);
          $sql->execute();
          if ($sql->execute()) {
              //echo "Record updated successfully.";
              echo 'window.location.href = "admin_addbook.php";';
          } else {
              //echo "Error updating record: " . $sql->error;
          }

          //echo "Form submission successful.";
          // sleep(5);
      }else{
       // echo "Form submission error.";
      }
      // sleep(1);
   
      ?>

      
  </script>
</body>
</html>