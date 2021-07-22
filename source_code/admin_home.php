<?php
require_once('pdo.php');
?>
<?php
session_start();
  if(!isset($_SESSION['admin_name'])){
      $_SESSION['error']='To access this site, Please login';
      header('Location: admin_index.php?');
      return ;
  }


  $sql = 'select * from user';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array());
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
    <head>
      <title>GPM- Admin Home</title>
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
                  <center><h1>Welcome Admin :: <?=$_SESSION['admin_name']?></h1></center>
              </div>
          </div>
          <hr>
          <br>

          <ul>
              <li>
                  <a aria-current="page" href="create_new_account.php">Create New Account</a>
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

          <br><hr>
          <div>
                <table>
                  <tr>
                    <th>Id</th><th>Name</th><th>Password</th><th>Security_Question</th><th>Answer</th><th>Group Id</th><th>Role</th><th>Action</th>
                  </tr>
                      <?php
                        foreach($rows as $row){
                          echo "<tr>";
                          echo "<td>".$row['user_id']."</td>";
                          echo "<td>".$row['Username']."</td>";
                          echo "<td>".$row['Password']."</td>";
                          echo "<td>".$row['Security_Question']."</td>";
                          echo "<td>".$row['Answer']."</td>";
                          echo "<td>".$row['group_id']."</td>";
                          echo "<td>".$row['Role']."</td>";
                          echo("<td>");
                          echo("<a href='edit_user.php?user_id=".$row['user_id']."'>");
                          echo("Edit</a>/");
                          echo("<a href='delete_user.php?user_id=".$row['user_id']."'>");
                          echo("Delete</a></td>");
                          echo "</tr>";
                        }
                      ?>
                </table>
          </div>
          <br>
    </body>
</html>
