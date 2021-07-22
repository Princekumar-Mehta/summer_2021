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
  if(isset($_POST['task_insert'])){

    if ( strlen($_POST['task_name']) < 1) {
        $_SESSION["failure"] = "Task Name Can't be empty";
        header("Location: home.php?");
        return;
    }
    date_default_timezone_set("Asia/Calcutta");
    $sql = "INSERT INTO tasks (task_name,user_id,group_id,date_time)
              VALUES (:task_name,:user_id,:group_id,:date_time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':task_name' => $_POST['task_name'],
        ':user_id' => $_SESSION['user_id'],
        ':date_time' => date('d-m-Y H:i:s'),
        ':group_id' => $_SESSION['group_id']));
        $_SESSION['message']='added';
    header("Location: home.php?");
    return;
  }
  else if(isset($_POST['announce'])){
    if ( strlen($_POST['details']) < 1) {
        $_SESSION["failure"] = "Annoucement Can't be empty";
        header("Location: home.php?");
        return;
    }
    date_default_timezone_set("Asia/Calcutta");
    $sql = "INSERT INTO annoucements (details,date_time,leader,group_id)
              VALUES (:details,:date_time,:leader,:group_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':details' => $_POST['details'],
        ':date_time' =>  date('d-m-Y H:i:s'),
        ':leader' => $_SESSION['user_id'],
        ':group_id' => $_SESSION['group_id']));
        $_SESSION['message']='added';
    header("Location: home.php?");
    return;
  }

  $sql = 'select task_id,user_id,task_name,task_id,date_time from tasks where group_id=:group_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':group_id' => $_SESSION['group_id'],
  ));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $sql = 'select * from annoucements where group_id=:group_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
      ':group_id' => $_SESSION['group_id'],
  ));
  $annoucements = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<html>
    <head>
      <title>Project Manager</title>
      <link href='style_file_1.css' rel="stylesheet">
      <style>
          table, th, td{
            border:1px solid black;
          }
      </style>
      <script type="text/javascript">
          function load()
          {
              setTimeout("window.open('home.php', '_self');", 100000);
          }
      </script>
    </head>
    <body onload="load()  " style="background-color:#C4DF9D;">
          <div style='background-color:#C4DF9D;'class="card">
              <div class="card-body">
                  <center><h1>Welcome, <?=$_SESSION['username']?><br> [ Group Id :: <?=$_SESSION['group_id']?> ]</h1></center>
              </div>
          </div>
          <hr>
          <ul>
              <li>
                  <a  aria-current="page" href="home.php">Home</a>
              </li>
              <li>
                  <a  aria-current="page" href="profile.php">Profile</a>
              </li>
              <li>
                  <a  aria-current="page" href="group_details.php">Group Details</a>
              </li>
              <li>
                  <a  aria-current="page" href="logout.php">Logout</a>
              </li>
          </ul>
          <hr>
          <div>
            <?php
              if(isset($_SESSION["failure"])){
                if(!$_SESSION['failure']=="Annoucement Can't be empty"){
                  echo('<p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
                  unset($_SESSION["failure"]);
                }
            }
            ?>
              <center><h1>Completed Tasks</h1></center>
              <form method='post'>
                  Task Name <input name='task_name' type='text'>
                  <input type='submit' value='Insert'name='task_insert'>
              </form>

                <table>
                  <tr>
                    <th>User Name</th><th>Task Name</th><th>Date & Time</th><th>Message</th><th>Action</th>
                  </tr>
                      <?php
                        foreach($rows as $row){
                          echo "<tr>";
                          $sql = 'select Username from user where user_id = :user_id';
                          $stmt = $pdo->prepare($sql);
                          $stmt->execute(array(
                            ':user_id' => $row['user_id']
                           ));
                          $user_row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                          echo "<td>".$user_row[0]['Username']."</td>";
                          echo "<td>".$row['task_name']."</td>";
                          echo "<td>".$row['date_time']."</td>";
                          echo("<td>");
                          echo("<a href='messages.php?user_id=".$row['user_id']."'>");
                          echo("Message</a></td>");
                          if($user_row[0]['Username'] == $_SESSION['username']){
                            echo("<td>");
                            echo("<a href='edit_task.php?task_id=".$row['task_id']."'>");
                            echo("Edit</a>/");
                            echo("<a href='delete_task.php?task_id=".$row['task_id']."'>");
                            echo("Delete</a></td>");
                          }
                          echo "</tr>";
                        }
                      ?>
                </table>
          </div>

          <br>
          <hr>
          <div class='card'>
            <center><h1>Announcements !!</h1></center>
            <?php
            if(isset($_SESSION["failure"])){
                echo('<p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
                unset($_SESSION["failure"]);
          }?>
          </div>

          <?php
            if($_SESSION['role']=='Team_leader'){
              echo"
              <form method='post'>
                  Announcement <input name='details' type='text'>
                  <input type='submit' value='Annouce'name='announce'>
              </form>";
            }
          ?>
          <br>
          <div>
          <?php
          echo"<table>";
          echo"<tr>";
          echo "<th>Leader</th><th>Details</th><th>Date & Time</th>";
          echo"</tr>";
          foreach($annoucements as $row){
            $sql = 'select Username from user where user_id = :user_id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
              ':user_id' => $row['leader']
             ));
            $user_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo"<tr>";
            echo"<td>".$user_row[0]['Username']."</td>";
            echo "<td>".$row['details']."</td>";
            echo "<td>".$row['date_time']."</td>";
            echo "</tr>";
          }
          echo "</table>";
          ?>
        </div>

    </body>
</html>
