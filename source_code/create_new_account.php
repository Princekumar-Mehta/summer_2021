<?php
require_once('pdo.php')
?>
<?php
      session_start();
      if(!isset($_SESSION['admin_name'])){
          $_SESSION['failure']='To access this site, Please login';
          header('Location: admin_index.php?');
          return ;
      }

      if(isset($_POST['submit'])){
         if(strlen($_POST['username'])<1 || strlen($_POST['password'])<1 || strlen($_POST['security_question'])<1 || strlen($_POST['answer'])<1 ||strlen($_POST['group_id'])<1|| strlen($_POST['role'])<1){
            $_SESSION['failure']='Please Fill All the details';
            header('Location: create_new_account.php?');
            return ;
         }else if($_POST['group_id']<1){
           $_SESSION['failure']='Group id should be positive';
           header('Location: create_new_account.php?');
           return ;
         }else{
           $sql="SELECT password FROM user where username = :username";
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(
               ':username' => $_POST['username']));
           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if(!empty($rows)){
                $_SESSION['error']="Name Already Exist";
                header('Location: create_new_account.php?');
                return;
              }else{
                    $sql = "INSERT INTO user (username, password, security_question, answer,group_id,role)
                          VALUES (:username,:password ,:security_question, :answer, :group_id,:role)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':username' => $_POST['username'],
                        ':password' => $_POST['password'],
                        ':security_question' => $_POST['security_question'],
                        ':answer' => $_POST['answer'],
                        ':group_id' => $_POST['group_id'],
                        ':role' => $_POST['role']));
                   header('Location: admin_home.php?');
                   return;
              }
         }
      }
?>

<html>
      <head>
            <title>Admin: Create New</title>
            <link href='style_file_1.css' rel="stylesheet">
      </head>
      <body style="background-color:#C4DF9D;">
                <div class="card-body">
                  <div style='background-color:#C4DF9D;'class="card">
                    <h1><b><center>Welcome</center></b></h1>
                </div>
          </div>
          <br>

          <ul>  
              <li>
                  <a  aria-current="page" href="admin_home.php">Home</a>
              </li>
              <li>
                  <a  aria-current="page" href="logout.php">Logout</a>
              </li>
          </ul>
          <hr>
          <div class='table-responsive border_div padding'>
           <center>
             <?php
                if(isset($_SESSION['failure'])){
                    echo("<span style='color:red'>".$_SESSION['failure']."</span>");
                    unset($_SESSION['failure']);
                }
             ?>
            <form method='post'>
              <table class='table'>
                <tr>
                 <td>Username</td><td><input type='text' name='username'></td>
                </tr>
                <tr>
                  <td>Password</td><td><input type='password' name='password'></td>
                </tr>
                <tr>
                 <td>Security Question</td><td><input type='text' name='security_question'></td>
                </tr>
                <tr>
                  <td>Answer</td><td><input type='text' name='answer'></td>
                </tr>
                <tr>
                  <td>Group</td><td><input type='number' name='group_id'></td>
                </tr>
                <tr>
                  <td>Role</td><td><input type='radio' value='Team_leader' name='role'><label>Team Leader</label><input type='radio' value='Team_member'name='role'><label>Team Member</label><br></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class='button'name='submit' type='submit' value='submit'></td>
                </tr>
                <tr>
                    <td><h3><a href='index.php'>login ?</a></h3></td>
                </tr>
              </table>
            </form>
           </center>
        </div>

      </body>
</html>
