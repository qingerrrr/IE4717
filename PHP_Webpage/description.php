<?php
//Ensure user is logged in
session_start();

if (!isset($_SESSION["name"])) {
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

//Cookie
if (isset($_COOKIE['cart'])) {
    // Calculate the number of items in the cart
    $cartNum = count($_COOKIE['cart']);
    //var_dump($_COOKIE['cart']);
} else {
    $cartNum = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Details</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/description.css">
</head>

<?php
include '../PHP_Function/db_connection.php';

$sql = "";

if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
    $sql = $conn->prepare("SELECT * FROM books WHERE bookId = ?");
    $sql->bind_param("i", $bookId);

} else {
    echo 'Direct access not permitted. Please <a href="catalogue.php">select a book</a>.';
    die();
}

$sql->execute(); // Execute the prepared statement      
?>

<body>
    <div class="container">
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
                    <a href="basket.php"><i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i></a>
        </div>
        <a href="../PHP_Webpage/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
        </span>
        </nav>
    </div>


    <div class="container">
        <div class="contentContainer">
            <div class="descriptionContainer">
                <?php
                $result = $sql->get_result(); // Get the result set from the executed statement   
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookId = $_GET['bookId'];
                        echo "<div class='imgBox'><img src='{$row['img']}' class='descImg'></div>";
                        ?>

                        <div class="bookDetails">
                            <?php
                            echo "<input name='bookName' type='hidden' data-value='0' id='bookName'><h1>{$row['bookName']}</h1>";
                            echo "<input name='price' type='hidden'><h2>$" . number_format($row['price'], 2) . "</h2>";
                            echo "<input name='stock' type='hidden'><p>{$row['stock']} In Stock</p>";
                            echo "<input name='info' type='hidden'><p>{$row['info']}</p>";

                            echo "<form class='quantityForm' onclick='checkItem()' method='POST' action='add_to_cart.php?bookId=" . $bookId .
                                "&bookName=" . $row['bookName'] . "&price=" . $row['price'] . "'>";

                            ?>

                            <!-- <form class="quantityForm" method="POST" action="../PHP_Function/add_to_cart.php"> -->
                            <label>Quantity:</label>

                            <?php
                            echo "<input type='number' name='qty' value='1' min='1' max='{$row['stock']}' id='qtyInput'
                            onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))'required><br>";
                            ?>

                            <p id="errorSpan">Error Message Placeholder</p>
                            <input type="submit" class="button descBtn" value="Add To Cart" name="addToCart" id="descBtn">
                            </form>
                        </div>
                    </div>

                    <div class="suggestionContainer">
                        <h2>You May Also Like</h2>

                        <?php
                        //Check for harry potter
                        $name = $row['bookName'];
                        $inputStringLower = strtolower($name);
                        $searchString = "harry potter";

                        if (strpos($inputStringLower, $searchString) !== false) {
                            //has potter
                            $sql = $conn->prepare("SELECT * FROM books WHERE (bookName LIKE '%Harry Potter%' OR catId = ?) AND bookId <> ? AND stock > 0;");
                            $sql->bind_param("ii", $row['catId'], $bookId);

                        } else {
                            //no potter                    
                            $sql = $conn->prepare("SELECT * FROM books WHERE bookId <> ? AND stock > 0 ORDER BY RAND() LIMIT 4;");
                            $sql->bind_param("i", $bookId);
                        }
                        ?>

                        <div class="recoBooksContainer">

                            <?php
                            $sql->execute();
                            $result4 = $sql->get_result();
                            if ($result4->num_rows > 0) {
                                while ($row = $result4->fetch_assoc()) {
                                    echo "<div class='items' id='{$row['bookId']}'>";
                                    echo "<a href='description.php?bookId={$row['bookId']}'><img src='{$row['img']}' class='bookImg'>";
                                    echo "<h3>{$row['bookName']}</h3>";
                                    echo "<h4>$" . number_format($row['price'], 2) . "</h4>";
                                    echo "</a>";
                                    echo "</div>";
                                }
                            }
                    }

                } else {
                    echo "Book Not Found!";
                }

                $sql->close();
                $conn->close();
                ?>
                </div>
            </div>
        </div>

        <?php
        ?>
        <footer>
            <div>
                <h1>
                    DUNOT BOOKSTORE
                </h1>
                <p>50 Nanyang Avenue, <br>South Spine, <br>Singapore 639798.</p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if(!performValidation()){                
                const errorSpan = document.getElementById("errorSpan");
                errorSpan.textContent = 'Item has already been added to cart.';
                errorSpan.style.visibility = 'visible';

                var addtocartBtn = document.getElementById('descBtn');
                addtocartBtn.setAttribute("disabled", "true");         
                
                const numberInput = document.getElementById("qtyInput");
                numberInput.setAttribute("disabled", "true");
            }
        });

        //Check if qty input is more than stock
        const numberInput = document.getElementById("qtyInput");
        const errorSpan = document.getElementById("errorSpan");
        const maxAttributeValue = numberInput.getAttribute("max");
        var addtocartBtn = document.getElementById('descBtn');

        numberInput.addEventListener("input", function () {
            if (numberInput.value === null || numberInput.value.trim() === "") {
                errorSpan.textContent = "Please enter your quantity";
                errorSpan.style.visibility = 'visible';
                addtocartBtn.setAttribute("disabled", "true");

            } else if (numberInput.validity.rangeUnderflow) {
                //numberInput.setCustomValidity("Value must be greater than or equal to 1.");
                errorSpan.textContent = "Quantity must be greater than or equal to 1";
                errorSpan.style.visibility = 'visible';
                addtocartBtn.setAttribute("disabled", "true");

            } else if (numberInput.validity.rangeOverflow) {
                // numberInput.setCustomValidity("We only have " + maxAttributeValue + " in stock :(");
                errorSpan.textContent = "There are only " + maxAttributeValue + " left in stock!";
                errorSpan.style.visibility = 'visible';
                addtocartBtn.setAttribute("disabled", "true");

            } else {
                //errorSpan.textContent = numberInput.validationMessage;
                errorSpan.style.visibility = 'hidden';
                addtocartBtn.removeAttribute("disabled");
            };

        });

        //Check if item already in cart
        // var bookName = document.getElementById('bookName');
        // var added = bookName.getAttribute('data-value');

        addtocartBtn.addEventListener("click", checkItem);

        function checkItem() {
            if (performValidation()) {
                return true;
            } else {
                event.preventDefault();

                errorSpan.textContent = "Item has already been added to cart.";
                errorSpan.style.visibility = 'visible';
                return false;
            }

            // if (!performValidation()) {
            //     console.log("in cart");
            //     // If validation fails, prevent the form from submitting
            //     event.preventDefault();
            //     // errorSpan.textContent = "Item has already added to cart.";
            //     // errorSpan.style.visibility = 'visible';
            //     // addtocartBtn.setAttribute("disabled", "true");
            // } else {
            //     console.log("not in cart");
            //     //return true;
            // }
        }

        function performValidation() {
            <?php
            $bookId = $_GET['bookId'];

            // Check if the cart cookie is set and if it contains the item with the specified bookId
            if (isset($_COOKIE['cart']) && isset($_COOKIE['cart'][$bookId])) {
                // The item with the specified bookId is already in the cart
                $cartData = unserialize($_COOKIE['cart'][$bookId]);
                $qty = $cartData['qty'];

                echo "console.log('Item with bookId $bookId is in the cart.');";     
                echo "numberInput.value='$qty';";
                echo "return false;";

            } else {
                // The item with the specified bookId is not in the cart
                echo "console.log('Item with bookId $bookId is not in the cart.');";
                echo "return true;";
            }
            ?>
        };

    </script>
</body>

</html>