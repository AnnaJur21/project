
<?php session_start(); ?>
<?php
    
    try {
        require "../common.php";
        require_once '../src/DBconnect.php';
        $sql = "SELECT * FROM products";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

    /* Add to cart */
    if (isset($_POST['add_to_cart'])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $pid = $_POST['product_id'];
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]++;
        } else {
            $_SESSION['cart'][$pid] = 1;
        }
        header("location:index.php");
        exit;
    }

    ?>
    
    <?php require_once '../template/header_login.php'; ?>
    
        <title>Book Shop</title>
    </head>

    <body>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="cart.php">Cart</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Welcome in our little book shop</h3>
      </div>


       <div class="mainarea">

            


<?php if (isset($_SESSION['Role']) ) { ?>

                  <h1>Status: You are logged in as <?php echo $_SESSION['Username'];?> </h1>
            
            <form action="logout.php" method="post" name="Logout_Form" class="form-signin">
                <button name="Submit" value="Logout" class="button" type="submit">Log out</button>
            </form>


                <?php } ?>




        </div>
      <div class="mainarea">
        <h2>Our available books</h2>
      </div>

      <div class="row marketing">

        <?php if (isset($result) && count($result) > 0) { ?>
        <table>
          <thead>
            <tr>
              <th>Cover</th>
              <th>No</th><th>Title</th><th>Author</th>
              <th>Price</th><th>Description</th><th>Action</th>
              
            </tr>
          </thead>
          <tbody>
          <?php foreach ($result as $row) { ?>
            <tr>
               <td>
          <?php if (!empty($row['image'])) { ?>
              <img src="uploads/<?php echo escape($row['image']); ?>" width="60">
          <?php } else { ?>
              No image
          <?php } ?>
      </td>
              <td><?php echo escape($row['id']); ?></td>
              <td><?php echo escape($row['title']); ?></td>
              <td><?php echo escape($row['author']); ?></td>
              <td>&pound;<?php echo escape($row['price']); ?></td>
              <td><?php echo escape($row['description']); ?></td>
              <td>
                <form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="product_id"
                         value="<?php echo escape($row['id']); ?>">
                  <button name="add_to_cart" class="button" type="submit">
                    Add to Cart</button>
                </form>
                <?php if (isset($_SESSION['Role']) && $_SESSION['Role'] == 'admin') { ?>
                  <a href="product-edit.php?id=<?php echo escape($row['id']); ?>">Edit</a> |
                  <a href="product-delete.php?id=<?php echo escape($row['id']); ?>">Delete</a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        <?php } else { ?>
          <p>No products found.</p>
        <?php } ?>

      </div>
 
    <?php require_once '../template/footer.php'; ?>
