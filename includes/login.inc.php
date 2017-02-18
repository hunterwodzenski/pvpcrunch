<?php
session_start();

#require redis dependancy
require $_SERVER['DOCUMENT_ROOT'].'/vendor/colinmollenhour/credis/Client.php';

#get remote address
$uip = $_SERVER['REMOTE_ADDR'];

#sanitize ip
if(!filter_var($uip, FILTER_VALIDATE_IP)) {

	#redirect to login
	header('Location: ../login.php');
	die();

}

#build redis login attemot key
$ipid = "login-attempt:".$uip;

#get user input values
$uid = $_POST['Luid'];
$pwd = $_POST['Lpwd'];

#attempt constants
const ATTEMPT_LIMIT = 10;
const ATTEMPT_LOCKOUT = 600; //10 minutes

#create redis/credis instance for remote address
$redis = new Credis_Client('localhost'); 

#run rate-limit.inc.php login process
function login_attempt($uid, $pwd) {

	#mysql database connect
	$host = 'localhost';
	$db = 'userdb';
	$user = 'root';
	$pass = '33KwO8cH88';
	$charset = 'utf8';
	$opts = [
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false	
	];
	$conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $opts);

	#construct query
	$query = "SELECT uid, pwd FROM usert WHERE uid = :uid";

	#prepare statement
	$chk = $conn->prepare($query);
	$chk->bindParam(':uid', $uid);

	#execute query
	$chk->execute();

	#Check if username exists
	if($chk->rowCount() > 0){

		#override chk with the values returned in the row
		$chk =  $chk->fetch();

		#check if password matches specified username
		if(password_verify($pwd, $chk["pwd"])) {

			#fetch id, region, and summonerid from database and store them in session
			#construct query
			$sess_query = "SELECT id, rgn, sid FROM usert WHERE uid=:uid";

			#prepare statement
			$statement = $conn->prepare($sess_query);
			$statement->execute(array(':uid' => $uid));

			#fetch values
			$row = $statement->fetch();
			$Rid = $row[0];
			$Rrgn = $row[1];
			$Rsid = $row[2];

			#store fetched values in session
			$_SESSION['id'] = $Rid;
			$_SESSION['rgn'] = $Rrgn;
			$_SESSION['sid'] = $Rsid;

			#Redirect to recents page
			header('Location: ../recents.php');
			die();

		} else {

			#redirect to login page
			header('Location: ../login.php');
			die();

		}

	} else {

		#redirect to login page
		header('Location: ../login.php');
		die();

	}

	#close mysql database connection
	$conn = null;

}

#check if user has a running counter
if($redis->exists($ipid)) {

	#ensure login attempt counter is under failed attempt limit
	if($redis->get($ipid) < ATTEMPT_LIMIT) {

		#increment address redis key toward limit
		$redis->incr($ipid);

		#try to login!
		login_attempt($uid, $pwd);

	} else {
		#redirect to login page
		header('Location: ../login.php');
		die();
		//let user know they have to wait and try again later because of failed attempts.

	}

} else {

	#initialize redis key with TTL
	$redis->setex($ipid, ATTEMPT_LOCKOUT, '0');

	#try to login!
	login_attempt($uid, $pwd);

}
?>
