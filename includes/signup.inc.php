<?php
session_start();

#dbh access
$host = 'localhost';
$db = 'userdb';
$user = 'root';
$pass = '33KwO8cH88';
$charset = 'utf8';
$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false	
];
try {
	$conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $opts);
} catch(PDOException $e) {
	#echo $e;
	header('Location: ../signup.php');
}

#Collect Form Data
//username
$uid = $_POST['Ruid'];
//password
$pwd = $_POST['Rpwd'];
//region
$rgn = strtolower($_POST['Rrgn']);
//summoner name
$sn = $_POST['Rsn'];

#ensure username contains only letters or numbers
if(preg_match('/[^\w\s]/', $uid)) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#set username character limit max to 16 & enforce a character length of atleast 3
if(strlen($uid) >= 16 && strlen($uid) <= 3) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#ensure password only contains letters, numbers..............ADD SPECIAL CHARACTERS, HUNTER!!!
if(preg_match('/[^\w\s]/', $pwd)) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#set password character limit max to 60 & enforce a character length of atleast 6
if(strlen($pwd) >= 60 && strlen($pwd) <= 6) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#Region Index for cross checking user-supplied region
$rgnarr = array('na', 'eune', 'euw', 'jp', 'kr', 'lan', 'las', 'oce', 'ru', 'tr');
#Make sure region variable is one of the preset region values
if(in_array($rgn, $rgnarr) !== true) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#ensure summoner only contains letters, numbers..............CHECK RIOT DEFAULTS FOR SN, HUNTER!!!
if(preg_match('/[^\w\s]/', $sn)) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#check if username already exists in the database
#Construct Query
$query = "SELECT uid FROM usert WHERE uid = :uid";
#Prepare
$chk = $conn->prepare($query);
$chk->bindParam(':uid', $uid);
$chk->execute();
#Check if a username was returned
if($chk->rowCount() > 0) {
	#Redirect user back to signup page
	header('Location: ../signup.php');
	die();
}

#Declare hash options for standard cost and automatic password salting
$hashopts = [
	'cost' => 10,
	'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
#Apply blowfish hash to password and automatically apply the salt
$pwd = password_hash($pwd, PASSWORD_BCRYPT, $hashopts);

#Use SN to Collect SID from RiotAPI
try {
	#Developer Key!
	$key = "RGAPI-a90129ff-a1fb-4d2e-aa9a-f9247c302355";
	#Form Request
	$url = "https://".$rgn.".api.pvp.net/api/lol/".$rgn."/v1.4/summoner/by-name/".$sn."?api_key=".$key;
	#Process Riot Response
	$json = file_get_contents($url);
	$result = json_decode($json);
	//Example Response
	/*{"speqz": {
		"id": 46849930,
		"name": "Speqz",
		"profileIconId": 589,
		"revisionDate": 1482894308000,
		"summonerLevel": 30
		}}
	*/
	#Navigate JSON to get SID
	$lsn = strtolower($sn);
	$sid = $result->$lsn->id;
}
catch(exception $e) {
	#Send Problem Report
	echo "There was a problem verifying your Riot account. The account many not exist, or the Riot servers may be down. Please try again. If the problem persists, try again at a later time.";
	#Redirect user back to signup page
	#header('Location: /pvpcrunch/signup.php');
}

#Format SQL Query
try {
	$query = "
		INSERT INTO usert(
			`uid`,
			`pwd`,
			`rgn`,
			`sn`,
			`sid`
		)
		VALUES('"
			. $uid . "', '"
			. $pwd . "', '"
			. $rgn . "', '"
			. $sn . "', '"
			. $sid .
		"');";
	$query = (string)$query;
	#$stmt = $conn->prepare($query); #conn->exec
	$conn->exec($query);
}
catch(PDOException $e) {
	echo $e->getMessage();
	#Redirect user back to signup page
	#header('Location: /pvpcrunch/signup.php');
}
$conn = null;
header('Location: ../login.php');
?>
