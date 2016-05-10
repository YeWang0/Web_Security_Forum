<?php
    include './hash_methods.php';
    
    $username=$_POST['username'];
    $salt = openssl_random_pseudo_bytes(40, $was_strong);
    $pwd =$_POST['password'];// no need to store
    $r=rand(2000, 10000);
    $secure_pwd=hash_m3($pwd,$salt,$r);
    
    $dbhandle = new PDO("sqlite:../database/rbac.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    $statement = $dbhandle->prepare("SELECT salt,stretch,hash FROM users WHERE username=:username");
    $statement->bindParam(":username", $username,PDO::PARAM_STR);
    $statement->execute();
    $results1 = $statement->fetch(PDO::FETCH_ASSOC);
    
    
    if (!$results1){
      $statement = $dbhandle->prepare("INSERT INTO users ('username','hash','salt','stretch','role_id') 
                                     VALUES('".$username."','".$secure_pwd."','".bin2hex($salt)."','".$r."','4')");
      $statement->execute();
      $results2 = $statement->fetch(PDO::FETCH_ASSOC);
    //   echo json_encode($results2);
        // print("success");
        header("Location: /UI/login.html?register_success=1");
    }
    else{
        // print('user exist');
        header("Location: /UI/register.html?register_success=0");
    }
?>