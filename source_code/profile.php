<?php
  require_once('pdo.php');
?>
<?php
session_start();
if(!isset($_SESSION['username'])){
    $_SESSION['failure']='To access this site, Please login';
    header('Location: login.php?');
    return ;
}

if(isset($_POST['update'])){
  if(strlen($_POST['new_password'])<1 || strlen($_POST['new_security_question'])<1 || strlen($_POST['new_answer'])<1){
     $_SESSION['failure']='Please Fill All the details';
     header('Location: edit_user.php?user_id='.$_GET['user_id'] );
     return ;
  }
  $sql = "UPDATE user SET  password=:password,security_question=:security_question, answer=:answer WHERE user_id=:user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
      ':password' => $_POST['new_password'],
      ':security_question' => $_POST['new_security_question'],
      ':answer' => $_POST['new_answer'],
      ':user_id' => $_SESSION['user_id']));
      $_SESSION['message']='Profile edited';
  header("Location: home.php?");
  return;
}

$sql="SELECT * FROM user where user_id = ".$_SESSION['user_id'];
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
      <head>
            <title>Profile</title>
            <link href='style_file_1.css' rel="stylesheet">
            <style>
                table, th, td{
                  border:1px solid black;
                }
            </style>
      </head>
      <body style='background-color:#C4DF9D;'>
        <div style='background-color:#C4DF9D;'class="card">
            <div class="card-body">
                <center><h1>Welcome <?=$_SESSION['username']?></h1></center>
            </div>
        </div>
        <hr>
        <div>

          <?php
            if(isset($_SESSION["failure"])){
              echo('<p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
              unset($_SESSION["failure"]);
          }?>

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
                    <hr>
          <?php
            echo "
            <table>
              <form method ='post'>
                <tr><td>Username</td><td> ".$rows[0]['Username']."</td></tr>
                <tr><td>Password</td><td> <input type='text' value= ".$rows[0]['Password']." name='new_password'></td></tr>
                <tr><td>Security Question </td><td><input type='text' value= ".$rows[0]['Security_Question']." name='new_security_question'></td></tr>
                <tr><td>Answer</td><td> <input type='text' value= ".$rows[0]['Answer']." name='new_answer'></td></tr>
                <tr>
                  <td>Group</td><td>".$rows[0]['group_id']."</td>
                </tr>
                <tr>
                  <td>Role</td><td>".$rows[0]['Role']."</td>
                </tr>
                <tr>
                <td><input type='submit' class='button' value='Update' name='update'></td>
                </tr>
              </form>
            </table>
            ";
        ?>
      </body>

</html>
