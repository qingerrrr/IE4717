<?php
// if (isset($_COOKIE['cart'])) {
//     // unset cookies 
//     foreach ($_COOKIE['cart'] as $bookId => $value) {
//         unset($_COOKIE['cart'][$bookId]);
//         setcookie("cart[$bookId]", "", time() - 3600, "/");
//     }
// }

//var_dump($_COOKIE['cart']);

if (isset($_POST['addToCart'])) {
    // if (isset($_COOKIE['cart'])) {
    //     // unset cookies 
    //     foreach ($_COOKIE['cart'] as $bookId => $value) {
    //         unset($_COOKIE['cart'][$bookId]);
    //         setcookie("cart[$bookId]", "", time() - 3600, "/");
    //     }

    // } else {
    //     echo "Your cart is empty.";
    // }

    // echo "before<br>";
    // var_dump($_COOKIE['cart']);
    // echo "<br>";

    // $cartNum = $_COOKIE['cartNum'];
    // $cartNum = count($_COOKIE['cart']);
    // echo $cartNum;

    // echo "after<br>";   

    // Retrieve product information from the form
    $bookId = $_GET['bookId'];
    $bookName = $_GET['bookName'];
    $price = $_GET['price'];
    $qty = $_POST['qty'];

    // Create an array to store product information
    $bookInfo = array(
        'bookId' => $bookId,
        'bookName' => $bookName,
        'price' => $price,
        'qty' => $qty
    );    

    // Serialize the product information
    $serializedProduct = serialize($bookInfo);

    // Set a cookie to store the serialized product data
    setcookie("cart[$bookId]", $serializedProduct, time() + 3600, "/"); //cookie staying for 1 hour
    setcookie("book_data", $serializedProduct, time() + 3600, "/");

    //header("Location: ../PHP_Webpage/add_to_cart.php");
    header("Location: ../PHP_Webpage/description.php?bookId=" . $bookId);
    exit;

    //Count the number of itmes in the cart array    
    // $itemCount = count($_COOKIE['cart']);

    // //Update cartNum
    // setcookie("cartNum", $itemCount, time() + 3600, "/");

    // var_dump($_COOKIE['cart']);
    // echo $_COOKIE['cartNum'];

    // echo "<!DOCTYPE html><html lang='en'>";
    // echo "<script>";
    // //echo "location.reload();";
    // //echo "window.location.href = '../PHP_Webpage/description.php?bookId=$bookId';";
    // echo "</script>";
    // echo "</html>";

    // Redirect back to the product description page
// header("Location: ../PHP_Webpage/description.php?bookId=$bookId");
// exit();
}
?>