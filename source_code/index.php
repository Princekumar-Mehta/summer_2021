<?php
require_once('pdo.php')
?>
<?php
      session_start();
      if(isset($_POST['submit'])){
         if(strlen($_POST['username'])<1 || strlen($_POST['password'])<1){
            $_SESSION['error']='Please Enter username and password';
            header('Location: index.php?');
            return ;
         }else{
           $sql="SELECT password FROM user where username = :username";
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(
               ':username' => $_POST['username']));
           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if(empty($rows)){
                $_SESSION['error']="Username Doesn't Exist";
                header('Location: index.php?');
                return;
              }
              else if($_POST['password']!==$rows[0]['password']){
                $_SESSION['error']="Invalid Password";
                header('Location: index.php?');
                return;
              }else{
                  $_SESSION['username']=$_POST['username'];
                   header('Location: home.php?');
                   return;
              }
         }
      }else if(isset($_POST['reset_password'])){
        if(strlen($_POST['username'])<1){
           $_SESSION['error']='Enter Username to Reset Password';
           header('Location: index.php?');
           return ;
        }else{
          $sql="SELECT password,user_id FROM user where username = :username";
          $stmt = $pdo->prepare($sql);
          $stmt->execute(array(
              ':username' => $_POST['username']));
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

             if(empty($rows)){
               $_SESSION['error']="Username Doesn't Exist";
               header('Location: index.php?');
               return;
             }else{
               setcookie("username", $_POST['username']);
               setcookie("user_id", rows[0]['user_id']);
               header('Location: reset_password.php?');
               return;
             }
        }
      }
?>

<html>
      <head>
            <title>Prince Mehta</title>
            <link href='my_style1.css' rel="stylesheet">
      </head>
      <body style="background-color:#C4DF9D;">
          <div style='background-color:#C4DF9D;'class="card">
                <div class="card-body">
                    <h1><b><center>Welcome</center></b></h1>
                </div>
          </div>
          <div class='table-responsive border_div padding'>
           <center>
             <?php
                if(isset($_SESSION['error'])){
                    echo("<span style='color:red'>".$_SESSION['error']."</span>");
                    unset($_SESSION['error']);
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
                    <td></td>
                    <td><input class='button'name='submit' type='submit' value='submit'></td>
                </tr>
                <tr>
                    <td><h3><a href='sign_up.php'>Sign Up ?</a></h3></td>
                    <td><input class='button'name='reset_password' style='background-color: #87A492;'type='submit' value='Reset Password'></td>
                </tr>
              </table>
            </form>
           </center>
        </div>

      </body>
</html>
