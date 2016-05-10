<!DOCTYPE html>
<html>
      <head>
            <title>Status Revoke</title>
      </head>
      
      <body onload=access_control()>
      <?php include ("navbar.php"); ?>  
      <?php
            session_start();
            $dbhandle = new PDO("sqlite:../database/rbac.sqlite") or die("Failed to open DB");
            if (!$dbhandle) die ($error);
            
            $query ="select username from users US left outer join roles RL where US.role_id=RL.id and RL.role='author' ";
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            echo '<div class="container">';
            echo '<h2>Author list</h2>';
            echo '<div class="row row-content">';
            // echo count($results);
            foreach ($results as $author){
                echo '<div class="col-xs-12 col-sm-5 col-sm-push-1">';
                echo '<span>'.$author['username'].'</span>';
                echo '</div>';
                echo '<div class="col-xs-12 col-sm-3 col-sm-push-3">';
                echo "<button value='revoke' onclick=revoke_status('".$author['username']."')>Revoke</button><br><br>";
                echo '</div>';
                  
            }
            
            echo '</div></div>';
      ?>
      
      </body>
      <script type="text/javascript">
            function access_control(){
                   $.post("../OP/Access_control.php",{'object':'author','operation':'revoke'}, function(data) {
                  if(data!='true'){
                      alert('Permission denied');
                      window.history.go(-1);
                  //     window.location.href = "/UI/topics.php";
                  }
                });
            }
            function revoke_status(username){
                  alert(username);
                  $.post("../OP/OP_revoke.php",{'username':username},function(data){
                        window.location.reload();
                  })
            }
      </script>
</html>