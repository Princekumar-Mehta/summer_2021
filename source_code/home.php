<?php
require_once('pdo.php');
?>
<?php
session_start();
  if(!isset($_SESSION['username'])){
      $_SESSION['error']='To access this site, Please login';
      header('Location: index.php?');
      return ;
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
                  <center><h1>Welcome <?=$_SESSION['username']?></h1></center>
              </div>
          </div>
          <ul>
              <li>
                  <a  aria-current="page" href="home.php">Home</a>
              </li>
              <li>
                  <a  aria-current="page" href="index.php">login</a>
              </li>
              <li>
                  <a aria-current="page" href="sign_up.php">Sign Up</a>
              </li>
              <li>
                  <a  aria-current="page" href="logout.php">Logout</a>
              </li>
          </ul>
      <!--    <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="container-fluid">
                  <div class="collapse navbar-collapse navbar-default" id="navbarSupportedContent">
                      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                          <li class="nav-item">
                              <a class="hover_item nav-link active" aria-current="page" href="home.php">Home</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="index.php">login</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="sign_up.php">Sign Up</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
                          </li>
                      </ul>
                </div>
            </div></nav>-->
    </body>
</html>
