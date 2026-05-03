<?php session_start(); ?>

<?php

/* Function to remove only one item */
if (isset($_POST['remove_item'])) {
    require "../common.php";
    $pid = $_POST['product_id'];
    unset($_SESSION['cart'][$pid]);
    header("location:cart.php");
    exit;
}

/* Function to clear all details from cart */
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = array();
    header("location:cart.php");
    exit;
}

/* Function to upload all chosen book to cart */
$cartItems = array();
$total = 0;

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    try {
        require "../common.php";
        require_once '../src/DBconnect.php';
        foreach ($_SESSION['cart'] as $pid => $qty) {
            $sql = "SELECT * FROM products WHERE id = :id";
            $statement = $connection->prepare($sql);
            $statement->bindValue(':id', $pid);
            $statement->execute();
            $product = $statement->fetch();
            if ($product) {
                $product['qty'] = $qty;
                $product['subtotal'] = $product['price'] * $qty;
                $total += $product['subtotal'];
                $cartItems[] = $product;
            }
        }
    } catch(PDOException $error) {
        echo $error->getMessage();
    }
}

?>
<?php require_once '../template/header.php'; ?>
    <title>Your cart</title>
</head>

<body>
<div class="container">
  <div class="header clearfix">
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="cart.php">Cart</a></li>
        <?php if (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') { ?>
       <li><a href="product-add.php">Add Product</a></li>
        <?php } ?>
     
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <h3 class="text-muted">Our little book shop - Cart</h3>
  </div>

  <div class="mainarea">
    <h2>Your Cart</h2>
  </div>

  <div class="row marketing">

    <?php if (count($cartItems) > 0) { ?>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Subtotal</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($cartItems as $row) { ?>
        <tr>
          <td><?php echo escape($row['title']); ?></td>
          <td>&pound;<?php echo escape($row['price']); ?></td>
          <td><?php echo escape($row['qty']); ?></td>
          <td>&pound;<?php echo escape($row['subtotal']); ?></td>
          <td>
            <form method="post">
              <input type="hidden" name="product_id" value="<?php echo escape($row['id']); ?>">
              <button name="remove_item" class="button" type="submit">Remove</button>
            </form>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    
    <p><strong>Total: &pound;<?php echo $total; ?></strong></p>
    <form method="post">
      <button name="clear_cart" class="button" type="submit">Clear Cart</button>
    </form>
    <?php } else { ?>
      <p>Your cart is empty. <a href="index.php">Browse books</a></p>
    <?php } ?>

  </div>

<?php require_once '../template/footer.php'; ?>
