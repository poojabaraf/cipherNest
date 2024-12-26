<?php
  ob_start();
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>AES Encryption and Decryption Tool</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/User.css" type="text/css">
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/User.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                  require 'DB.php';

                  $limit = 5;
                  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                  $offset = ($page - 1) * $limit;

                  $q = "select * from tblUser";
                  $res = mysqli_query($mysql, $q);
                  $total_records = mysqli_num_rows($res);
                  $total_pages = ceil($total_records / $limit);

                  $q = "select * from tblUser order by CreationDateTime desc limit $limit offset $offset";
                  $res = mysqli_query($mysql, $q);

                  $UserEntries = []; 
                  while ($r = mysqli_fetch_row($res)) {
                      $UserEntries[] = $r;
                  }
                  if(!empty($UserEntries)){
                    ?>    
                    <div class="content">
                        <ul>
                            <li>
                              <div class="header">
                              <?php if ($page > 1): ?>
                              <span><a href="?page=<?= $page - 1; ?>">Prev</a></span>
                              <?php endif; ?>
                              &nbsp; Page <?= $page; ?> of <?= $total_pages; ?>
                              <?php if ($page < $total_pages): ?>
                                <span><a href="?page=<?= $page + 1; ?>">Next</a></span>
                              <?php endif; ?>
                              <span style="float:right;"><a href="/CipherNest/index.php">Go Back To User</a></span>
                                <span style="float: right;"><a>Total <?= count($UserEntries) ?> User(s) Found</a></span>
                              </div>
                            </li>
                            <?php foreach ($UserEntries as $entry): ?>
                            <li>
                                <div class="header">
                                    <span>
                                        <a href=""><?= date("d M Y H:i:s", strtotime($entry[5])) ?></a>&nbsp;
                                        <a href=""><?= $entry[1] ?></a>&nbsp;
                                        <a href="javascript:void(0);" onclick="fnConfirmUserRemove('<?= $entry[0]; ?>');">Delete</a>&nbsp;
                                        <a href="/CipherNest/Login.php?Admin=<?= $entry[1] ?>">Add</a>
                                    </span>
                                </div>
                                <div class="article">
                                  <p>
                                    <b>User Name :</b> <input type="text" name="User_<?= $entry[0] ?>" value="<?= !empty($entry[2]) ? $entry[2] : '' ?>" style="width: 300px;" readonly><br><br>  
                                    <b>Password :</b> <input type="text" name="Password_<?= $entry[0] ?>" value="<?= !empty($entry[3]) ? $entry[3] : '' ?>" style="width: 310px;" readonly><br><br>
                                    <!-- <a href="javascript:void(0);" class="more mt-2 edit-link" onclick='editEntry(<?= $entry[0]; ?>);'>Edit</a>
                                    <a href="javascript:void(0);" class="more mt-2 save-link" onclick="saveEntry(<?= $entry[0]; ?>);"style="display:none;">Save</a>&nbsp;&nbsp;
                                    <a href="javascript:void(0);" class="more mt-2 reset-link" onclick='resetEntry(<?= $entry[0]; ?>);' style="display:none;">Reset</a> -->
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
    $q = "delete from tblUser where UNo = '$ID'";
    if(mysqli_query($mysql,$q))
    {
      header("location:User.php");
    }
    else
      die("Query Failed!!!".mysqli_error($mysql));  
  }
?>
