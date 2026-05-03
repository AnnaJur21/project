

<?php require_once '../template/header.php'; ?>

<?php
  
  if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'admin') {
      header("location:index.php");
      exit;
  }
  ?>
    <title>Add Product</title>
</head>


<?php
if (isset($_POST['submit'])) {
    require "../common.php";
    try {
        require_once '../src/DBconnect.php';

        $imageFilename = '';
      if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $imageFilename = basename($_FILES['image']['name']);
      move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $imageFilename);
       }

        $new_product = array(
            "title"       => escape($_POST['title']),
            "author"      => escape($_POST['author']),
            "price"       => escape($_POST['price']),
            "description" => escape($_POST['description']),
            "image"       => $imageFilename
        );
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "products",
            implode(", ", array_keys($new_product)),
            ":" . implode(", :", array_keys($new_product))
        );
        $statement = $connection->prepare($sql);
        $statement->execute($new_product);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
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
    <h3 class="text-muted">BookShop - Add Product</h3>
  </div>

  <?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo escape($_POST['title']); ?> successfully added.</blockquote>
  <?php } ?>

  <h2>Add a new product</h2>

  <form method="post" enctype="multipart/form-data">

    
    <label for="title">Title</label>
    <input type="text" name="title" id="title">

    <label for="author">Author</label>
    <input type="text" name="author" id="author">

    <label for="price">Price</label>
    <input type="text" name="price" id="price">

    <label for="description">Description</label>
    <input type="text" name="description" id="description">

    <label for="image">Book Image</label>
    <input type="file" name="image" id="image">


    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

</div>
<?php require_once '../template/footer.php'; ?>
