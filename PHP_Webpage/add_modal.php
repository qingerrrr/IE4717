<?php
//Ensure user is logged in
session_start();

if (!isset($_SESSION["adminName"])) {
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

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
<script type="text/javascript">
    function showPopup() {
        // Display a pop-up message
<<<<<<< Updated upstream
        alert("Boook has been added.");
        alert("Database has been updated, please go back to admin home page to see the changes.");
>>>>>>> Stashed changes
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unoguerta</title>

    <link rel="stylesheet" href="../CSS/styleModal.css" />
    <link rel="stylesheet" href="../CSS/responsiveModal.css" />
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
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
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body text-start">
                    <div class="container">
                        <form class="addbook_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"
                            id="addbook_form">
                            <div class="custom_row">
                                <div class="column_6">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg" name="img" />
                                            <label for="imageUpload">Add Image</label>
                                        </div>
                                        <div class="avatar-preview" style="height: 85vh; max-width: 100%; max-height: 100%;">
                                            <div id="img" style="background-image: url(https://placehold.co/500x500);">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="column_6">
                                    <div class="form_group">
                                        <label for="productsName" class="form-label">Book Title</label>
                                        <input type="text" class="input_box" id="bookName" name="bookName" required/>
                                        <span id="bookNameError" class="error" style="color: red;"></span>
                                    </div>
                                    <div class="form_group_6">

                                        <div class="form_group">
                                            <label for="price" class="form-label">Price</label></br>
                                            <input type="text" class="input_box" id="price" name="price" placeholder="SGD"
                                                style="width:70px; margin:auto;" required>
                                            <span id="priceError" class="error" style="color: red;"></span>
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
                                                $result = $conn->query($sql);
                                                $bookCategories = $result;
                                                // Check if the query was successful
                                                if ($result) {
                                                    // Fetch and display the 'bookId' values
                                                    while ($row = $result->fetch_assoc()) {
                                                        //echo "Cat ID: " . $row["catId"] . "<br>";
                                                        echo "<option value = {$row["catId"]}>" . $row["catName"] . "</option>";
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
                                            <input type="text" class="input_box" id="stock" name="stock" placeholder=""
                                                style="width:70px; margin:auto;" required/>
                                                <span id="stockError" class="error" style="color: red;"></span>
                                        </div>
                                    </div>

                                    <div class="form_group">
                                        <label for="description" class="form-label">Book Description</label>
                                        <textarea class="input_box" id="info" name="info" rows="15"
                                            placeholder=""></textarea>
                                    </div>
                                </div>


                    <div class="add_btn_last">
                    <button type = "submit" class = "btn_submit" id = "submitButton" onclick="showPopup()" disabled>Add New Book</button>
                    <!-- <a href="admin_addbook.php"
                        id="addBook"
                        class="btn_submit"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        type = "submit"
                        class = "btn_submit"
                    >
                        Add New Book
                    </a> -->
                                    <a href="admin_addbook.php" class="btn_submit" id="addBookCencel"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        Back
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

        var checkPrice = false;
        var checkBookName = false;
        var checkStock = false;
        //Regex
        document.getElementById('bookName').addEventListener('input', function () {
        const bookNameInput = this.value;
        const bookNameRegex = /^[A-Za-z0-9\s'".!?-]+$/;

        const bookNameError = document.getElementById('bookNameError');
        const submitBtn = document.getElementById('submitButton');
        
        if (bookNameRegex.test(bookNameInput)) {
            bookNameError.textContent = '';
            submitBtn.removeAttribute('disabled');
            checkBookName = true;
        } else {
            bookNameError.textContent = 'Invalid bookname';
            submitBtn.setAttribute('disabled', true);
            checkBookName = false;
        }
        });

        document.getElementById('price').addEventListener('input', function () {
        const priceInput = this.value;
        const priceRegex = /^\$?\d+(?:\.\d{2})?$/;

        const priceError = document.getElementById('priceError');
        const submitBtn = document.getElementById('submitButton');
        
        if (priceRegex.test(priceInput)) {
            priceError.textContent = '';
            submitBtn.removeAttribute('disabled');
            checkPrice = true;
        } else {
            priceError.textContent = 'Invalid price';
            submitBtn.setAttribute('disabled', true);
            checkPrice = false;
        }
        });

        document.getElementById('stock').addEventListener('input', function () {
        const stockInput = this.value;
        const stockRegex = /^[1-9]\d*$/;

        const stockError = document.getElementById('stockError');
        const submitBtn = document.getElementById('submitButton');
        
        if (stockRegex.test(stockInput)) {
            stockError.textContent = '';
            submitBtn.removeAttribute('disabled');
            checkStock = true;
        } else {
            stockError.textContent = 'Invalid stock number';
            submitBtn.setAttribute('disabled', true);
            checkStock = false;
        }
        });
        document.addEventListener('keyup', function (event) {
            const submitBtn = document.getElementById('submitButton');
            
            if (checkStock && checkBookName && checkPrice) {
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
            $img = $_POST['img'];
            $img = "../IMG/Books/" . $img;
            $bookName = $_POST['bookName'];
            $bookInfo = $_POST['info'];
            $price = $_POST['price'];
            $catId = $_POST['catId'];
            $stock = $_POST['stock'];


            $sql = "";
            //print_r($img . $bookName . $bookInfo . $price . $catId . $stock);

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
           // $_SESSION['name'] = $userName;


            echo "window.location.href = 'admin_addbook.php';";

            $sql->close();
            $conn->close();
            //echo "Form submission successful.";
        } else {
           // echo "Form submission error.";
        }
        ?>
    </script>
</body>

</html>