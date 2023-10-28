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
                    <a href="#"><i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i></a>
        </div>
        <a href="#"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
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
                            echo "<input name='bookName' type='hidden'><h1>{$row['bookName']}</h1>";
                            echo "<input name='price' type='hidden'><h2>$" . number_format($row['price'], 2) . "</h2>";
                            echo "<input name='stock' type='hidden'><p>{$row['stock']} In Stock</p>";
                            echo "<input name='info' type='hidden'><p>{$row['info']}</p>";

                            echo "<form class='quantityForm' method='POST' action='add_to_cart.php?bookId=" . $bookId .
                                "&bookName=" . $row['bookName'] . "&price=" . $row['price'] . "'>";

                            ?>

                            <!-- <form class="quantityForm" method="POST" action="../PHP_Function/add_to_cart.php"> -->
                            <label>Quantity:</label>

                            <?php
                            echo "<input type='number' name='qty' value='1' min='1' max='{$row['stock']}' id='qtyInput' required><br>";
                            ?>

                            <span id="errorSpan" style="color: red;"></span>
                            <input type="submit" class="button descBtn" value="Add To Cart" name="addToCart">
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
                            $sql = $conn->prepare("SELECT * FROM books WHERE (bookName LIKE '%Harry Potter%' OR catId = ?) AND bookId <> ?;");
                            $sql->bind_param("ii", $row['catId'], $bookId);

                        } else {
                            //no potter                    
                            $sql = $conn->prepare("SELECT * FROM books WHERE bookId <> ? ORDER BY RAND() LIMIT 4;");
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

                    <!-- <div class="recoBooksContainer">
                            <div class="items" id="book1">
                                <a href="catalogue.html"><img src="../IMG/Books/pj_som.jpg" class="bookImg">
                                    <h3>Book Title 1</h3>
                                    <h4>$50.00</h4>
                                </a>
                            </div>

                            <div class="items" id="book2">
                                <a href="catalogue.html"><img src="../IMG/Books/hp_cos.jpg" class="bookImg"></a>
                                <h3>Book Title 1</h3>
                                <h4>$50.00</h4>
                            </div>

                            <div class="items" id="book3">
                                <a href="catalogue.html"><img src="../IMG/Books/Book8.jpg" class="bookImg"></a>
                                <h3>Book Title 1</h3>
                                <h4>$50.00</h4>
                            </div>

                            <div class="items" id="book1">
                                <a href="catalogue.html"><img src="../IMG/Books/hp_cos.jpg" class="bookImg"></a>
                                <h3>Book Title 1</h3>
                                <h4>$50.00</h4>
                            </div>
                        </div> -->

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
        //Check if qty input is more than stock
        const numberInput = document.getElementById("qtyInput");
        const errorSpan = document.getElementById("errorSpan");
        const maxAttributeValue = numberInput.getAttribute("max");

        numberInput.addEventListener("input", function () {

            if (numberInput.validity.rangeUnderflow) {
                numberInput.setCustomValidity("Value must be greater than or equal to 1.");

            } else if (numberInput.validity.rangeOverflow) {
                numberInput.setCustomValidity("We only have " + maxAttributeValue + " in stock :(");

            } else {
                numberInput.setCustomValidity("");
            }

            errorSpan.textContent = numberInput.validationMessage;

        });
    </script>
</body>

</html>