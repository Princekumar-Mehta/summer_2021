<?php
require_once "pdo.php";
session_start();
// Demand a GET parameter
if ( ! isset($_SESSION['username'])) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: home.php');
    return;
}
if(isset($_POST['save'])){

  if ( strlen($_POST['task_name']) < 1) {
      $_SESSION["failure"] = "Task Name Cann't be empty";
      header("Location: edit_task.php?task_id=".$_GET['task_id']);
      return;
  }
  else{
    date_default_timezone_set("Asia/Calcutta");
      $sql = "UPDATE tasks SET task_name=:task_name ,date_time=:date_time WHERE task_id=:task_id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ':task_name' => $_POST['task_name'],
          ':date_time' => date('d-m-Y H:i:s'),
          ':task_id' => $_GET['task_id']));
          $_SESSION['message']='Record edited';
      header("Location: home.php?");
      return;
    }
}
if(isset($_SESSION["failure"])){
    echo('<p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
  unset($_SESSION["failure"]);
}
$sql="SELECT task_name FROM tasks where task_id = ".$_GET['task_id'];
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
  <head>
        <title>GPM - Edit Tasks</title>
        <link href='style_file_1.css' rel="stylesheet">
  </head>
  <body style="background-color:#C4DF9D;">
        <div class="container">
            <form method='post'>
                <p>Task Name:
                  <input type="text" value=<?=$rows[0]['task_name']?> name="task_name"/></p>
                <input class='button' type="submit" name='save'value="Save">
                <input class='button' type="submit" name="Cancel" value="Cancel">
            </form>
          </div>

          <br>
          <hr>
          <br>

          <ul>
              <li>
                  <a  aria-current="page" href="home.php">Home</a>
              </li>
              <li>
                  <a  aria-current="page" href="index.php">Login</a>
              </li>
              <li>
                  <a aria-current="page" href="sign_up.php">Sign Up</a>
              </li>
              <li>
                  <a  aria-current="page" href="logout.php">Logout</a>
              </li>
          </ul>

  </body>
</html>
