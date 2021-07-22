<?php
  require_once "pdo.php";
  if(isset($_POST['delete'])){
    $sql = "DELETE FROM tasks WHERE task_id=:task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':task_id' => $_GET['task_id']));
        $_SESSION['message']='Record deleted';
    header("Location: home.php?");
    return;
  }
    $sql="SELECT task_name FROM tasks where task_id = ".$_GET['task_id'];
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
    <head>
          <title>GPM - Delete Task</title>
          <link href='style_file_1.css' rel="stylesheet">
    </head>
</html>
<body style="background-color:#C4DF9D;">
    <h1>Confirm: Deleting <?=$rows[0]['task_name']?></h1>
    <form method='post'>
        <input type='hidden' name='task_d' value=<?=$_GET['task_id']?>>
        <input type='submit' class='button' name='delete' value='Delete'>
    </form>
    <a href='home.php'>Cancel</a>

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
            <a  aria-current="page" href="logout.php">Logout</a>
        </li>
    </ul>

</body>
