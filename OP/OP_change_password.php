<?php
    
    session_start();  
    $newpw=$_POST['password'];
    // echo $newpw;
    
    include './hash_methods.php';
    if($_SESSION['username']!=null){
        $username=$_SESSION['username'];
    $salt = openssl_random_pseudo_bytes(40, $was_strong);
    $pwd =$_POST['password'];// no need to store
    $r=rand(2000, 10000);
    $secure_pwd=hash_m3($pwd,$salt,$r);
    
    $dbhandle = new PDO("sqlite:../database/rbac.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    $statement = $dbhandle->prepare("UPDATE users 
            SET hash='".$secure_pwd."', salt='".bin2hex($salt)."',stretch='".$r."'"
            ."WHERE username=:username");
    $statement->bindParam(":username", $username);
    $statement->execute();
    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['username']=null;
    header("Location: /UI/login.html?password_reset=1");
    }else
    header("Location: /UI/login.html?password_reset=0");
?>