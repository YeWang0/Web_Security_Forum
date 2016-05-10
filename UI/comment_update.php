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
            $statement = $dbhandle->prepare("select * from comments where id='".$update_id."'");
            $statement->execute();
            $results = $statement->fetch(PDO::FETCH_ASSOC);
            echo '<div class="container">';
            echo '<h2>Update Comment</h2>';
            echo '<div class="row row-content"><div class="col-xs-12 col-sm-10 col-sm-push-1">';
            echo '<form action="/OP/OP_comments.php" method="post">';
            echo '<textarea rows="4" style="width:100%" name="comment" required>'.$results['content'].'</textarea>';
            echo '<input type="hidden" name="update_id"  value="'.$update_id.'" >';
            echo '<input type="hidden" name="post_id"  value="'.$results['post_id'].'" >';
            echo '<input type="submit" class="btn btn-success" style="float:right" value="Update">';
            echo '</form>';
            echo '</div></div></div>';
      ?>
      </body>
      <script type="text/javascript">
            function access_control(){
                   $.post("../OP/Access_control.php",{'object':'comment','operation':'update'}, function(data) {
                  if(data!='true'){
                      alert('Permission denied');
                      window.history.go(-1);
                  //     window.location.href = "/UI/topics.php";
                  }
                });
            }
      </script>
</html>