<?php
session_start();

// if (!isset($_SESSION["name"])){
//     echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
//     die();
// }

// if (isset($_SESSION['name'])) {
//   $userName = $_SESSION['name'];
//   // print_r("The name from the session is: " . $userName);
// } else {
//     print("The 'name' key is not set in the session.");
// }
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
  <div
  class="modal fade"
  id="addBookModal"
  tabindex="-1"
  aria-labelledby="addBookModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-body text-start">
        <div class="container">
            <form class="addbook_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="addbook_form">
                <div class="custom_row">
                    <div class="column_6">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                        <input
                            type="file"
                            id="imageUpload"
                            accept=".png, .jpg, .jpeg"
                            name = "img"
                        />
                        <label for="imageUpload">Change Image</label>
                        </div>
                        <div class="avatar-preview">
                        <div
                            id="img"
                            style="
                            background-image: url(https://placehold.co/500x500);
                            "
                        ></div>
                        </div>
                    </div>
                    </div>

                    <div class="column_6">
                        <div class="form_group"> 
                            <label for="productsName" class="form-label">Book Title</label>
                            <input
                                type="text"
                                class="input_box"
                                id="bookName"
                                name = "bookName"
                            /> 
                        </div>
                        <div class="form_group_6">

                            <div class="form_group"> 
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="input_box" id="price" name = "price"placeholder=""style = "width:70px; margin:auto;"> 
                            </div>

                            <div class="form_group"> 
                            <label for="price" class="form-label">Category</label>
                            <!-- <input type="text" class="input_box" id="category" placeholder="">
                            <label for="dog-names">Category</label>  -->
                                <select name="catId" id="catId" style = "width:70px; margin:auto; text-align:center"> 

                                <!-- get categories  -->
                                <?php
                                include '../PHP_Function/db_connection.php';

                                $sql = "SELECT catId FROM categories";
                                
                                // Execute the query
                                $result = $conn->query($sql);
                                $bookCategories = $result;
                                // Check if the query was successful
                                if ($result) {
                                    // Fetch and display the 'bookId' values
                                    while ($row = $result->fetch_assoc()) {
                                        echo "Cat ID: " . $row["catId"] . "<br>";
                                        echo "<option value =1>".$row["catId"]."</option>";
                                    }
                                
                                    // Close the result set
                                    $result->free_result();
                                } else {
                                    echo "Error: " . $conn->error;
                                }
                                ?>
                                </select>
                            </div>

                            <div class="form_group"> 
                                <label for="stocksLeft" class="form-label">Quantity</label>
                                <input
                                type="text"
                                class="input_box"
                                id="stock"
                                name = "stock"
                                placeholder=""
                                style = "width:70px; margin:auto;"
                                /> 
                            </div>
                        </div>

                        <div class="form_group"> 
                            <label for="description" class="form-label">Book Description</label>
                            <textarea
                                class="input_box"
                                id="info"
                                name = "info"
                                rows="15"
                                placeholder=""
                            ></textarea> 
                        </div>
                    </div>


                    <div class="add_btn_last">
                    <button type = "submit" class = "btn_submit">Add New Boo</button>
                    <!-- <a href="admin_addbook.php"
                        id="addBook"
                        class="btn_submit"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        type = "submit"
                        class = "btn_submit"
                    >
                        Add New Book -->
                    </a>
                    <a href="admin_addbook.php"
                    class="btn_submit"
                    id="addBookCencel"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        Cancel
                </a>
                    </div>
                </div>
                </div>
            </form>

      </div>
    </div>
  </div>
</div>


<script>
      <?php
        include '../PHP_Function/db_connection.php';

        // // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $img = $_POST['img'];
            $img = "../IMG/Books/".$img;
            $bookName = $_POST['bookName'];
            $bookInfo = $_POST['info'];
            $price = $_POST['price'];
            $catId = $_POST['catId'];
            $stock = $_POST['stock'];


            $sql = "";
            print_r($img .$bookName. $bookInfo. $price. $catId. $stock);

            //Perform checking with SQL Db
            // $sql = $conn->prepare("SELECT * FROM orders WHERE userName=?;");
            // $sql->bind_param("s", $userName);
            // $sql->execute(); // Execute the prepared statement      
        
            // $result = $sql->get_result(); // Get the result set from the executed statement                                 

            //Insert to Orders
            $sql = $conn->prepare("INSERT INTO books (bookName, info, img, catId, stock, price) VALUES (?, ?, ?, ?, ?, ?)");
            $sql->bind_param("sssiid", $bookName, $bookInfo, $img, $catId, $stock, $price);
            $sql->execute();

            
            //Create Session                
            $_SESSION['name'] = $userName;
            

            echo "window.location.href = 'add_modal.php'";



            $sql->close();
            $conn->close();
            echo "Form submission successful.";
        }else{
          echo "Form submission error.";
        }
        ?>
    </script>
</body>
</html>