<?php
  ob_start();
  date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>AES Encryption and Decryption Tool</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
	<link href="css/bootstarp.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="js/jquery-3.7.1.min.js"></script>
  <script>
    function fnConfirmCryptoRemove(ID) {
      console.log(ID);
      Swal.fire({
        title: 'Are you sure?',
        text: 'Want to delete this log entry?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it',
        cancelButtonText: 'No, Keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'Log.php?ID=' + ID;
        }
    });
    }
  </script>
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

                  $q = "select * from tblUserActivity";
                  $res = mysqli_query($mysql, $q);
                  $total_records = mysqli_num_rows($res);
                  $total_pages = ceil($total_records / $limit);

                  $q = "select * from tblUserActivity order by SID desc limit $limit offset $offset";
                  $res = mysqli_query($mysql, $q);

                  $LogEntries = []; 
                  while ($r = mysqli_fetch_row($res)) {
                      $LogEntries[] = $r;
                  }
                  if(!empty($LogEntries)){
                    ?>
                    <div class="content">
                        <ul>
                            <li>
                              <center><div class="header"><h1>ACTIVITY LOG</h1></div></center>
                            </li>
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
                            <?php foreach ($LogEntries as $entry): ?>
                            <li>
                                <div class="header">
                                    <b>Entry #<?= $entry[0] ?></b>
                                    <span>
                                        <a href=""><?= $entry[1] ?></a>
                                        &nbsp;
                                        <a href="javascript:void(0);" onclick="fnConfirmCryptoRemove('<?= $entry[0]; ?>');">Delete</a>
                                    </span>
                                </div>
                                <div class="article">
                                    <p>
                                      <table align="center" style="color: #727272;text-align: center;" border="1"  cellpadding="5">
                                        <thead>
                                        <tr>
                                            <th><b>Last Login Time</b></th>
                                            <th><b>Last Logout Time</b></th>
                                            <th><b>User Status</b></th>
                                            <th><b>Session Duration</b></th>
                                            <th><b>User Role</b></th>
                                        </tr>
                                        <thead>
                                        <tbody>
                                          <tr>
                                            <td><?= !empty($entry[2]) ? $entry[2] : '- -' ?></td>
                                            <td><?= !empty($entry[3]) ? $entry[3] : '- -' ?></td>
                                            <td><?= !empty($entry[4]) ? $entry[4] : '- -' ?></td>
                                            <td><?= !empty($entry[5]) ? $entry[5] : '- -' ?></td>
                                            <td><?= !empty($entry[6]) ? ($entry[6] == 1 ? 'Admin' : 'User') : '- -' ?></td>
                                          </tr>
                                        </tbody>
                                      </table>
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
    $q = "delete from tblUserActivity where SID = '$ID'";
    if(mysqli_query($mysql,$q))
    {
      header("location:Log.php");
    }
    else
      die("Query Failed!!!".mysqli_error($mysql));  
  }
?>
