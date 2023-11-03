<?php
//Unset Cookie
if (isset($_COOKIE['cart'])) {
    // unset cookies 
    foreach ($_COOKIE['cart'] as $bookId => $value) {
        unset($_COOKIE['cart'][$bookId]);
        setcookie("cart[$bookId]", "", time() - 3600, "/");
    }
}

//Unset Session
Session_start();
// remove all session variables
session_unset(); 
// destroy the session 
session_destroy();

var_dump($_COOKIE['cart']);

header("Location: ../PHP_Webpage/index.php");
exit;
?>