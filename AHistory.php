<?php
  ob_start();
  date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>AES Encryption and Decryption Tool</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <script src="js/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function fnConfirmHistoryRemove(ID,pno) {
      console.log(ID);
      Swal.fire({
        title: 'Are you sure?',
        text: "Want to delete this user's history entry?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it',
        cancelButtonText: 'No, Keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'AHistory.php?ID=' + ID + '&PNo=' + pno;
        }
    });
    }
  </script>
</head>
<body>
    <div id="background">
        <?php include "AHeader.html"; ?>
        <div id="body"><div><div>
            <div class="history" >
              <?php
                session_start();
                if(isset($_SESSION['email']))
                {
                  require 'DB.php';

                  $limit = 5;
                  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                  $offset = ($page - 1) * $limit;

                  $q = "select * from tblhistory";
                  $res = mysqli_query($mysql, $q);
                  $total_records = mysqli_num_rows($res);
                  $total_pages = ceil($total_records / $limit);

                  $q = "select * from tblhistory order by HID desc limit $limit offset $offset";
                  $res = mysqli_query($mysql, $q);

                  $historyEntries = []; 
                  while ($r = mysqli_fetch_row($res)) {
                      $historyEntries[] = $r;
                  }
                  if(!empty($historyEntries)){
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
                              </div>
                            </li>
                            <?php foreach ($historyEntries as $entry): ?>
                            <li>
                                <div class="header">
                                    <b>Entry #<?= $entry[0] ?></b>
                                    <span>
                                        <a href=""><?= date("d M Y H:i:s", strtotime($entry[5])) ?></a>
                                        <a href=""><?= $entry[1] ?></a>
                                        &nbsp;
                                        <a href="javascript:void(0);" onclick="fnConfirmHistoryRemove('<?= $entry[0]; ?>',<?= $page; ?>);">Delete</a>
                                    </span>
                                </div>
                                <div class="article">
                                    <p>
                                        <b>Original Data :</b><span> <?= !empty($entry[2]) ? $entry[2] : '- -' ?></span><br>
                                        <b>Encrypted Data :</b> <span><?= !empty($entry[3]) ? $entry[3] : '- -' ?></span><br>
                                        <b>Decrypted Data :</b> <span><?= !empty($entry[4]) ? $entry[4] : '- -' ?></span><br>
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
                      echo "<center style='margin-right:50px'><h1>No Record(s) Found!<br><br><img src='images/ErrorPageEmoji.png'height='300px'></h1></center>";
                    }
                }
                else
                {
                  echo "<center style='margin-right:50px'><h1>To keep your data, you'll need to become a member!<br><br><img src='images/ErrorPageEmoji.png'height='300px'></h1></center>";
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
    $PNo = $_GET['PNo'];
    $q = "delete from tblhistory where HID = '$ID'";
    if(mysqli_query($mysql,$q))
    {
      header("location:AHistory.php?page=$PNo");
    }
    else
      die("Query Failed!!!".mysqli_error($mysql));  
  }
?>
