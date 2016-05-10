<!DOCTYPE html>
<html>
    <head>
        <link href="/style/bootstrap.min.css" rel="stylesheet">
        <link href="/style/bootstrap-theme.min.css" rel="stylesheet">
        <link href="/style/mystyles.css" rel="stylesheet">
        <link href="/style/font-awesome.min.css" rel="stylesheet">
        <link href="/style/bootstrap-social.css" rel="stylesheet">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <!--<meta name="google-signin-client_id" content="407701602385-q005efm7k49t4up3mjbeu55p0in6lkon.apps.googleusercontent.com">-->
        <!--<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>-->
    
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        
	    <div class="container">
    		<div class="navbar-header ">
    		    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
                </button>
			<a class="navbar-brand" href="#">Web Security Forum</a>
            </div>
            <div class="navbar-collapse collapse">
    				<ul class="nav navbar-nav">
    					 <li class="active"><a href="/UI/success.php"><span class="glyphicon glyphicon-home"
                             aria-hidden="true"></span> Home</a></li>
    					<li><a href="/UI/topics.php">Topics</a></li>
    					
    					<li><a href="mailto:wangye@udel.edu">Contact</a></li>
    				</ul>
				<div class="user_info">
                    <?php
                        session_start();
                        // if(($_GET['type']=='google')){
                        //     $_SESSION['username']=$_GET['name'];
                        //     $_SESSION['type']='google';
                        //     $_SESSION['role']='user';
                        // }
                        {
                            if(!$_SESSION['ip']){
                                $_SESSION['ip']= $_SERVER['REMOTE_ADDR']; 
                            }
                            else{
                                $x=explode('.',$_SESSION['ip']);
                                $y=explode('.',$_SERVER['REMOTE_ADDR']);
                                if(!($x[0]==$y[0] and $x[1]==$y[1] and $x[2]==$y[2]) ){
                                    
                                    $_SESSION['username']=null;
                                    $_SESSION["logged_in"] = false;
                                    header("Location: login.html");
                                }
                            }
                            if($_SESSION['username']!=null)
                                echo "<span>Welcome! ".$_SESSION["username"]."<span>";
                            else {
                                header("Location: login.html");
                            }
                        }
                    ?>
            
                <button onclick="logout()"class="btn btn-default" >Logout!</button>
                </div>
    		</div>     

        </div>
        </nav>
        <header class="jumbotron">
        <div class="container">
            <div class="row row-header">
                <div class="col-xs-12 col-sm-10">
                    <h1>Web Security Forum</h1>
                    <p style="padding:40px;"></p>
                    <p>As technology changes, it becomes more and more challenging to keep information secure on the web. These tips will increase your chances to keep hackers and cyber-thieves at bay. </p>
                </div>
                <div>
                	
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">
        <div class="row row-content">
            <div class="col-xs-12 col-sm-8">
                <span>Join the Web Security Forum!&nbsp;</span>
                <button onclick='location.href = "/UI/topics.php";' class="btn btn-default">Click me!</button>
            </div>
            <div class="col-xs-12 col-sm-4">
                <span>Want to change your password?&nbsp;</span>
                <?php
                    if ($_GET['type']=='google'){
                        echo "Google user don't need to use password";
                    }
                    else{
                        echo "<button onclick=change_password() class='btn btn-default'>Click me!</button>";
                    }
                ?>
            </div>
        </div>
    </div>    
        
        
        
        
      <script>
            function change_password(){
                window.location.href = "change_password.php";
            }
            
            // function signOut() {
            //   var auth2 = gapi.auth2.getAuthInstance();
            //   auth2.signOut().then(function () {
            //     console.log('User signed out.');
            //   });
            // }
        
            // function onLoad() {
            //     alert('yes');
            //   gapi.load('auth2', function() {
            //     gapi.auth2.init();
            //   });
            // }
        </script>
        
        <script type="text/javascript" >
   
            function logout(){
                // signOut();
            
                $.post( "/OP/OP_logout.php", function( data ) {
                        var r=$.parseJSON(data);
                        if(r.status=='success'){
                            window.location.href = "login.html";
                        }
                        
                        else{
                            alert('error');
                        }
                });
            }
        </script>
    </body>
</html>

