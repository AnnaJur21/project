
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookShop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
    <h2><a href="index.php">BookShop</a></h2>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['Active']) && $_SESSION['Active'] === true) : ?>
                <li><a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a></li>
                <li><a href="product-add.php">Add Product</a></li>
                <li class="welcome">Hello, <?php echo htmlspecialchars($_SESSION['Username'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else : ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main class="container">
