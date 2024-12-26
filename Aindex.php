<?php
  ob_start();
  date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>AES Encryption and Decryption Tool</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/Index.css" type="text/css">
	<link href="css/bootstarp.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/AIndex.js"></script>
</head>
<body>
  <div id="background">
    <?php include "AHeader.html"; ?>
    <div id="body"><div><div>
      <div class="history">
        <?php
          session_start();
          if(isset($_SESSION['email']))
          {
            require './DB.php';

            $limit = 5;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $q = "select * from tblencrypt_decrypt";
            $res = mysqli_query($mysql, $q);
            $total_records = mysqli_num_rows($res);
            $total_pages = ceil($total_records / $limit);

            $q = "select * from tblencrypt_decrypt order by KID desc limit $limit offset $offset";
            $res = mysqli_query($mysql, $q);

            $CryptoEntries = []; 
            while ($r = mysqli_fetch_row($res)) {
                $CryptoEntries[] = $r;
            }
            if(!empty($CryptoEntries)){
              ?>
              <div class="content">
                  <ul>
                      <li>
                        <center><div class="header"><h1>CRYPTO LOG</h1></div></center>
                      </li>
                      <li><div class="header">
                        <?php if ($page > 1): ?>
                          <span><a href="?page=<?= $page - 1; ?>">Prev</a></span>
                        <?php endif; ?>
                        &nbsp; Page <?= $page; ?> of <?= $total_pages; ?>
                        <?php if ($page < $total_pages): ?>
                          <span><a href="?page=<?= $page + 1; ?>">Next</a></span>
                        <?php endif; ?>
                        <span style="float:right;"><a href="/CipherNest/index.php">Go Back To User</a></span></div></li>
                      <?php foreach ($CryptoEntries as $entry): ?>
                      <li>
                          <div class="header">
                              <b>Entry #<?= $entry[0] ?></b>
                              <span>
                                  <a href=""><?= date("d M Y h:i:s", strtotime($entry[4])) ?></a>
                                  <a href=""><?= $entry[1] ?></a>
                                  &nbsp;
                                  <a href="javascript:void(0);" onclick="fnConfirmCryptoRemove('<?= $entry[0]; ?>');">Delete</a>
                              </span>
                          </div>
                          <div class="article">
                              <p>
                                <table style="color: #727272;text-align: center;" border="1"  cellpadding="5">
                                  <thead>
                                  <tr>
                                      <th><b>Encryption Key</b></th>
                                      <th><b>Mode of Operation</b></th>
                                      <th><b>Key Length</b></th>
                                      <th><b>Output Type</b></th>
                                      <th><b>Actions</b></th>
                                  </tr>
                                  <thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <input type="text" name="encryption_key_<?= $entry[0] ?>" value="<?= !empty($entry[2]) ? $entry[2] : '' ?>" readonly>
                                      </td>
                                      <td>
                                          <input type="text" name="mode_<?= $entry[0] ?>" value="<?= !empty($entry[3]) ? strtoupper($entry[3]) : '' ?>" readonly>
                                      </td>
                                      <td>
                                          <input type="text" name="key_length_<?= $entry[0] ?>" value="<?= !empty($entry[5]) ? $entry[5] : '' ?>" readonly>
                                      </td>
                                      <td>
                                          <input type="text" name="output_type_<?= $entry[0] ?>" value="<?= !empty($entry[6]) ? $entry[6] : '' ?>" readonly>
                                      </td>
                                      <td>
                                          <input type="text" name="action_<?= $entry[0] ?>" value="<?= !empty($entry[7]) ? $entry[7] : '' ?>"  readonly>  
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <a href="javascript:void(0);" class="more mt-2 edit-link" onclick="editEntry(<?= $entry[0]; ?>,<?= $page ?>);">Edit</a>
                                <a href="javascript:void(0);" class="more mt-2 save-link" onclick="saveEntry(<?= $entry[0]; ?>,<?= $page ?>);" style="display:none;">Save</a>&nbsp;&nbsp;
                                <a href="javascript:void(0);" class="more mt-2 reset-link" onclick="resetEntry(<?= $entry[0]; ?>,<?= $page ?>);" style="display:none;">Reset</a>
                              </p>
                          </div>
                      </li>
                      <?php endforeach; ?>
                      <li><div class="header">
                        <?php if ($page > 1): ?>
                          <span><a href="?page=<?= $page - 1; ?>">Prev</a></span>
                        <?php endif; ?>
                        &nbsp; Page <?= $page; ?> of <?= $total_pages; ?>
                        <?php if ($page < $total_pages): ?>
                          <span><a href="?page=<?= $page + 1; ?>">Next</a></span>
                        <?php endif; ?>
                      </li>
                  </ul>
              </div>
            <?php
              }else{
                echo "<center style='margin-right:50px'><h1>No Record(s) Found!<br><br><img src='/images/ErrorPageEmoji.png'height='300px'></h1></center>";
              }
          }
          else
          {
            echo "<center style='margin-right:50px'><h1>Please log in as an admin.<br><br><img src='/images/ErrorPageEmoji.png'height='300px'></h1></center>";
          }
          ?>
          <!-- <div class="sidebar">
              <div>
                  <span><a href="#" class="selected">History</a></span>
                  <span><a href="#">Other Links</a></span>
              </div>
              <ul>
              </ul>
          </div> -->
        </div>
    </div></div></div>
    <?php include "Footer.html"; ?>
  </div>
</body>
</html>
<?php
  if(isset($_GET['ID'])){
    require 'DB.php';
    $ID = $_GET['ID'];
    $q = "delete from tblencrypt_decrypt where KID = '$ID'";
    if(mysqli_query($mysql,$q))
    {
      header("location:Aindex.php");
    }
    else
      die("Query Failed!!!".mysqli_error($mysql));  
  }
?>
