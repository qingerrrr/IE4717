<?php
<<<<<<< Updated upstream
//Ensure user is logged in
session_start();

if (!isset($_SESSION["adminName"])) {
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

=======
session_start();
>>>>>>> Stashed changes
include '../PHP_Function/db_connection.php';
if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
    $sql = $conn->prepare("SELECT * FROM books WHERE bookId = ?");
    $sql->bind_param("i", $bookId);
    $currentbookId = $bookId;
}
// setcookie("currBookId",$currentbookId, time() + 3600,"/");
// if (isset($_COOKIE['currBookId'])) {
//     $currentbookId = $_COOKIE['currBookId'];
//     echo "Value of 'currBookId': " . $currentbookId;
// } else {
//     echo "Cookie 'myCookie' is not set.";
// }
include '../PHP_Function/db_connection.php';
<<<<<<< Updated upstream
$sql = $conn->prepare("SELECT * FROM books where bookId = ?;");
$sql->bind_param("i", $currentbookId);
$sql->execute(); // Execute the prepared statement      
$result = $sql->get_result();
$result = $result->fetch_assoc();

// echo '<script type="text/javascript">
// setTimeout(function() {
//     location.reload();
// }, 100); // Reload the page after 5 seconds
// </script>';
=======
    $sql = $conn->prepare("SELECT * FROM books where bookId = ?;");
    $sql->bind_param("i", $currentbookId);
    $sql->execute(); // Execute the prepared statement      
    $result = $sql->get_result();
    $result = $result->fetch_assoc();
    
    // echo '<script type="text/javascript">
    // setTimeout(function() {
    //     location.reload();
    // }, 100); // Reload the page after 5 seconds
    // </script>';
>>>>>>> Stashed changes
?>
<script type="text/javascript">
    function showPopup() {
        // Display a pop-up message
<<<<<<< Updated upstream
        alert("Database has been updated.");
=======
        alert("Database has been updated, please refresh page to see changes.");
>>>>>>> Stashed changes
    }
</script>
<!-- <script type="text/javascript">
    window.location.reload();
</script>' -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unoguerta</title>
<<<<<<< Updated upstream
=======
    
>>>>>>> Stashed changes
    <link rel="stylesheet" href="../CSS/styleModal.css" />
    <link rel="stylesheet" href="../CSS/responsiveModal.css" />
</head>


<body>
<<<<<<< Updated upstream
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body text-start">
                    <div class="container">
                        <form class="editbook_form"
                            action="<?php echo $_SERVER['PHP_SELF'] . "?bookId=" . $currentbookId; ?>" method="POST"
                            id="editbook_form">
                            <div class="custom_row">
                                <div class="column_6">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg" name="img" />                                           
                                            <label for="imageUpload">Change Image</label>
                                        </div>
                                        <div class="avatar-preview"
                                            style="height: 85vh; max-width: 100%; max-height: 100%;">
                                            <div id="img" style="
                            background-image: url(<?php echo $result['img']; ?>);
                            "></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="column_6">
                                    <div class="form_group">
                                        <label for="productsName" class="form-label">Book Title</label>
                                        <input type="text" class="input_box" id="bookName" name="bookName"
                                            placeholder="" input value="<?php echo $result['bookName']; ?>" />
                                    </div>
                                    <div class="form_group_6">

                                        <div class="form_group">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="text" class="input_box" id="price" name="price" placeholder=""
                                                style="width:70px; margin:auto;" input
                                                value="<?php echo $result['price']; ?>" />
                                        </div>

                                        <div class="form_group">
                                            <label for="price" class="form-label">Category</label>
                                            <!-- <input type="text" class="input_box" id="category" placeholder="">
                            <label for="dog-names">Category</label>  -->
                                            <select name="catId" id="catId"
                                                style="width:200px; margin:auto; text-align:center">

                                                <!-- get categories  -->
                                                <?php
                                                include '../PHP_Function/db_connection.php';

                                                $sql = "SELECT * FROM categories";

                                                // Execute the query
                                                $secondresult = $conn->query($sql);
                                                $bookCategories = $secondresult;
                                                // Check if the query was successful
                                                if ($secondresult) {
                                                    // Fetch and display the 'bookId' values
                                                    while ($row = $secondresult->fetch_assoc()) {
                                                        //echo "Cat ID: " . $row["catId"] . "<br>";
                                                        if ($result['catId'] == $row["catId"]) {
                                                            //is selected
                                                            echo "<option value = {$row["catId"]} selected>" . $row["catName"] . "</option>";

                                                        } else {
                                                            echo "<option value = {$row["catId"]}>" . $row["catName"] . "</option>";
                                                        }
                                                    }

                                                    // Close the result set
                                                    $secondresult->free_result();
                                                } else {
                                                    echo "Error: " . $conn->error;
                                                }

                                                ?>
                                            </select>
                                        </div>

                                        <div class="form_group">
                                            <label for="stocksLeft" class="form-label">Quantity</label>
                                            <input type="text" class="input_box" id="stock" name="stock" placeholder=""
                                                style="width:70px; margin:auto;" input
                                                value="<?php echo $result['stock']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form_group">
                                        <label for="description" class="form-label">Book Description</label>
                                        <textarea class="input_box" id="info" name="info" rows="15"
                                            placeholder=""><?php echo $result['info']; ?></textarea>
                                    </div>
                                </div>


                                <div class="add_btn_last">
                                    <button type='submit' class='btn_submit' onclick="showPopup()">Update Book
                                        Details</button>
                                    <!-- <a href="admin_addbook.php"
