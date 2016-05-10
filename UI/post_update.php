<!DOCTYPE html>
<html>
      <head>
            <title>Post Update</title>
      </head>
      
      <body onload='access_control()'>
            <?php include ("navbar.php"); ?>   
            <?php
                  session_start();
                  $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
                  if (!$dbhandle) die ($error);
               
                  $update_id=$_GET["update_id"];
                  $statement = $dbhandle->prepare("select * from posts where id='".$update_id."'");
                  $statement->execute();
                  $results = $statement->fetch(PDO::FETCH_ASSOC);
                  echo '<div class="container">';
                  echo '<h2>Update Post</h2>';
                  echo '<div class="row row-content"><div class="col-xs-12 col-sm-10 col-sm-push-1">';
                  echo '<form action="/OP/OP_posts.php" method="post">';
                  echo 'Title: <br><input type="text" style="width:100%" name="post_title" placeholder="title..." value="'.$results["title"].'" required>';
                  echo '<input type="hidden" name="update_id"  value="'.$update_id.'" >';
                  echo '<input type="hidden" name="topic_id"  value="'.$results['topic_id'].'" >';
                  echo '<br>Content: <br><textarea rows="4" style="width:100%" name="post_content" required>'.$results["content"].'</textarea>';
                  echo '<input type="submit" class="btn btn-success" style="float:right" value="Update">';
                  echo '</form>';
                  echo '</div></div></div>';
            ?>
      </body>
      <script type="text/javascript">
            function access_control(){
                   $.post("../OP/Access_control.php",{'object':'post','operation':'update'}, function(data) {
                  if(data!='true'){
                      alert('Permission denied');
                      window.history.go(-1);
                  //     window.location.href = "/UI/topics.php";
                  }
                });
            }
      </script>
</html>