<?php
   session_start();
   $user_name=$_SESSION["username"];
   $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
   if (!$dbhandle) die ($error);
   
   $delete_id=$_GET["delete_id"];
   $update_id=$_POST["update_id"];
   $op=$_POST["op"];
   if ($delete_id!=null){
      $post_id=$_GET["post_id"];
      $statement = $dbhandle->prepare("delete from comments where id=:delete_id");
      $statement->bindParam(":delete_id", $delete_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      header("Location: /UI/comments.php?post_id=".$post_id);
   }
   elseif($update_id!=null){
      $content = $_POST["comment"];
      $post_id=$_POST["post_id"];
      // echo "UPDATE topics SET name='".$topicname."', describe='".$describe."' where id='".$update_id."'";
      $statement = $dbhandle->prepare("UPDATE comments SET content=:content where id=:update_id");
      $statement->bindParam(":content", $content);
      $statement->bindParam(":update_id", $update_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      header("Location: /UI/comments.php?post_id=".$post_id);
   }
   
   elseif($op=='add') {
      $content = $_POST["comment"];
      $post_id=$_POST["post_id"];
      if ($content!=null){
         $statement = $dbhandle->prepare("insert into comments(user_name,content,post_id) 
                                           VALUES(:user_name,:content,:post_id)");
         $statement->bindParam(":user_name", $user_name);
         $statement->bindParam(":content", $content);
         $statement->bindParam(":post_id", $post_id);
         $statement->execute();
         $results = $statement->fetch(PDO::FETCH_ASSOC);
      } 
   
      header("Location: /UI/comments.php?post_id=".$post_id);
   }
?>