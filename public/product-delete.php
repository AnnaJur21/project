
  <?php
  session_start();
  if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'admin') {
      header("location:index.php");
      exit;
  }

  require "../common.php";

  if (isset($_GET['id'])) {
      try {
          require_once '../src/DBconnect.php';
          $id = $_GET['id'];
          $sql = "DELETE FROM products WHERE id = :id";
          $statement = $connection->prepare($sql);
          $statement->bindValue(':id', $id);
          $statement->execute();
      } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
      }
  }

  header("location:index.php");
  exit;
  ?>
