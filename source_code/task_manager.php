<?php
      if(isset($_POST['admin'])){
        header('Location: admin_index.php?');
        return ;
      }else if(isset($_POST['member'])){
            header('Location: index.php?');
            return;
      }
?>
<html>
      <head>
            <title>Task Manager</title>
            <link href='style_file_1.css' rel='stylesheet'>
      </head>
      <body style="background-color:#C4DF9D;">
        <div style='background-color:#C4DF9D;'class="card">
            <div class="card-body">
                <center><h1>Welcome</h1></center>
            </div>
        </div>
        <hr>
        <center>
            <h1>Select Role</h1>
            <hr>
            <form method='post'>
                <input style='font-size: 20px' type='submit' value='Admin' name='admin'><br><br><br>
                <input style='font-size: 20px'  type='submit' value='Group Member' name='member'>
            </form>
            <hr>
          </center>
      </body>
</html>
