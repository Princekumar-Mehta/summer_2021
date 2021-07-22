<?php
require_once('pdo.php');
?>
<?php
session_start();
  if(!isset($_SESSION['username'])){
      $_SESSION['error']='To access this site, Please login';
      header('Location: index.php?');
      return ;
  }


  $sql = 'select * from user where group_id=:group_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':group_id' => $_SESSION['group_id']
  ));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
    <head>
      <title>Prince Mehta</title>
      <link href='style_file_1.css' rel="stylesheet">
      <style>
          table, th, td{
            border:1px solid black;
          }
      </style>
    </head>
    <body style="background-color:#C4DF9D;">
          <div style='background-color:#C4DF9D;'class="card">
              <div class="card-body">
                  <center><h1>Welcome, <?=$_SESSION['username']?></h1></center>
              </div>
          </div>
          <hr>
          <br>
          <ul>
              <li>
                  <a  aria-current="page" href="home.php">Home</a>
              </li>
              <li>
                  <a  aria-current="page" href="profile.php">Profile</a>
              </li>
              <li>
                  <a  aria-current="page" href="logout.php">Logout</a>
              </li>
          </ul>
          <div>
            <?php
              if(isset($_SESSION["failure"])){
                echo('<hr><p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
              unset($_SESSION["failure"]);
            }
            ?>
          </div>
          <center>
          <h1>Group Details</h1>
          <h2>Group Id : <?=$_SESSION['group_id']?></h2>
          <hr>
          <div>
                <table>
                  <tr>
                    <th>Name</th><th>Role</th><th>Unread Messages</th><th>Message</th>
                  </tr>
                      <?php
                        foreach($rows as $row){
                          echo "<tr>";
                          echo "<td>".$row['Username']."</td>";
                          echo "<td>".$row['Role']."</td>";
                          $sql = 'select count(*) from messages where sender=:sender and receiver=:receiver and status=0';
                          $stmt = $pdo->prepare($sql);
                          $stmt->execute(array(
                            ':sender' => $row['user_id'],
                            ':receiver' => $_SESSION['user_id']
                          ));
                          $unread_m = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          echo "<td>".$unread_m[0]['count(*)']."</td>";
                          echo("<td><a href='messages.php?user_id=".$row['user_id']."'>");
                          echo("Message</a></td>");
                          echo "</tr>";
                        }
                      ?>
                </table>
          </div>
          <br>
          </center>
    </body>
</html>
