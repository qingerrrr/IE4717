<!-- get all books from DB -->
<?php
//Ensure user is logged in
session_start();

if (!isset($_SESSION["adminName"])) {
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

include '../PHP_Function/db_connection.php';
$sql = $conn->prepare("SELECT * FROM books;");
$sql->execute(); // Execute the prepared statement      
$result = $sql->get_result();
$book_count = $result->num_rows;
// echo "Number of rows in the result set: " . $book_count . "<br>";
// if ($result){
//     // Fetch and display the data
//     while ($row = $result->fetch_assoc()) {
//         echo "Book Title: " . $row["bookName"] . "<br>";
//         echo "Stock: " . $row["stock"] . "<br>";
//         echo "<br>";
//     }
//     $result->close();
// } else {
//     echo "Error: " . $conn->error;
// }
// $result = $sql->get_result();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Unoguerta</title>
    <!-- styles -->  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="../CSS/responsive.css" />
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
  </head>
  <body>
  <div class="navigationBarContainer">
      <nav class="navBarContent">
        <span></span>
        <h1><a href="../PHP_Webpage/home.php">DUNOT</a></h1>
        <span class="icons">
          <a href="../PHP_Webpage/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
        </span>
      </nav>
  </div>
    <!-- booking list start -->
    <div class="booking-list my-5">
      <div class="container"style="position:relative; top:80px;">
        <div class="row">
          <div id="tableToggle" class="tableToggle">
            <table class="table tableAdd">
              <thead class="table-dark">
                <tr>
                  <th scope="col" class="orth">Books</th>
                  <th scope="col" class="orth">Stocks Left</th>
                  <th scope="col" class="orth">Price</th> 
                  <th scope="col"></th> 
                  <th scope="col"></th> 
                  <?php
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['bookName'] . '</td>';
                        echo '<td>' . $row['stock'] . '</td>';
                        echo '<td>' .'$'. $row['price'] . '</td>';
                        echo "<td><a href='edit_modal.php?bookId={$row['bookId']}'><i class='fa-solid fa-pen'></td>";
                        echo "<td><a href='delete.php?bookId={$row['bookId']}'><i class='fa-solid fa-trash'></td>";
                        echo '</tr>';
                    }
                    ?>
                </tr>
              </thead>
              <tbody id="tableBody">
              </tbody>
            </table>  

          </div>

        </div>
        <div class="text_button">
              <!-- Button trigger add book modal -->
              <a href="add_modal.php"
                type="button"
                class="btn_submit"
                id="addBookBtn"
                data-bs-toggle="modal"
                data-bs-target="#addBookModal">
                Add Book
              </a>
            </div>
    </div>
  </div>
  <!-- booking list end -->
</body>

</html>