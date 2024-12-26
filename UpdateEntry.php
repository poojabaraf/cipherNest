<?php
  require 'DB.php';
  header('Content-Type: text/plain');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $encryptionKey = $_POST['encryption_key'];
      $mode = strtolower($_POST['mode']);
      $keyLength = $_POST['key_length'];
      $outputType = $_POST['output_type'];
      $action = $_POST['action'];

      $q = "update tblencrypt_decrypt set KeyValue = '$encryptionKey', KeyMode = '$mode', KeySize = '$keyLength', OutputFormat = '$outputType',Action='$action' where KID = '$id'";

      if (mysqli_query($mysql, $q)) {
          header("location:AIndex.php");
      } else {
          die('Error: ' . mysqli_error($mysql));
      }
  }
?>
