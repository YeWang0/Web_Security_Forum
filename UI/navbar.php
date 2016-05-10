<!DOCTYPE html>
<html>
    <head>
        <link href="/style/bootstrap.min.css" rel="stylesheet">
        <link href="/style/bootstrap-theme.min.css" rel="stylesheet">
        <link href="/style/mystyles.css" rel="stylesheet">
        <link href="/style/font-awesome.min.css" rel="stylesheet">
        <link href="/style/bootstrap-social.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <meta name="google-signin-client_id" content="407701602385-q005efm7k49t4up3mjbeu55p0in6lkon.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
   
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
            <div id="navbar" class="navbar-collapse collapse">
    				<ul class="nav navbar-nav">
    					 <li class="active"><a href="/UI/success.php"><span class="glyphicon glyphicon-home"
                             aria-hidden="true"></span> Home</a></li>
    					<li><a href="/UI/topics.php">Topics</a></li>
    					
    					<li><a href="mailto:wangye@udel.edu">Contact</a></li>
    				</ul>
				<div class="user_info">
                    <?php
                        session_start();
                        
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
                        
                    ?>
            
                <button onclick="logout()"class="btn btn-default btn-sm" >Logout!</button>
                </div>
    		</div>     
        </div>
        </nav>
        
        <script type="text/javascript" >
            // function signOut() {
            //   var auth2 = gapi.auth2.getAuthInstance();
            //   auth2.signOut().then(function () {
            //     console.log('User signed out.');
            //   });
            // }
        
            // function onLoad() {
            //   gapi.load('auth2', function() {
            //     gapi.auth2.init();
            //   });
            // }
            
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