=======
    
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
            <form class="editbook_form" action="<?php echo $_SERVER['PHP_SELF']."?bookId=".$currentbookId; ?>" method="POST" id="editbook_form">
                <div class="custom_row">
                    <div class="column_6">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                        <input
                            type="file"
                            id="imageUpload"
                            accept=".png, .jpg, .jpeg"
                            name = "img"
                            value= "<?php echo $result['img'];?>"
                        />
                        <label for="imageUpload">Change Image</label>
                        </div>
                        <div class="avatar-preview" style = "height: 85vh; max-width: 100%; max-height: 100%;">
                        <div
                            id="img"
                            style="
                            background-image: url(<?php echo $result['img'];?>);
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
                                placeholder=""
                                input value ="<?php echo $result['bookName'];?>"
                            /> 
                        </div>
                        <div class="form_group_6">

                            <div class="form_group"> 
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="input_box" id="price" name = "price" placeholder=""style = "width:70px; margin:auto;" input value ="<?php echo $result['price'];?>"/> 
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
                                $secondresult = $conn->query($sql);
                                $bookCategories = $secondresult;
                                // Check if the query was successful
                                if ($secondresult) {
                                    // Fetch and display the 'bookId' values
                                    while ($row = $secondresult->fetch_assoc()) {
                                        echo "Cat ID: " . $row["catId"] . "<br>";
                                        echo "<option value =1>".$row["catId"]."</option>";
                                    }
                                
                                    // Close the result set
                                    $secondresult->free_result();
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
                                input value ="<?php echo $result['stock'];?>"
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
                            ><?php echo $result['info'];?></textarea> 
                        </div>
                    </div>


                    <div class="add_btn_last">
                        <button type = 'submit' class = 'btn_submit' onclick="showPopup()">Update Book Details</button>
                    <!-- <a href="admin_addbook.php"
>>>>>>> Stashed changes
                        id="addBook"
                        class="btn_submit"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        type = "submit"
                        class = "btn_submit"
                    >
                        Add New Book -->
<<<<<<< Updated upstream
                                    <a href="admin_addbook.php" class="btn_submit" id="addBookCancel"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        Go back
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
        //Display img on change
        // Get references to the file input and the image div
        const imageUpload = document.getElementById('imageUpload');
        const imgDiv = document.getElementById('img');

        // Add an event listener to the file input to listen for changes
        imageUpload.addEventListener('change', function () {
            // Check if a file has been selected
            if (imageUpload.files && imageUpload.files[0]) {
                // Create a FileReader to read the selected file
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Set the background-image of the imgDiv to the selected file
                    imgDiv.style.backgroundImage = `url(${e.target.result})`;
                };

                // Read the selected file as a data URL
                reader.readAsDataURL(imageUpload.files[0]);
            }
        });

        <?php
        include '../PHP_Function/db_connection.php';

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $img = $result['img'];

            if ($_POST['img'] !== "") {              
                $img = $_POST['img'];
                $img = "../IMG/Books/" . $img;
            }

=======
                    <a href="admin_addbook.php"
                        class="btn_submit"
                        id="addBookCancel"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        Go back
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
>>>>>>> Stashed changes
            $bookName = $_POST['bookName'];
            $bookInfo = $_POST['info'];
            $price = $_POST['price'];
            $catId = $_POST['catId'];
            $stock = $_POST['stock'];

<<<<<<< Updated upstream
            $sql = "";
            // print_r($img .$bookName. $bookInfo. $price. $catId. $stock);
        
=======

            $sql = "";
            // print_r($img .$bookName. $bookInfo. $price. $catId. $stock);

>>>>>>> Stashed changes
            //Perform checking with SQL Db
            // $sql = $conn->prepare("SELECT * FROM orders WHERE userName=?;");
            // $sql->bind_param("s", $userName);
            // $sql->execute(); // Execute the prepared statement      
        
            // $result = $sql->get_result(); // Get the result set from the executed statement                                 
<<<<<<< Updated upstream
        
=======

>>>>>>> Stashed changes
            //UPDATE to books
            $sql = $conn->prepare("UPDATE books SET bookName = ?, info = ?, img = ?, catId = ?, stock = ?, price = ? WHERE bookId = ?");
            $sql->bind_param("sssiidi", $bookName, $bookInfo, $img, $catId, $stock, $price, $currentbookId);
            $sql->execute();
            if ($sql->execute()) {
<<<<<<< Updated upstream
                //echo "Record updated successfully.";
                echo 'window.location.href = "admin_addbook.php";';
            } else {
                //echo "Error updating record: " . $sql->error;
            }

            //echo "Form submission successful.";
            // sleep(5);
        } else {
            // echo "Form submission error.";
        }
        // sleep(1);
        
=======
                echo "Record updated successfully.";
            } else {
                echo "Error updating record: " . $sql->error;
            }

            echo "Form submission successful.";
            // sleep(5);
        }else{
          echo "Form submission error.";
        }
        // sleep(1);
        echo '<script type="text/javascript">
        location.reload();
        </script>';
>>>>>>> Stashed changes


        ?>

<<<<<<< Updated upstream

    </script>

</body>

=======
        
    </script>
    
</body>
>>>>>>> Stashed changes
</html>