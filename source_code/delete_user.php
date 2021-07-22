<?php
  require_once "pdo.php";
  if(isset($_POST['delete'])){
    $sql = "DELETE FROM user WHERE user_id=:user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':user_id' => $_GET['user_id']));
        $_SESSION['message']='Record deleted';
    header("Location: admin_home.php?");
    return;
  }
    $sql="SELECT * FROM user where user_id = ".$_GET['user_id'];
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
    <head>
          <title>GPM - Delete User</title>
          <link href='style_file_1.css' rel="stylesheet">
    </head>
</html>
<body style="background-color:#C4DF9D;">
  <ul>
      <li>
          <a aria-current="page" href="create_new_account.php">Create New Account</a>
      </li>
      <li>
          <a  aria-current="page" href="admin_home.php">Home</a>
      </li>
      <li>
          <a  aria-current="page" href="logout.php">Logout</a>
      </li>
  </ul>
  <hr>
    <h1>Confirm: Deleting <?=$rows[0]['Username']?></h1>
    <form method='post'>
        <input type='hidden' name='user_id' value=<?=$_GET['user_id']?>>
        <input type='submit' class='button' name='delete' value='Delete'>
    </form>
    <a href='admin_home.php'>Cancel</a>

    <br>
    <hr>
    <br>

</body>
