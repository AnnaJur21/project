 <?php

    require "../config.php";

    if (isset($_POST['submit'])) {
      try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
          "firstname" => $_POST['firstname'],
          "lastname"  => $_POST['lastname'],
          "password"  => $_POST['password'],
          "email"     => $_POST['email']
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "users",
          implode(", ", array_keys($new_user)),
          ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
      } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
      }
    }
    ?>
    <?php require_once "../template/header_login.php"; ?>

        <title>Register</title>
    </head>

    <body>
    <div class="container">

      <?php if (isset($_POST['submit']) && $statement) : ?>
        <blockquote><?php echo ($_POST['firstname']); ?> successfully registered.
          <a href="login.php">Login here</a></blockquote>
      <?php endif; ?>

      <h2>Register</h2>
      <form method="post">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname">
        <label for="password">Password</label>
        <input type="text" name="password" id="password">
        <label for="email">Email Address</label>
        <input type="text" name="email" id="email">
        <input type="submit" name="submit" value="Register">
      </form>
      <a href="login.php">Back to login</a>

    </div>
    <?php require_once "../template/footer.php"; ?>
