<!DOCTYPE html>
<html>
    <head>
        <title>Posts</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
    </head>
    <body>
        <?php include ("navbar.php"); ?>
        <div class="container">
        <div class="row row-content">
            <h1>Post list</h1>
            <div class="col-xs-12 col-sm-2 col-sm-push-10 ">
            <button onclick="add_post()" class="btn btn-primary">Add new post</button>
            </div>
            <div class="col-xs-12 col-sm-12">
                <form id="add-post" style="display: none;" action="/OP/OP_posts.php" method="post">
        		      <input type="hidden" name="op" value="add"/>
        		      <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>"/>
        		      Title: <br> <input type="text" style="width:100%" name="post_title" placeholder="title..." required></input><br><br>
        		      
        		      Content: <br><textarea rows="4" style="width:100%" name="post_content" >Enter content here...</textarea>
        		      <input type="submit" class='btn btn-success' style="float:right" value="Add"/>
        		</form><br>
    		</div>
		</div>
		</div>
		</div>
        <div class="container">
        <?php
            $topic_id=$_GET['topic_id'];
            
            $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
            if (!$dbhandle) die ($error);
            
            $query ='select * from posts where topic_id="'.$topic_id.'"';
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $post){
                 echo '<div class="row row-content">';
                echo '<h3>'.$post[title].'</h3>';
                echo '<pre>'.$post[content].'</pre>';
                echo '<p style="float:right"> Author: '.$post[user_name].'</p><br>';
                echo '<div class="col-xs-12 col-sm-1">';
                echo "<button class='btn btn-link' onclick='read_comments(this)' value=".$post[id].">Comments</button>";
                echo '</div>';
                echo '<div class="col-xs-12 col-sm-1 col-sm-push-9">';
                echo "<button class='btn btn-danger' onclick='delete_post(this,".$topic_id.")' value=".$post[id].">Delete</button>";
                echo '</div>';
                echo '<div class="col-xs-12 col-sm-1 col-sm-push-9">';
                echo "<button class='btn btn-info' onclick='update_post(this)' value=".$post[id].">Update</button>";
                echo '</div>';
                echo '</div>';
            }
        ?>
        
		<script type="text/javascript">
		    function add_post(){
               $.post("../OP/Access_control.php",{'object':'post','operation':'create'}, function(data) {
                  if(data=='true'){
                      $('#add-post').toggle();
                  }
                  else{
                      alert('Permission denied');
                  }
               });
            }
            function delete_post(input,topic_id){
                $.post("../OP/Access_control.php",{'object':'post','operation':'delete'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/OP/OP_posts.php?delete_id="+$(input).val()+"&topic_id="+topic_id;
                  }
                  else{
                      alert('Permission denied');
                  }
               });
            }
            function update_post(input){
                $.post("../OP/Access_control.php",{'object':'post','operation':'update'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/UI/post_update.php?update_id="+$(input).val();
                  }
                  else{
                      alert('Permission denied');
                  }
                });
            }
            function read_comments(input){
                $.post("../OP/Access_control.php",{'object':'comment','operation':'read'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/UI/comments.php?post_id="+$(input).val();
                  }
                  else{
                      alert('Permission denied');
                  }
                });
            }
		</script>
        
    </body>
</html>