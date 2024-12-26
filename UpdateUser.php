<?php
  session_start();
  require 'DB.php';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $User = $_REQUEST['User'];
      $Password = $_REQUEST['Password'];
      $Id = $_REQUEST['id'];

      $q = "update tblUser set UName = '$User', PassWD = '$Password',CPassWD = '$Password' where UNo = '$Id'";
      if (mysqli_query($mysql, $q)) {
          header("location:User.php");
          exit();
      } else {
          die('Error: ' . mysqli_error($mysql));
      }
  }
?>
