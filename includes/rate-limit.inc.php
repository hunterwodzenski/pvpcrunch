<?php
#REDIS:CREDIS RIOTAPI RATE LIMITER
//@_AUTHOR HUNTER WODZENSKI

#Require Composer Redis Client from Server Root Because of Overlapping Requires
require $_SERVER['DOCUMENT_ROOT'].'/vendor/colinmollenhour/credis/Client.php';

#Default Error String
$_SESSION['err'] = "Unknown"; 

#Rate Limit Constants
const USER_LIMIT = 5; //Lower User Request Limit per Client
const ENFORCED_USER_LIMIT = 10; //Riot Lower Req Limit
const LOWER_SERVER_LIMIT = 10; // Maximum Server-Wide Requests
const UPPER_SERVER_LIMIT = 600; //Overall Request Max

const ENFORCED_USER_TIMEOUT = 10; //User Rate (Seconds)
const ENFORCED_SERVER_TIMEOUT = 10; //Server Rate (Seconds)


const SERVER_TIME = 600; //Server Rate (Seconds)

function request_handler($url) {

	#Get Server Response
	$contents = file_get_contents($url);

	#Separate Headers
	$headers = $http_response_header;

	#Handle Status Codes
	switch(true) {

		#okay
		case strpos($headers[0], '200'):
			#Induce Synthetic Error 
			/*
			$_SESSION['err'] = "400";
			header('Location: ../error.php');
			die();
			*/
			return json_decode($contents);
			break;

		#Bad Request
		case strpos($headers[0], '400'):
			$_SESSION['err'] = " 400";
			header('Location: ../error.php');
			die();

		#Unauthorized
		case strpos($headers[0], '401'):
			$_SESSION['err'] = " 401";
			header('Location: ../error.php');
			die();

		#Game Data Not Found
		case strpos($headers[0], '404'):
			$_SESSION['err'] = " 404";
			header('Location: ../error.php');
			die();

		#Rate Limit Exceded
		case strpos($headers[0], '429'):
			$_SESSION['err'] = " 429";
			header('Location: ../error.php');
			die();

		#Internal Server Error
		case strpos($headers[0], '500'):
			$_SESSION['err'] = " 500";
			header('Location: ../error.php');
			die();

		#Service Unavailable
		case strpos($headers[0], '503'):
			$_SESSION['err'] = " 503";
			header('Location: ../error.php');
			die();

		default:
			$_SESSION['err'] = "n Unknown"; 
			header('Location: ../error.php');
			die();
	}

}


function request_data($url) {

	#Open Redis(Credis) Instance
	$redis = new Credis_Client('localhost');

	#Set User Reference Key to UID
	$user = $_SESSION['id'];

	#Ensure Server is Under Count
	if($redis->exists('S') !== true) {
		#Initialize SERVER Redis Key with Timeout/Rate
		$redis->setex('S', ENFORCED_SERVER_TIMEOUT, '1');
	}

	#Check if user has a counted limit
	if($redis->exists($user)) {

		#Ensure user and server are under respective limits
		if(($redis->get($user) < USER_LIMIT) && ($redis->get('S') < LOWER_SERVER_LIMIT)) {

			#Increment User Redis Key Toward Limit
			$redis->incr($user);
			$redis->incr('S');

			#Process Request Contents
			return request_handler($url);

		} else {
			return null;
		}

	} else {

		#Initialize Redis Key with Timeout/Rate
		$redis->setex($user, ENFORCED_USER_TIMEOUT, '1');

		#Process Request Contents
		return request_handler($url);
	}
}

#create_redis_timeout_key('http://google.com');
//TEST
//request_data("https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/46849930/recent?api_key=RGAPI-a90129ff-a1fb-4d2e-aa9a-f9247c302355");

