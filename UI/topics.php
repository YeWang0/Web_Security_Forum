<!DOCTYPE html>
<html>
    <head>
        <title>Topics</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    </head>
    
    <body>
        <?php include ("navbar.php"); ?>
        <div class="container">
        <div class="row row-content">
        
            <h1>Topic list</h1>
        <div class="col-xs-12 col-sm-2 col-sm-push-10 ">
            <button id='create' class="btn btn-primary" onclick="add_topic()" >Add new topic</button>
        </div>
            <div class="col-xs-12 col-sm-12">
            <form id="add-topic" style="display: none;" action="/OP/OP_topics.php" method="post">
    		      Name: <br>
    		      <input type="text" style="width:100%"name="topicname" placeholder="topic name..." required></input>
    		      <input type="hidden" name="op" value="add"/><br>
    		      
    		      Describe: <br>
    		      <textarea rows="4" style="width:100%" name="describe" >Enter describe here...</textarea><br>
    		      <input type="submit" class='btn btn-success' style="float:right"value="Add"/>
    		      <br><br>
    		</form>
		    <br>
		    </div>
        </div>
        
        
        <div class="container">
        <?php
            $dbhandle = new PDO("sqlite:../database/forum.sqlite") or die("Failed to open DB");
            if (!$dbhandle) die ($error);
            $query ='select * from topics';
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($results as $topic){
                echo '<div class="row row-content">';
                echo '<h3>'.htmlspecialchars($topic[name], ENT_QUOTES, 'UTF-8').'</h3>';
                echo '<pre>'. htmlspecialchars($topic[describe], ENT_QUOTES, 'UTF-8').'</pre>'; 
                echo '<div class="col-xs-12 col-sm-1">';
                echo "<button class='btn btn-link' onclick='read_posts(this)' value=".$topic[id].">More</button>";
                echo '</div>';
                echo '<div class="col-xs-12 col-sm-1 col-sm-push-9">';
                echo "<button class='btn btn-danger' onclick='delete_topic(this)' value=".$topic[id].">Delete</button>";
                echo '</div>';
                echo '<div class="col-xs-12 col-sm-1 col-sm-push-9">';
                echo "<button class='btn btn-info' onclick='update_topic(this)' value=".$topic[id].">Update</button>";
                echo '</div>';
                echo '</div>';
            }
            
        ?>
        
        <?php
                session_start();
                if($_SESSION["role"]=='moderator' or $_SESSION["role"]=='admin'){
                    echo '<br><button  class="btn btn-info" onclick="status_revoke()" >Revoke author status</button><br><br>';
                }
            ?>
		</div>
		</div>
		<script type="text/javascript">
		    function status_revoke(){
		        window.location.href ="/UI/status_revoke.php";
		    }
		    function add_topic(){
		       //add ajax 
		       $.post("../OP/Access_control.php",{'object':'topic','operation':'create'}, function(data) {
                  if(data=='true'){
                      $('#add-topic').toggle();
                  }
                  else{
                      alert('Permission denied');
                  }
               });
            }
            
            function delete_topic(input){
                $.post("../OP/Access_control.php",{'object':'topic','operation':'delete'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/OP/OP_topics.php?delete_id="+$(input).val();
                  }
                  else{
                      alert('Permission denied');
                  }
               });
            }
            function update_topic(input){
                $.post("../OP/Access_control.php",{'object':'topic','operation':'update'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/UI/topic_update.php?update_id="+$(input).val();
                  }
                  else{
                      alert('Permission denied');
                  }
                });
            }
            function read_posts(input){
                $.post("../OP/Access_control.php",{'object':'post','operation':'read'}, function(data) {
                  if(data=='true'){
                      window.location.href = "/UI/posts.php?topic_id="+$(input).val();
                  }
                  else{
                      alert('Permission denied');
                  }
                });
            }
		</script>
    </body>
</html>