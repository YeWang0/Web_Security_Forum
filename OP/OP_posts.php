<?php
   session_start();
   $user_name=$_SESSION["username"];
   $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
   if (!$dbhandle) die ($error);
   
   $delete_id=$_GET["delete_id"];
   $update_id=$_POST["update_id"];
   $op=$_POST["op"];
   if ($delete_id!=null){
      $topic_id=$_GET["topic_id"];
      $statement = $dbhandle->prepare("delete from posts where id=:delete_id");
      $statement->bindParam(":delete_id", $delete_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      header("Location: /UI/posts.php?topic_id=".$topic_id);
   }
   elseif($update_id!=null){
      $title = $_POST["post_title"];
      $content = $_POST["post_content"];
      $topic_id=$_POST["topic_id"];
      // echo "UPDATE topics SET name='".$topicname."', describe='".$describe."' where id='".$update_id."'";
      $statement = $dbhandle->prepare("UPDATE posts SET title=:title,content=:content where id=:update_id");
      $statement->bindParam(":title", $title);
      $statement->bindParam(":content", $content);
      $statement->bindParam(":update_id", $update_id);
      $statement->execute();
      $results = $statement->fetch(PDO::FETCH_ASSOC);
      header("Location: /UI/posts.php?topic_id=".$topic_id);
   }
   
   elseif($op=='add') {
      $title = $_POST["post_title"];
      $content = $_POST["post_content"];
      $topic_id=$_POST["topic_id"];
      if ($title!=null and $content!=null){
         $statement = $dbhandle->prepare("insert into posts(user_name,title,content,topic_id) 
                                           VALUES(:user_name,:title,:content,:topic_id)");
         $statement->bindParam(":user_name", $user_name);
         $statement->bindParam(":title", $title);
         $statement->bindParam(":content", $content);
         $statement->bindParam(":topic_id", $topic_id);
         $statement->execute();
         $results = $statement->fetch(PDO::FETCH_ASSOC);
      } 
   
      header("Location: /UI/posts.php?topic_id=".$topic_id);
   }
?>