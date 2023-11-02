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

include '../PHP_Function/db_connection.php';

$sql = $conn->prepare("SELECT * FROM books WHERE stock > 0 ORDER BY RAND() LIMIT 4;");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/home.css">
</head>

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

                        <a href="../PHP_Webpage/basket.php"><i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i></a>
                    </div>
                    <a href="../PHP_Webpage/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
                </span>
            </nav>

                    <a href="#"><i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i></a>

        </div>
        <a href="../PHP_Webpage/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
        </span>
        </nav>
    </div>

    <div class="section1Container">
        <div class="section1">
            <img src="../IMG/Webpage_Images/img2.png">
            <div class="rightContent">
                <h2>Set Your Imagination Free <br>with Our Captivating Books</h2>
                <button class="button" onclick="toCatalogue()">Let's Go</button>
            </div>
        </div>
    </div>

    <div class="section2Container">
        <div class="section2">
            <h2>All Time Favourite</h2>
            <div class="alltimefav">
                <?php
                $sql->execute();
                $result4 = $sql->get_result();
                if ($result4->num_rows > 0) {
                    while ($row = $result4->fetch_assoc()) {
                        echo "<a href='description.php?bookId={$row['bookId']}'><img src='{$row['img']}' class='bookImg'></a>";
                    }
                }
                $sql->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div class="section3Container">
        <div class="section3">
            <div class="section3Content">
                <h2>Discover An Enchanting <br> World Of Wizardry</h2>
                <button class="button" onclick="toHarryPotter()">Together With Harry Potter</button>
            </div>
        </div>
    </div>

    <div class="section4Container">
        <div class="section4">
            <div class="rightContent">
                <h2 class="title">ABOUT US</h2>
                <h2>With Love</h2>
                <p>Our story began with a love for books and a dream to share that passion with you. We've curated a
                    diverse collection of literary treasures, from timeless classics to contemporary gems, ensuring
                    there's something for every reader. Whether you're a seasoned bookworm or just starting your
                    reading journey, we invite you to explore our shelves, discover new worlds, and let your
                    imagination soar. Join us in celebrating the magic of books and the joy of reading.</p>
            </div>
            <img src="../IMG/Webpage_Images/img3.png">
        </div>
    </div>

    <div class="section5Container">
        <div class="section4">
            <img src="../IMG/Webpage_Images/img1.png">
            <div class="rightContent">
                <h2 class="title">OUR MISSION</h2>
                <h2>Destination For All Literary</h2>
                <p> Our passion for books is boundless, and we're
                    thrilled to share it with you through DUNOT. Our passion for books is boundless, and we're
                    thrilled to share it with you through our online bookstore. Our mission is to connect readers
                    with the stories that enrich their lives, offering a curated selection of books that inspire,
                    educate, and entertain. We're dedicated to fostering a love for reading, one book at a time, and
                    providing an exceptional online shopping experience for book enthusiasts of all ages and tastes
                </p>
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
        function toCatalogue() {
            const url = '../PHP_Webpage/catalogue.php';
            window.location.href = url;
        }

        function toHarryPotter() {
            const url = '../PHP_Webpage/description.php?bookId=5';
            window.location.href = url;
        }
    </script>
</body>

</html>