<?php
require_once('pdo.php')
?>
<?php
      session_start();
      if(isset($_POST['submit'])){
         if(strlen($_POST['username'])<1 || strlen($_POST['password'])<1 || strlen($_POST['security_question'])<1 || strlen($_POST['answer'])<1){
            $_SESSION['error']='Please Fill All the details';
            header('Location: sign_up.php?');
            return ;
         }else{
           $sql="SELECT password FROM user where username = :username";
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(
               ':username' => $_POST['username']));
           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if(!empty($rows)){
                $_SESSION['error']="Username Already Exist";
                header('Location: sign_up.php?');
                return;
              }else{
                    $sql = "INSERT INTO user (username, password, security_question, answer)
                          VALUES (:username,:password ,:security_question, :answer)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':username' => $_POST['username'],
                        ':password' => $_POST['password'],
                        ':security_question' => $_POST['security_question'],
                        ':answer' => $_POST['answer']));
                   header('Location: index.php?');
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
                 <td>Security Question</td><td><input type='text' name='security_question'></td>
                </tr>
                <tr>
                  <td>Answer</td><td><input type='text' name='answer'></td>
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
