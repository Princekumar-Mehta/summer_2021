<?php
  require_once('pdo.php');
?>
<?php
session_start();
if(!isset($_SESSION['admin_name'])){
    $_SESSION['failure']='To access this site, Please login';
    header('Location: admin_index.php?');
    return ;
}

if(isset($_POST['update'])){
  if(strlen($_POST['new_username'])<1 || strlen($_POST['new_password'])<1 || strlen($_POST['new_security_question'])<1 || strlen($_POST['new_answer'])<1||strlen($_POST['new_group_id'])<1 || strlen($_POST['new_role'])<1){
     $_SESSION['failure']='Please Fill All the details';
     header('Location: edit_user.php?user_id='.$_GET['user_id'] );
     return ;
  }
  else if($_POST['new_group_id']<1){
    $_SESSION['failure']='Group id should be positive';
    header('Location: edit_user.php?user_id='.$_GET['user_id'] );
    return ;
  }
  $sql = "UPDATE user SET username=:username, password=:password, security_question=:security_question, answer=:answer,role=:role  WHERE user_id=:user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
      ':username' => $_POST['new_username'],
      ':password' => $_POST['new_password'],
      ':security_question' => $_POST['new_security_question'],
      ':answer' => $_POST['new_answer'],
      ':role' => $_POST['new_role'],
      ':user_id' => $_GET['user_id']));
      $_SESSION['message']='Record edited';
  header("Location: admin_home.php?");
  return;
}

$sql="SELECT * FROM user where user_id = ".$_GET['user_id'];
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
      <head>
            <title>GPM - Profile</title>
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
                <center><h1>Welcome <?=$_SESSION['admin_name']?></h1></center>
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
          <?php
            echo "
            <table>
              <form method ='post'>
                <tr><td>Username</td><td> <input type='text' value= ".$rows[0]['Username']." name='new_username'></td></tr>
                <tr><td>Password</td><td> <input type='text' value= ".$rows[0]['Password']." name='new_password'></td></tr>
                <tr><td>Security Question </td><td><input type='text' value= ".$rows[0]['Security_Question']." name='new_security_question'></td></tr>
                <tr><td>Answer</td><td> <input type='text' value= ".$rows[0]['Answer']." name='new_answer'></td></tr>
                <tr>
                  <td>Group</td><td><input type='number' value= ".$rows[0]['group_id']." min_value='1' name='new_group_id'></td>
                </tr>
                <tr>
                  <td>Role</td><td><input type='radio' value='Team_leader' name='new_role'><label>Team Leader</label><input type='radio' value='Team_member'name='new_role'><label>Team Member</label><br></td>
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
