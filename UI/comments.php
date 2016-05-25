<!DOCTYPE html>
<html>
    <head>
        <title>Comments</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
    </head>
    <body>
        
        
        
        <?php include ("navbar.php"); ?>
        <div class="container">
        <h1>Commet list</h1>
        <div class="row row-content">
            <div class="col-xs-12 col-sm-2 col-sm-push-10">
            <button onclick="add_comment()" class="btn btn-primary">Add new comment</button>
            </div>
            
            <div class="col-xs-12 col-sm-12">
            <form id="add-comment" style="display: none;" action="/OP/OP_comments.php" method="post">
    		      Comment: <br><textarea rows="4" style="width:100%"  name="comment" >Enter comment here...</textarea>
    		      <input type="hidden" name="op" value="add"/>
    		      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
    		      <input type="submit" class="btn btn-success " style="float:right" value="Add"/>
    		</form>
		    </div>
	    </div>
        <?php
            $post_id=$_GET['post_id'];
            
            $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
            if (!$dbhandle) die ($error);
            
            $query ='select * from comments where post_id="'.$post_id.'"';
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $comment){
                echo '<div class="row row-content">';
                echo '<pre>'.htmlspecialchars($comment[content], ENT_QUOTES, 'UTF-8').'</pre>';
                echo '<p style="float:right">By:'.$comment[user_name].'</p><br>';
                echo '<div class="col-xs-12 col-sm-1 col-sm-push-10">';
                echo "<button class='btn btn-danger' onclick='delete_comment(this,".$post_id.")' value=".$comment[id].">Delete</button>";
                 echo '</div>';
                echo '<div class="col-xs-12 col-sm-1 col-sm-push-10">';
                echo "<button class='btn btn-info' onclick='update_comment(this)' value=".$comment[id].">Update</button>";
                echo '</div>';
                echo '</div>';
            }
        ?>
        
		<script type="text/javascript">
		    function add_comment(){
               $.post("../OP/Access_control.php",{'object':'comment','operation':'create'}, function(data) {
                  if(data=='true'){
                      $('#add-comment').toggle();
                  }
                  else{
                      alert('Permission denied');
                  }
               });
            }
            function delete_comment(input,post_id){
                $.post("../OP/Access_control.php",{'object':'comment','operation':'delete'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/OP/OP_comments.php?delete_id="+$(input).val()+"&post_id="+post_id;
                  }
                  else{
                      alert('Permission denied');
                  }
               });
            }
            function update_comment(input){
                $.post("../OP/Access_control.php",{'object':'comment','operation':'update'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/UI/comment_update.php?update_id="+$(input).val();
                  }
                  else{
                      alert('Permission denied');
                  }
                });
            }
		</script>
        
    </body>
</html>