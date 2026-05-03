

<?php require_once '../template/header.php'; ?>

<?php
 
  if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'admin') {
    header("location:index.php");  
      exit;
  }
  ?>


    <title>Edit Product</title>
</head>


<?php

require "../common.php";

if (isset($_POST['submit'])) {
    try {
        require_once '../src/DBconnect.php';

 
        $product = array(
            "id"          => escape($_POST['id']),
            "title"       => escape($_POST['title']),
            "author"      => escape($_POST['author']),
            "price"       => escape($_POST['price']),
            "description" => escape($_POST['description'])
        );
        $sql = "UPDATE products
                SET title = :title,
                    author = :author,
                    price = :price,
                    description = :description
                WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->execute($product);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET['id'])) {
    try {
        require_once '../src/DBconnect.php';
        $id = $_GET['id'];
        $sql = "SELECT * FROM products WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something went wrong!";
    exit;
}

?>




<body>
<div class="container">
  <div class="header clearfix">
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="product-add.php">Add Product</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <h3 class="text-muted">Book Shop - Edit Product</h3>
  </div>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <?php echo escape($_POST['title']); ?> successfully updated.
  <?php endif; ?>

  <h2>Edit product</h2>

  <form method="post" enctype="multipart/form-data">
  <?php foreach ($product as $key => $value) : ?>
    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
    <input type="text"
           name="<?php echo $key; ?>"
           id="<?php echo $key; ?>"
           value="<?php echo escape($value); ?>"
           <?php echo ($key === 'id' ? 'readonly' : ''); ?>>
            

  
  <?php endforeach; ?>
  
  <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

</div>
<?php require_once '../template/footer.php'; ?>
