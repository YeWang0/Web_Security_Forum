<?php
   session_start();
   $user_name=$_SESSION["username"];
   
   $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
   if (!$dbhandle) die ($error);
   
   $delete_id=$_GET["delete_id"];
   $update_id=$_POST["update_id"];
   $op=$_POST['op'];
   if ($delete_id!=null){
      $statement = $dbhandle->prepare("delete from topics where id=:delete_id");
      $statement->bindParam(":delete_id", $delete_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      header("Location: /UI/topics.php");
   }
   elseif($update_id!=null){
      $username=$_SESSION["username"];
      $topicname = $_POST["topicname"];
      $describe = $_POST["describe"];
      // echo "UPDATE topics SET name='".$topicname."', describe='".$describe."' where id='".$update_id."'";
      $statement = $dbhandle->prepare("UPDATE topics SET name=:topicname, describe=:describe where id=:update_id");
      $statement->bindParam(":topicname", $topicname);
      $statement->bindParam(":describe", $describe);
      $statement->bindParam(":update_id", $update_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      header("Location: /UI/topics.php");
   }
   
   elseif($op=='add') {
      $topicname = $_POST["topicname"];
      $describe = $_POST["describe"];
      if ($topicname!=null and $describe!=null){
         $statement = $dbhandle->prepare("insert into topics(user_name,name,describe) 
                                           VALUES(:user_name,:topicname,:describe)");
         $statement->bindParam(":topicname", $topicname);
         $statement->bindParam(":describe", $describe);
         $statement->bindParam(":user_name", $user_name);
         $statement->execute();
         $results = $statement->fetch(PDO::FETCH_ASSOC);
      } 
      
      header("Location: /UI/topics.php");
   }
?>