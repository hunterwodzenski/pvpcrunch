<?php
session_start();

/*
error_reporting(E_ALL);
ini_set('display_error', 1);
*/

#check if User is logged in
if(isset($_SESSION['id'])) {
	#logic
} else {
    #redirect User to Login
    header('Location: login.php');
    echo 'You must be signed in to view this page!';
    die();
}

function display_error() {
$error = $_SESSION['err'];
echo <<<DOC
	document.getElementById("sub").innerHTML = "We've encountered a{$error} error.";
DOC;
}
?>
<html>
	<!--Copyright 2017 PvPCrunch-->
	<head>
		<meta name="copyright" content="PvPCrunch">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">

	    <!--Fonts-->
	    <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">

	    <!--Navigation Style-->
	    <link rel="stylesheet" type="text/css" href="navbar.css" />
		<style>
		     html, body {padding: 0; margin: 0;}

		     body {
		         background: #000 url(images/error_amumu_background.jpg);
		         background-size: cover;
		         background-position: center;
		         background-attachment: fixed;
		     }
		     #main {
		     	width: 100%;
		     	height: 92.5%;
		     	display: -webkit-box;
		     	display: -ms-flexbox;
		     	display: flex;
		     	-webkit-box-align: center;
		     	    -ms-flex-align: center;
		     	        align-items: center;
		     	-webkit-box-pack: center;
		     	    -ms-flex-pack: center;
		     	        justify-content: center;
		     	-webkit-box-orient: vertical;
		     	-webkit-box-direction: normal;
		     	    -ms-flex-flow: column nowrap;
		     	        flex-flow: column nowrap;
		     }
		     	#code {
		     		-webkit-box-flex: 3;
		     		    -ms-flex: 3;
		     		        flex: 3;
		     		width: 100%;
		     		height: 100%;
		     		display: -webkit-box;
		     		display: -ms-flexbox;
		     		display: flex;
		     		-webkit-box-align: end;
		     		    -ms-flex-align: end;
		     		        align-items: flex-end;
		     		-webkit-box-pack: center;
		     		    -ms-flex-pack: center;
		     		        justify-content: center;
		     		font-size: calc(4em + 7.5vmax);
		     		font-weight: 900;
		     		color: rgba(240, 150, 65, 0.75);
		     	}
		     	#sub {
		     		-webkit-box-flex: 2;
		     		    -ms-flex: 2;
		     		        flex: 2;
		     		width: 100%;
		     		height: 100%;
		     		display: -webkit-box;
		     		display: -ms-flexbox;
		     		display: flex;
		     		-webkit-box-align: center;
		     		    -ms-flex-align: center;
		     		        align-items: center;
		     		-webkit-box-pack: center;
		     		    -ms-flex-pack: center;
		     		        justify-content: center;
		     		font-size: calc(3em + 2vmax);
		     		font-weight: 900;
		     		color: rgba(240, 150, 65, 0.75);
		     	}
		</style>
		<script type="text/javascript">
			window.onload = function() {
				<?php display_error(); ?>
			}
		</script>
	</head>
	<body>
	    <header id="site-header">
	          <div>
	            <ul>
	                <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Dashboard</a></li>
	                <li><a style="font-family: 'Righteous', cursive;" href="recents.php" style="color: gray; text-decoration: overline;">Recents</a></li>
	                <li><a style="font-family: 'Righteous', cursive;" href="playercard.php">Playercard</a></li>
	                <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Game&nbsp;Info</a></li>
	                <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">PB&nbsp;Analytics</a></li>
	                <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Developer</a></li>
	                <li><a style="font-family: 'Righteous', cursive;" href="user.html">User</a></li>
	            </ul>
	          </div>
	    </header>
	    <div id="main">
		    <div id="code">
		    	Sorry...
		    </div>
		    <div id="sub">!</div>
	    </div>
	</body>
</html>
