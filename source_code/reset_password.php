<?php
require_once('pdo.php')
?>
<?php
      session_start();
      if(isset($_POST['submit'])){
         if(strlen($_POST['password'])<1 || strlen($_POST['answer'])<1){
            $_SESSION['error']='Please Fill All the details';
            header('Location: reset_password.php?');
            return ;
         }else{
           $sql="SELECT answer FROM user where username = :username";
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(
               ':username' => $_COOKIE['username']));
           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           print_r($rows);
              if($_POST['answer']!==$rows[0]['answer']){
                $_SESSION['error']="Please Enter Correct answer to reset your password".$rows[0]['answer'];
                header('Location: reset_password.php?');
                return;
              }
              else{
                $sql = "UPDATE user SET password=:password WHERE username=:username";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':password' => $_POST['password'],
                    ':username' => $_COOKIE['username']));
                   header('Location: index.php?');
                   return;
              }
         }
      }

      $sql="SELECT security_question,username FROM user where username = :username";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ':username' => $_COOKIE['username']));
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                 <td>Username</td><td><p><?=htmlentities($rows[0]['username'])?></td></td>
                </tr>
                <tr>
                  <td>Password</td><td><input type='password' name='password'></td>
                </tr>
                <tr>
                 <td>Security Question</td><td><p><?=htmlentities($rows[0]['security_question'])?></td>
                </tr>
                <tr>
                  <td>Answer</td><td><input type='text' name='answer'></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class='button'name='submit' type='submit' value='submit'></td>
                </tr>
                <tr>
                    <td><a href='index.php'>login ?</a></td>
                </tr>
              </table>
            </form>
           </center>
        </div>

      </body>
</html>
