<?php
    $user_name=$_POST['username'];
    $dbhandle = new PDO("sqlite:../database/rbac.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    $query ="update users SET role_id=4 where username=:user_name and role_id=2";
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(":user_name", $user_name);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo 'done';
?>