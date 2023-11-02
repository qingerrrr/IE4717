<?php
//Ensure user is logged in
session_start();

if (!isset($_SESSION["name"])){
    echo 'Direct access not permitted. Please <a href="index.php">log in</a>.';
    die();
}

//Cookie
if (isset($_COOKIE['cart'])) {
    // Calculate the number of items in the cart
    $cartNum = count($_COOKIE['cart']);
    var_dump($_COOKIE['cart']);
} else {
    $cartNum = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Catalogue</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/catalogue.css">
</head>

<?php
include '../PHP_Function/db_connection.php';

$sql = "";

if (isset($_GET["priceRange"]) && isset($_GET["filters"])) {
    $priceRange = explode(',', $_GET["priceRange"]);
    $min = $priceRange[0];
    $max = $priceRange[1];

    $filters = explode(',', $_GET["filters"]);
    $filterPlaceholders = implode(',', array_fill(0, count($filters), '?'));

    $sql = $conn->prepare("SELECT * FROM books 
    JOIN categories ON books.catId = categories.catId
    WHERE categories.catName IN ($filterPlaceholders) AND price >= ? AND price <= ? AND stock > 0;");

    $bindParams = array_merge($filters, [$min, $max]);
    $types = str_repeat('s', count($filters)) . 'ii';
    $sql->bind_param($types, ...$bindParams);

} else {
    $sql = $conn->prepare("SELECT * FROM books WHERE stock > 0");
    $gotFitler = false;
}

$sql->execute(); // Execute the prepared statement      
$result = $sql->get_result(); // Get the result set from the executed statement   
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
                    }else{
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
            <div class="contentContainer">
                <h2>Choose Your Books</h2>

                <div class="catalogueContent">
                    <div class="filterbox">
                        <form>
                            <h4>Price Range</h4>
                            <div class="price-input">
                                <div class="field">
                                    <span>From</span>
                                    <input type="number" class="input-min" value="0" disabled>
                                </div>

                                <div class="field">
                                    <span>To</span>
                                    <input type="number" class="input-max" value="120" disabled>
                                </div>
                            </div>

                            <div class="slider">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input type="range" class="range-min" min="0" max="120" value="0" step="10">
                                <input type="range" class="range-max" min="0" max="120" value="120" step="10">
                            </div>

                            <h4 style="margin-top: 50px;">Book Catagories</h4>
                            <div class="bookFilter">
                                <input type="checkbox" id="filter1" name="bookFilter" value="Fantasy">
                                <label for="filter1">Fantasy</label><br>

                                <input type="checkbox" id="filter2" name="bookFilter" value="Novel">
                                <label for="filter2">Novel</label><br>

                                <input type="checkbox" id="filter3" name="bookFilter" value="Self-Improvement">
                                <label for="filter3">Self-Improvement</label><br>

                                <input type="checkbox" id="filter4" name="bookFilter" value="Learning">
                                <label for="filter4">Learning</label><br>
                            </div>

                            <!-- <input type="submit" class="button" id="filterBtn" value="Sort By Filter"> -->
                            <button class="button" id="filterBtn" onclick="filter()">Sort By Filter</button>
                        </form>
                    </div>

                    <div class="catalogueBooks">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='items' id='{$row['bookId']}'>";
                                echo "<a href='description.php?bookId={$row['bookId']}'><img src='{$row['img']}' class='bookImg'>";
                                echo "<h3>{$row['bookName']}</h3>";
                                echo "<h4>$" . number_format($row['price'], 2) . "</h4>";
                                echo "</a>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

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
        window.addEventListener("load", (event) => {
            //Filter UI
            const rangeInput = document.querySelectorAll(".range-input input");
            const priceInput = document.querySelectorAll(".price-input input");
            const progress = document.querySelector(".slider .progress");

            let priceGap = 10;

            // Retrieve ranger values from PHP on page load to display
            <?php
            if (isset($_GET["priceRange"])) {
                echo "updateRanger();";
            }
            ?>

            function updateRanger() {
                <?php
                if (!isset($_GET["priceRange"])) {
                    echo "exit;";
                } else {
                    $priceRange = explode(',', $_GET["priceRange"]);
                    echo "let minVal=" . $priceRange[0] . ";";
                    echo "let maxVal=" . $priceRange[1] . ";";
                }
                ?>

                if (maxVal - minVal < priceGap) {
                    if (e.target.className === "range-min") {
                        rangeInput[0].value = maxVal - priceGap;
                    } else {
                        rangeInput[1].value = minVal + priceGap;
                    }

                } else {
                    priceInput[0].value = minVal;
                    priceInput[1].value = maxVal;

                    rangeInput[0].value = minVal;
                    rangeInput[1].value = maxVal;

                    progress.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                    progress.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
                }
            }

            rangeInput.forEach(input => {
                input.addEventListener("input", e => {
                    let minVal = parseInt(rangeInput[0].value);
                    let maxVal = parseInt(rangeInput[1].value);

                    if (maxVal - minVal < priceGap) {
                        if (e.target.className === "range-min") {
                            rangeInput[0].value = maxVal - priceGap;
                        } else {
                            rangeInput[1].value = minVal + priceGap;
                        }

                    } else {
                        priceInput[0].value = minVal;
                        priceInput[1].value = maxVal;

                        progress.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                        progress.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
                    }
                })
            })

            // priceInput.forEach(input => {
            //     input.addEventListener("input", e => {
            //         let minVal = parseInt(rangeInput[0].value);
            //         let maxVal = parseInt(rangeInput[1].value);          

            //         if ((maxVal - minVal >= priceGap) && (maxVal <= 120)) {
            //             if (e.target.className === "input-min") {
            //                 rangeInput[0].value = minVal;
            //                 progress.style.left = (minVal / rangeInput[0].max) * 100 + "%";

            //             } else {
            //                 rangeInput[1].value = maxVal;
            //                 progress.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
            //             }
            //         }
            //     })
            // })

            // Retrieve filter values from PHP on page load to display
            <?php
            if (isset($_GET["filters"])) {
                echo 'var selectedFilters = ["' . implode('","', explode(',', $_GET["filters"])) . '"];';
                echo 'selectedFilters.forEach(function (value) {';
                echo '    const checkbox = document.querySelector(\'input[name="bookFilter"][value="\' + value + \'"]\');';
                echo '    if (checkbox) {';
                echo '        checkbox.checked = true;';
                echo '    }';
                echo '});';
            }
            ?>
        })

        //Filter Functinality     
        function filter() {
            event.preventDefault();

            const rangeInput = document.querySelectorAll(".range-input input");
            let min = parseInt(rangeInput[0].value);
            let max = parseInt(rangeInput[1].value);

            // Get selected filter criteria from the form
            const selectedFilters = [];
            const filterCheckboxes = document.querySelectorAll('input[name="bookFilter"]:checked');
            filterCheckboxes.forEach(function (checkbox) {
                selectedFilters.push(checkbox.value);
            });

            // Construct the URL with filter criteria
            const url = '../PHP_Webpage/catalogue.php?priceRange=' + min + ',' + max + '&filters=' + selectedFilters.join(',');

            // Redirect to the URL
            window.location.href = url;
        }
    </script>

    <?php
    $sql->close();
    $conn->close();
    ?>
</body>

</html>