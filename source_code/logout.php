<?php
session_start();
$role = $_SESSION['role'];
echo $role;
session_destroy();
if($role == 'admin'){
  header("Location: admin_index.php?");
}else{
  header("Location: index.php?");
}
?>
