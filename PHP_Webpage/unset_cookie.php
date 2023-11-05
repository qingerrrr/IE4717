<?php
//Unset Cookie
if (isset($_COOKIE['cart'])) {
    // unset cookies 
    foreach ($_COOKIE['cart'] as $bookId => $value) {
        unset($_COOKIE['cart'][$bookId]);
        setcookie("cart[$bookId]", "", time() - 3600, "/");
    }
}

echo "<script>
window.location.href = 'thankyou.php';
</script>
";
?>