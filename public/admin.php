 <?php
 
  if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'admin') {
      header("location:index.php");
      exit;
  }
  ?>

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
  
