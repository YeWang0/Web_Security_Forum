<?php
   session_start();
   include '../OP/hash_methods.php';
   $username = $_POST["username"];
   $pwd = $_POST["password"];
   
   //get salt and r from db
   
   $dbhandle = new PDO("sqlite:../database/rbac.sqlite") or die("Failed to open DB");
   if (!$dbhandle) die ($error);
   $statement = $dbhandle->prepare("SELECT id,salt,stretch,hash,role_id FROM users WHERE username=:username");
   $statement->bindParam(":username", $username,PDO::PARAM_STR);
   $statement->execute();
   $results = $statement->fetch(PDO::FETCH_ASSOC);
   // echo ($results);
   $salt=$results['salt'];
   $r=$results['stretch'];
   $user_id=$results['id'];
   $role_id=$results['role_id'];
   $secure_pwd=$results['hash'];
   // echo hex2bin($salt);
   // echo $r;
   // echo $secure_pwd;
   if($secure_pwd==hash_m3($pwd,hex2bin($salt),$r)){
      $_SESSION["logged_in"] = true;
      $_SESSION["username"] = $username;
      
      $statement = $dbhandle->prepare("SELECT role FROM roles WHERE id=:role_id");
      $statement->bindParam(":role_id", $role_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      $_SESSION["role"]=$results['role'];
      
      header("Location: /UI/success.php");
      exit();
   } else {
      $_SESSION["logged_in"] = false;
      header("Location: /UI/login.html?error=1"); /* Redirect browser */
      exit();
   }
?>