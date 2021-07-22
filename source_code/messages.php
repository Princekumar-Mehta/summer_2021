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
  if(isset($_POST['send'])){

    if ( strlen($_POST['message']) < 1) {
        $_SESSION["failure"] = "Message Can't be empty";
        header("Location: messages.php?user_id=".$_GET['user_id']);
        return;
    }
    date_default_timezone_set("Asia/Calcutta");
    $sql = "INSERT INTO messages (sender,message,receiver,date_time)
              VALUES (:sender,:message,:receiver,:date_time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':sender' => $_SESSION['user_id'],
        ':receiver' => $_GET['user_id'],
        ':date_time' => date('d-m-Y H:i:s'),
        ':message' => $_POST['message']));
        $_SESSION['message']='sent';
    header("Location: messages.php?user_id=".$_GET['user_id']);
    return;
  }

  $sql = 'select * from messages where (sender=:sender and receiver=:receiver) or (sender=:receiver and receiver=:sender)';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':sender' => $_GET['user_id'],
    ':receiver' => $_SESSION['user_id'],
  ));

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $sql = 'select Username from user where user_id=:receiver';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':receiver' => $_GET['user_id'],
  ));
  $receiver = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if(isset($_POST['mark_as_read'])){
    $sql = "UPDATE messages SET status=1 WHERE sender=:sender and receiver=:receiver";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':sender'=>$_GET['user_id'],
        ':receiver'=>$_SESSION['user_id']
        ));
        $_SESSION["message"] = "Marked as Read";
        header("Location: messages.php?user_id=".$_GET['user_id']);
        return;
  }
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
      <script type="text/javascript">
          function load()
          {
              setTimeout("window.open(messages.php?task_id=".$_GET['user_id'], '_self');", 20000);
          }
      </script>
    </head>
    <body onload="load()  " style="background-color:#C4DF9D;">
          <div style='background-color:#C4DF9D;'class="card">
              <div class="card-body">
                  <center>
                    <h1>Welcome To Chat
                      <br>Sender = <?=$_SESSION['username']?>
                      <br>Receiver = <?=$receiver[0]['Username']?>
                   </h1>
                 </center>
              </div>
          </div>
          <hr>
                    <ul>
                        <li>
                            <a  aria-current="page" href="home.php">Home</a>
                        </li>
                        <li>
                            <a  aria-current="page" href="index.php">Login</a>
                        </li>
                        <li>
                            <a  aria-current="page" href="group_details.php">Group Details</a>
                        </li>
                        <li>
                            <a  aria-current="page" href="logout.php">Logout</a>
                        </li>
                    </ul>
          <div>
          <?php
             if(isset($_SESSION['message'])){
                 echo("<span style='color:green'>".$_SESSION['message']."</span>");
                 unset($_SESSION['message']);
             }
          ?>
            <?php
              if(isset($_SESSION["failure"])){
                echo('<p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
              unset($_SESSION["failure"]);
            }
            ?>
              <form method='post'>
                  <h2>Message &nbsp&nbsp <input name='message' type='text'>
                  <input type='submit' value='SEND'name='send'>
              </form>
          </div>

          <br><hr>
          <div>
                <table>
                  <tr>
                    <th>Sender Name</th><th>Message</th><th>Date_Time</th>
                  </tr>
                      <?php
                        foreach($rows as $row){
                          echo "<tr>";
                          $sql = 'select Username from user where user_id = :user_id';
                          $stmt = $pdo->prepare($sql);
                          $stmt->execute(array(
                            ':user_id' => $row['sender']
                           ));
                          $user_row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                          echo "<td>".$user_row[0]['Username']."</td>";
                          echo "<td>".$row['message']."</td>";
                          echo "<td>".$row['date_time']."</td>";
                          echo "</tr>";
                        }
                      ?>
                </table>
          </div>

          <br>
          <hr>
          <form method='post'>
            <input class='button' type='submit' Value='Marks as Read' name='mark_as_read'>
          </form>
          <br>
    </body>
</html>
