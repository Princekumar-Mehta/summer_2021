<?php
require_once('pdo.php')
?>
<?php
      session_start();
      if(isset($_POST['submit'])){
         if(strlen($_POST['admin_name'])<1 || strlen($_POST['admin_password'])<1){
            $_SESSION['error']='Please Enter username and password';
            header('Location: admin_index.php?');
            return ;
         }else{
           $sql="SELECT admin_password FROM admin where admin_name = :admin_name";
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(
               ':admin_name' => $_POST['admin_name']));
           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if(empty($rows)){
                $_SESSION['error']="Wrong Admin Name";
                header('Location: admin_index.php?');
                return;
              }
              else if($_POST['admin_password']!==$rows[0]['admin_password']){
                $_SESSION['error']="Invalid Password";
                header('Location: admin_index.php?');
                return;
              }else{
                  $_SESSION['role']='admin';
                  $_SESSION['admin_name']=$_POST['admin_name'];
                  header('Location: admin_home.php?');
                  return;
              }
         }
      }
?>

<html>
      <head>
            <title>GPM- Group Progess Manager</title>
            <link href='style_file_1.css' rel='stylesheet'>
            <style>
                table, th, td{
                  solid black;
                }
            </style>
      </head>
      <body style="background-color:#C4DF9D;">
          <div style='background-color:#C4DF9D;'class="card">
                <div class="card-body">
                    <h1><b><center>Welcome to GPM<br>Admin Login</center></b></h1>
                </div>
          </div>
          <ul>
              <li>
                  <a  aria-current="page" href="index.php">User</a>
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
                if(isset($_SESSION['message'])){
                    echo("<span style='color:green'>".$_SESSION['message']."</span>");
                    unset($_SESSION['message']);
                }
             ?>

            <form method='post'>
              <table class='table'>
                <tr>
                 <td><h2>Admin Name</td><td><h2><input type='text' name='admin_name'></td>
                </tr>
                <tr>
                  <td><h2>Password</td><td><h2><input type='password' name='admin_password'></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class='button'name='submit' type='submit' value='submit'></td>
                </tr>
              </table>
            </form>
           </center>
        </div>

      </body>
</html>
