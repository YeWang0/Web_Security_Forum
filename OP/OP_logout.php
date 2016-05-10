<?php
    session_start();
    
    $_SESSION['ip']=null;
    $_SESSION["logged_in"] = false;
    $_SESSION["username"] = null;
    $_SESSION["role"]=null;
    echo '{"status" : "success"}';
    
?>
