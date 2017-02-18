<?php
session_start();

/*
error_reporting(E_ALL);
ini_set('display_error', 1);
*/

#Check if User is logged in
if(isset($_SESSION['id'])) {
    #Load Required Files
    include 'includes/rate-limit.inc.php';
} else {
    #Redirect User to Login
    header('Location: login.php');
    echo 'You must be signed in to view this page!';
    die();
}

//connect to redis client
$redis = new Credis_Client('localhost');

//cached page lifetime
const CACHE_TTL = 10 * 60; // 10 minute expire

//cache redis key
$redis_cache_key = 'cache:recents:'.$_SESSION['id'];

//check if buffer flush currently exists in the cache for the user
if($redis->exists($redis_cache_key)) {

    //get user's previous flush
    $output = $redis->get($redis_cache_key);
    $output = gzuncompress($output);

    //inform user of cache time
    echo '<!--'.date("F j, Y, g:i a").':   You are being served cached data. This data will update every 10 minutes. Please keep in mind that League of Legends matches\' data may take awhile longer to reach us; in which case the data may be updated at a later cycle.-->';
    //send cached page
    echo $output;
    die();
}

//start output buffer
ob_start();


#construct call
$key = "RGAPI-a90129ff-a1fb-4d2e-aa9a-f9247c302355";
$url = "https://".$_SESSION['rgn'].".api.pvp.net/api/lol/".$_SESSION['rgn']."/v1.3/game/by-summoner/".$_SESSION['sid']."/recent?api_key=".$key;

$result = request_data($url);

//make appropriate calls to preload js arrays for dynamic page generation
function call($result) {

    #sift through games
    $i = 0;
    foreach($result->games as $game) {

        /*
        each array needs to be handled separately because riot's game endpoint doesn't return valeus that were not present in the game
        */

        #fill gold array values
        if(isset($game->stats->goldEarned)) {
            echo 'goldEarned['.$i.'] = '.$game->stats->goldEarned.';';
        } else {
            echo 'goldEarned['.$i.'] = 0;';
        }
        if(isset($game->stats->championsKilled)) {
            echo 'goldSpent['.$i.'] = '.$game->stats->goldSpent.';';
        } else {
            echo 'goldSpent['.$i.'] = 0;';
        }

        #fill kda array values
        if(isset($game->stats->championsKilled)) {
            echo 'kills['.$i.'] = '.$game->stats->championsKilled.';';
        } else {
            echo 'kills['.$i.'] = 0;';
        }
        if(isset($game->stats->numDeaths)) {
            echo 'deaths['.$i.'] = '.$game->stats->numDeaths.';';
        } else {
             echo 'deaths['.$i.'] = 0;';
        }
        if(isset($game->stats->assists)) {
            echo 'assists['.$i.'] = '.$game->stats->assists.';';
        } else {
             echo 'assists['.$i.'] = 0;';
        }

        #fill farm array values
        if(isset($game->stats->minionsKilled)) {
             echo 'minionsKilled['.$i.'] = '.$game->stats->minionsKilled.';';
        } else {
            echo 'minionsKilled['.$i.'] = 0;';
        }
        if(isset($game->stats->neutralMinionsKilled)) {
            echo 'neutralsKilled['.$i.'] = '.$game->stats->neutralMinionsKilled.';';
        } else {
             echo 'neutralsKilled['.$i.'] = 0;';
        }

        #fill item array changes
        if(isset($game->stats->item0)) {
            echo 'item1['.$i.'] = '.$game->stats->item0.';';
        } else {
            echo 'item1['.$i.'] = "0";';
        }
        if(isset($game->stats->item1)) {
            echo 'item2['.$i.'] = '.$game->stats->item1.';';
        } else {
            echo 'item2['.$i.'] = 0;';
        }
        if(isset($game->stats->item2)) {
            echo 'item3['.$i.'] = '.$game->stats->item2.';';
        } else {
            echo 'item3['.$i.'] = 0;';
        }
        if(isset($game->stats->item3)) {
            echo 'item4['.$i.'] = '.$game->stats->item3.';';
        } else {
            echo 'item4['.$i.'] = 0;';
        }
        if(isset($game->stats->item4)) {
            echo 'item5['.$i.'] = '.$game->stats->item4.';';
        } else {
            echo 'item5['.$i.'] = 0;';
        }
        if(isset($game->stats->item5)) {
            echo 'item6['.$i.'] = '.$game->stats->item5.';';
        } else {
            echo 'item6['.$i.'] = 0;';
        }
        if(isset($game->stats->item6)) {
            echo 'item7['.$i.'] = '.$game->stats->item6.';';
        } else {
            echo 'item7['.$i.'] = 0;';
        }

        #grab champion data
        $json = file_get_contents('data/static.champions.json');
        $champdata = json_decode($json);

        #change champion art array (ids to keys)
        if(isset($game->championId)) {

            #match ids to key string
            foreach($champdata->data as $champion) {

                if($champion->id == $game->championId) {

                    echo 'playerChampion['.$i.'] = "'.$champion->key.'";';
                    break;

                }

            }

        } else {

            echo 'playerChampion['.$i.'] = 1;';

        }

        #result array change (converts W/L integers to respective outcomes)
        if($game->stats->win === true) {

            echo 'result['.$i.'] = 1;';

        } else {

            echo 'result['.$i.'] = 0;';

        }
        
        #fill date arrays
        if(isset($game->createDate)) {

            #convert date from unix timestamp to jd time
            $jsDate = $game->createDate / 1000;
            echo 'dateStrings['.$i.'] = "'.date('m.d.y', $jsDate).'";';

        } else {

            #unkown date result fallback
            echo 'dateStrings['.$i.'] = "Unknown Date";';

        }
        
        #get static spell data
        $json = file_get_contents('data/static.summoner_spells.json');
        $spelldata = json_decode($json);

        #make changes to summoner spell array (summoners)
        if(isset($game->spell1) && isset($game->spell2)) {

            #iterate through spell static json
            foreach($spelldata->data as $spell) {

                #match ids to respective spell keys
                if($spell->id == $game->spell1) {

                    echo 'summ1['.$i.'] = "'.$spell->key.'";';

                }

                elseif($spell->id == $game->spell2) {

                    echo 'summ2['.$i.'] = "'.$spell->key.'";';

                }
            }

        } else {

             echo '';

        }

        $i+=1;
    }
}
?>

<html>
<head>
	<meta name="copyright" content="Hunter D. Wodzenski">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">

    <!--JQ-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">

    <!--Navigation Style-->
    <link rel="stylesheet" type="text/css" href="navbar.css" />

	<script>
        //Recent Game OVerview Page - by Hunter D. Wodzenski

        //Items Arrays
        var item1 = [];
        var item2 = [];
        var item3 = [];
        var item4 = [];
        var item5 = [];
        var item6 = [];
        var item7 = [];

        //Summoner Arrays
        var summ1 = [];
        var summ2 = [];

        //Date Management
        var dateStrings = [];

        //Game Win/Loss Result Arrays
        var result = [];

        //Wardplay Arrays
        var wardsPlaced = [];
        var wardsKilled = [];

        //Player Champions
        var playerChampion = [];

        //Damage Dealt Breakdown Arrays
        var totalDamageDealt = [ 50221, 43421, 67281, 34212, 49302, 76853, 72482, 87426, 17242, 34221];
        var magicDamageDealt = [ 27843, 31921, 2643, 23434, 23423, 2342, 45232, 74232, 12342, 19423];
        var physicalDamageDealt = [ 12123, 6437, 55323, 3343, 19243, 64236, 19234, 10234, 4352, 14235];
        var trueDamageDealt = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        var magicDamageDealtChampions = [ 7843, 1921, 2743, 13434, 13423, 2342, 25232, 54232, 11342, 9423];
        var physicalDamageDealtChampions = [ 2123, 437, 45323, 1343, 9243, 34236, 13234, 9234, 2352, 6145];
        var trueDamageDealtChampions = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        //Need Summoner Spells Array Here!
        //@@@@@@

        //Damage Taken Breakdown Arrays
        var totalDamageTaken = [ 54291, 75332, 510014, 36712, 87432, 50423, 71982, 87426, 11242, 44221];
        var magicDamageTaken = [ 23343, 23921, 2643, 23434, 23423, 2342, 45232, 76002, 9342, 13423];
        var physicalDamageTaken = [ 12123, 34437, 55443, 5322, 49243, 34236, 19234, 10234, 4352, 17930];
        var trueDamageTaken = [ 1242, 2412, 5232, 1242, 2342, 2142, 7652, 1923, 1234, 2342];

        //KDA
        var kills = [];
        var deaths = [];
        var assists = [];

        //Gold Arrays
        var goldEarned = [];
        var goldSpent = [];

        //M&M Arrays
        var minionsKilled = [];
        var neutralsKilled = [];
        var neutralsKilledEnemyJungle = [2, 10, 10, 4, 2, 7, 6, 2, 2, 3];
        var neutralsKilledAllyJungle = [1, 5, 5, 8, 5, 4, 2, 1, 2, 3];

        //swap missing items with the 'missing item' image
        function itemSwap(item, string) {
            if(item == 0) {
                return "<img src='images/blank_item.png' />";
            }
            else {
                return string;
            }
        }
        
        //preset svgs
        //kda svg
        var svgSwords = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><g><g><path d="M83.322,86.608c1.36,1.742,0.49,4.693-1.466,6.223l0,0c-1.954,1.529-5.03,1.662-6.392-0.078l-7.038-8.998    c-1.359-1.74,0.303-3.683,2.258-5.211l0,0c1.956-1.529,4.239-2.674,5.601-0.935L83.322,86.608z"></path><rect x="74.463" y="89.215" transform="matrix(0.7877 -0.616 0.616 0.7877 -38.4293 68.0122)" fill="#000000" width="10.025" height="1.108"></rect><polygon fill="#000000" points="81.258,84.014 73.406,90.154 74.527,89.278 80.135,84.892   "></polygon><line fill="#000000" x1="80.324" y1="82.775" x2="72.467" y2="88.919"></line><line fill="#000000" x1="78.277" y1="80.155" x2="70.418" y2="86.299"></line><line fill="#000000" x1="76.912" y1="78.409" x2="69.053" y2="84.554"></line><line fill="#000000" x1="76.228" y1="77.536" x2="68.37" y2="83.681"></line><path d="M70.604,78.504c-3.18,2.487-6.386,3.81-7.865,3.373l3.014,3.852l13.096-10.239l-3.083-3.945    C76.572,72.579,73.882,75.942,70.604,78.504z"></path><path d="M16.149,8.918l-0.879,12.252l52.15,60.438l7.08-5.537L28.42,10.889L16.149,8.918z M73.226,76.351l-3.941-0.498l0.72,0.922    l-0.872,0.684l-0.569-0.729l-0.942,3.729l-1.236-0.319l1.174-4.694L23.393,18.963l0.873-0.683L68.15,74.401l5.226,0.694    L73.226,76.351z"></path><line fill="#000000" x1="79.188" y1="81.308" x2="71.326" y2="87.456"></line></g><g><path d="M24.57,91.895c-1.28,1.801-4.357,1.811-6.382,0.374l0,0c-2.024-1.436-3.03-4.346-1.752-6.146l6.61-9.317    c1.279-1.801,3.616-0.763,5.639,0.674l0,0c2.025,1.437,3.775,3.298,2.497,5.1L24.57,91.895z"></path><rect x="15.429" y="88.558" transform="matrix(0.8155 0.5788 -0.5788 0.8155 55.3508 4.6127)" fill="#000000" width="10.025" height="1.108"></rect><polygon fill="#000000" points="26.467,89.174 18.337,83.405 19.498,84.229 25.305,88.349   "></polygon><line fill="#000000" x1="27.387" y1="87.925" x2="19.252" y2="82.153"></line><line fill="#000000" x1="29.312" y1="85.215" x2="21.178" y2="79.44"></line><line fill="#000000" x1="30.595" y1="83.407" x2="22.459" y2="77.633"></line><line fill="#000000" x1="31.236" y1="82.502" x2="23.102" y2="76.729"></line><path d="M28.7,77.389c-3.292-2.336-5.476-5.03-5.48-6.572l-2.83,3.989l13.556,9.622l2.899-4.083    C36.084,81.415,32.093,79.798,28.7,77.389z"></path><path d="M79.814,5.314l-11.993,2.66L24.815,75.228l7.33,5.202l49.289-62.794L79.814,5.314z M31.514,79.286l-0.65-3.919    l-0.678,0.953l-0.904-0.641l0.535-0.754l-3.843,0.163l-0.047-1.276l4.834-0.217l41.497-58.469l0.904,0.641L31.93,73.866    l0.829,5.205L31.514,79.286z"></path><line fill="#000000" x1="28.468" y1="86.418" x2="20.329" y2="80.641"></line></g></g></svg>';
        //gold svg
        var svgCoins = '<svg viewBox="0 0 99.999997 124.99999625" version="1.1" x="0px" y="0px"><g transform="translate(0,-952.36223)"><path style="color:#000000;enable-background:accumulate;" d="M 36 12 C 21.019276 12 8.7811776 17.884071 8.03125 25.28125 C 8.0346449 25.322442 8.0269549 25.365025 8.03125 25.40625 C 8.3381201 28.351643 10.940873 31.378916 15.6875 33.78125 C 20.750569 36.34375 27.98955 38.03125 36 38.03125 C 40.610667 38.03125 44.949556 37.463185 48.78125 36.5 C 51.686825 34.615338 54.954234 33.233924 58.46875 32.53125 C 61.837802 30.369208 63.712521 27.865584 63.96875 25.40625 C 63.970898 25.385638 63.966827 25.364354 63.96875 25.34375 C 63.966831 25.323016 63.97085 25.30196 63.96875 25.28125 C 63.218822 17.884071 50.980724 12 36 12 z M 8.03125 33.28125 L 8.03125 37.3125 C 8.0332656 37.334242 8.0289839 37.353249 8.03125 37.375 C 8.3381201 40.320393 10.940873 43.347666 15.6875 45.75 C 20.750569 48.31252 27.989546 50 36 50 C 36.620668 50 37.233131 49.958526 37.84375 49.9375 C 39.031229 46.854136 40.770601 44.039296 42.90625 41.59375 C 40.681909 41.853722 38.375326 42 36 42 C 27.441906 42 19.669796 40.2766 13.875 37.34375 C 11.613292 36.199063 9.629927 34.82307 8.03125 33.28125 z M 64 34 C 49.640596 34 38 45.640596 38 60 C 38 74.359404 49.640596 86 64 86 C 78.359404 86 90 74.359404 90 60 C 90 45.640596 78.359404 34 64 34 z M 8.03125 45.28125 L 8.03125 49.28125 C 8.0340854 49.313855 8.0278508 49.342374 8.03125 49.375 C 8.3381201 52.320365 10.940873 55.347656 15.6875 57.75 C 20.750569 60.3125 27.989546 62 36 62 C 36.031406 62 36.062376 62.000062 36.09375 62 C 36.04709 61.339133 36 60.672741 36 60 C 36 57.931624 36.230696 55.909371 36.65625 53.96875 C 36.436797 53.97217 36.22119 54 36 54 C 27.441902 54 19.669796 52.2453 13.875 49.3125 C 11.613293 48.167813 9.629927 46.82307 8.03125 45.28125 z M 8.03125 57.28125 L 8.03125 61.25 C 8.0347799 61.293464 8.0267178 61.331499 8.03125 61.375 C 8.3381201 64.320365 10.940873 67.347656 15.6875 69.75 C 20.750569 72.3125 27.989546 74 36 74 C 37.248291 74 38.482169 73.951999 39.6875 73.875 C 38.295679 71.440671 37.23652 68.790641 36.625 65.96875 C 36.414695 65.971198 36.211883 66 36 66 C 27.441902 66 19.669796 64.2453 13.875 61.3125 C 11.613293 60.167829 9.629927 58.823074 8.03125 57.28125 z M 8 69.28125 L 8 74 C 8 81.732 20.540613 88 36 88 C 42.049571 88 47.634411 87.032697 52.21875 85.40625 C 48.342568 83.603624 44.948702 80.935257 42.28125 77.65625 C 40.248552 77.877273 38.159137 78 36 78 C 27.441902 78 19.669796 76.2453 13.875 73.3125 C 11.605753 72.164013 9.6013165 70.829449 8 69.28125 z " transform="translate(0,952.36223)"  marker="none" visibility="visible" display="inline" overflow="visible"/></g>></svg>';
        //minion farm svg
        var svgHat = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" style="enable-background:new 0 0 100 100;" xml:space="preserve"><path d="M5.483,90.637c0,0-2.231-2.9,2.454-4.686c4.685-1.784,5.913-2.342,5.913-2.342s0.334-0.559,0.781-0.893  c0.446-0.335,13.274-5.912,14.836-7.362c1.562-1.45,1.562-2.9,1.004-3.904s-2.008-1.228-0.781-3.458  c1.227-2.231,4.016-9.594,4.016-9.594l7.363-21.083l10.04-22.646c0,0,3.012-6.916,6.136-6.358  c3.123,0.558,11.713,17.514,13.274,19.968c1.562,2.454-0.335,1.562-2.343,0.892s-7.92-5.131-7.92-5.131s11.526,38.82,10.839,43.394  c-0.688,4.574-1.373,4.239,0.029,5.913c1.402,1.673,15.681,8.7,19.697,9.816c4.016,1.115,5.466,2.23,5.02,3.234  s1.228,3.235-18.183,3.682S14.185,93.872,5.483,90.637z"/></svg>';
        //monster farm svg
        var svgWolf = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 96 120" enable-background="new 0 0 96 96" xml:space="preserve"><path d="M87.88,24.416V1.692c0-0.724-0.396-1.392-1.024-1.744c-0.631-0.356-1.412-0.34-2.023,0.04L67.428,10.68  c-5.648-2.068-12.5-3.24-18.976-3.24c-6.716,0-14.164,1.236-19.732,3.244L10.908-0.024c-0.62-0.368-1.392-0.384-2.016-0.024  c-0.632,0.356-1.016,1.02-1.016,1.74V24.42C4.2,29.752,2.34,36.436,2.34,44.4l0.616,13.552c0.04,0.828,0.584,1.556,1.372,1.808  l9.996,3.301L10.972,76.76c-0.168,0.688,0.04,1.416,0.556,1.912c0.512,0.5,1.252,0.68,1.932,0.484l11.46-3.268l3.484,18.783  c0.112,0.608,0.5,1.133,1.052,1.416c0.548,0.276,1.2,0.292,1.76,0.032l16.9-7.864L65,96.12c0.264,0.128,0.561,0.188,0.844,0.188  c0.313,0,0.62-0.076,0.912-0.217c0.553-0.283,0.932-0.804,1.053-1.412l3.455-18.068l11.457,2.945  c0.172,0.047,0.352,0.071,0.539,0.063c1.112-0.048,2.04-0.884,2.04-2c0-0.36-0.096-0.704-0.268-1l-3.337-13.396l9.793-3.381  c0.764-0.256,1.296-0.96,1.344-1.764l0.832-13.728C93.664,36.66,91.716,29.956,87.88,24.416z M68.296,31.88l-8.416,5.408v29.868  c0.017,0.132,0.084,0.252,0.084,0.392s-0.067,0.257-0.084,0.392v0.256c0,0.584-0.26,1.109-0.668,1.473  C57.42,72.22,52.492,73.42,47.8,73.42c-5.852,0-12.152-1.844-12.152-5.88c0-0.412,0.104-0.784,0.232-1.151V37.284l-8.416-5.408  c-0.928-0.596-1.196-1.836-0.6-2.764c0.596-0.928,1.832-1.2,2.764-0.6l9.336,6c0.572,0.368,0.916,1.004,0.916,1.68v26.785  c2.26-0.881,5.132-1.313,7.92-1.313c2.849,0,5.796,0.443,8.08,1.359V36.196c0-0.676,0.345-1.316,0.916-1.68l9.328-6  c0.933-0.6,2.172-0.328,2.765,0.6C69.492,30.044,69.225,31.28,68.296,31.88z"/><path d="M39.88,67.436v0.44c0.84,0.468,3.524,1.544,7.92,1.544c4.776,0,7.513-1.264,8.08-1.916V67.32  c-0.567-0.385-3.304-1.645-8.08-1.645C43.408,65.676,40.72,66.756,39.88,67.436L39.88,67.436z"/></svg>';

        //when the window loads, dynamically generate the page content!
        window.onload = function() {

            //preset image construction
            //champion images
            var championImageLinkStart = '<img src="http://ddragon.leagueoflegends.com/cdn/6.22.1/img/champion/';
			var championImageLinkEnd = '.png"><br />';
            //item images
            var itemImageLinkStart = '<img src="http://ddragon.leagueoflegends.com/cdn/6.23.1/img/item/';
			var itemImageLinkEnd = '.png"><br />';
            //summoner images
            var summonerImageLinkStart = '<img src="http://ddragon.leagueoflegends.com/cdn/6.23.1/img/spell/'; //SummonerFlash
            var summonerImageLinkEnd = '.png"><br />';

            //init vars
            var outcomeText, outcomeColor;

            <?php 
                call($result); 
            ?>

            //Loop through 10 poss games
            for (i = 0; i <= 9; i++) {

                //outcome handling
                if (result[i] == 0) {
                    outcomeText = "DEFEAT";
                    outcomeColor = "darkred";
                }
                else {
                    outcomeText = "VICTORY";
                    outcomeColor = "green";
                }
                console.log(outcomeColor);

                //track game number as string
                si = (i+1).toString();

                container = document.getElementById('container').innerHTML += 
                    "<div>" + 
                        //champion portrait
                        "<div id='flex-portrait'>" +
                            //autofill champion images
                            championImageLinkStart + playerChampion[i] + championImageLinkEnd +
                        "</div>" +
                        //outcome text
                        "<div id='flex-outcome'>" +
                            "<div>" + 
                                "<font color='" + outcomeColor + "'>" + outcomeText + "</font>" +
                            "</div>" +
                            "<div>" + 
                                dateStrings[i] +
                            "</div>" +
                        "</div>" +
                        //KDAr & KDA"K/D/A"
                        "<div id='flex-playerscore'>" +
                            //K/D/A
                            "<div>" +
                                //text color xparent to keep spacing same!
                                "<span class='svg-pretext' style='color: transparent;'>R</span>" + svgSwords + kills[i] + "/" + deaths[i] + "/" + assists[i] + "&nbsp;" +
                            "</div>" +
                            //KDAr
                            "<div>" +
                               "<span class='svg-pretext'>R</span>" + svgSwords + (kills[i] + assists[i]) + ":" + deaths[i] + "(" + ((kills[i] + assists[i]) - deaths[i]) + ")" +
                            "</div>" +
                        "</div>" +
                        //Gold
                        "<div id='flex-gold'>" +
                            "<div>" + 
                                "<span class='svg-pretext'>+</span>" + svgCoins + goldEarned[i] +
                            "</div>" +
                            "<div>" + 
                                "<span class='svg-pretext'>-</span>" + svgCoins + goldSpent[i] +
                            "</div>" +
                        "</div>" +
                        //Farm
                        "<div id='flex-farm'>" +
                            //minion farm
                            "<div>" +
                                svgHat + "&nbsp;" + minionsKilled[i] +
                            "</div>" +
                            //monster farm
                            "<div>" +
                                 svgWolf + "&nbsp;" + neutralsKilled[i] +
                            "</div>" +
                        "</div>" +
                        //Items
                        "<div id='flex-items'>" +
                            //Row 1
                            "<div>" +
                                //Column 1 (i1)
                                "<div class='itemr'>" +
                                    itemSwap(item1[i], itemImageLinkStart + item1[i] + itemImageLinkEnd) +
                                "</div>" +
                                //Column 2  (i2)
                                "<div class='itemc'>" +
                                    itemSwap(item2[i], itemImageLinkStart + item2[i] + itemImageLinkEnd) +
                                "</div>" +
                                //Column 3  (i3)
                                "<div class='iteml'>" +
                                    itemSwap(item3[i], itemImageLinkStart + item3[i] + itemImageLinkEnd) +
                                "</div>" +
                            "</div>" +
                            //Row 2
                            "<div>" +
                                //Column 1  (i4)
                                "<div class='itemr'>" +
                                    itemSwap(item4[i], itemImageLinkStart + item4[i] + itemImageLinkEnd) +
                                "</div>" +
                                //Column 2  (i5)
                                "<div class='itemc'>" +
                                    itemSwap(item5[i], itemImageLinkStart + item5[i] + itemImageLinkEnd) +
                                "</div>" +
                                //Column 3  (i6)
                                "<div class='iteml'>" +
                                    itemSwap(item6[i], itemImageLinkStart + item6[i] + itemImageLinkEnd) +
                                "</div>" +
                            "</div>" +
                            //Row 3
                            "<div>" +
                                //Column 1  (EMPTY)
                                "<div>" +
                                    "" +
                                "</div>" +
                                //Column 2 (i7[trnkt])
                                "<div  class='itemc'>" +
                                    itemSwap(item7[i], itemImageLinkStart + item7[i] + itemImageLinkEnd) +
                                "</div>" +
                                //Column 3 (EMPTY)
                                "<div>" +
                                    "" +
                                "</div>" +
                            "</div>" +
                        "</div>" +
                        "<div id='flex-summoners'>" +
                            //Row 1
                            "<div>" +
                                summonerImageLinkStart + summ1[i] + summonerImageLinkEnd +
                            "</div>" +
                            //Row 2
                            "<div>" +
                                summonerImageLinkStart + summ2[i] + summonerImageLinkEnd +
                            "</div>" +
                            //Row 3
                            /*
                            "<div>" +
                                summonerImageLinkStart + '' + summonerImageLinkEnd +
                            "</div>" +
                            */
                        "</div>" +
                    "</div>"
                ;


            }
        }
   </script>

   <style>

     html, body {padding: 0; margin: 0;}

     body {
         background: #000 url(images/LoLB2.jpg);
         background-size: cover;
         background-position: center;
         background-attachment: fixed;
     }

    #head {
        width: 100%;
        height: 10vh;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: lightgray;
        font-size: calc(1em + 1.5vmax);
    }

    #subhead {
        width: 95%;
        height: 10vh;
        margin-bottom: 0;
        display: flex;
        flex-flow: row nowrap;
        align-items: center;
        justify-content: center;
        color: rgba(240, 150, 65, 0.75);
        font-size: calc(1em + .5vmax);
    }
        #subhead > div {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: left;
        }

    #container {
        height: auto;
        width: 85%;
        margin-right: auto;
        margin-left: auto;
        display: flex;
        flex-flow: column nowrap;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to right, transparent, rgba(0, 51, 102, 0.75), rgba(0, 51, 102, 0.75),rgba(0, 51, 102, 0.75), rgba(0, 51, 102, 0.75), rgba(0, 51, 102, 0.75), transparent);
        font-size: 1.25vmax;
        font-family: 'Righteous', cursive;
    }
        /*Not first or second child (head and subhead)*/
        #container > div:not(:nth-child(1)):not(:nth-child(2)) {
            width: 95%;
            /*Min height of 5em with repsonsive addition of 3 viewpoint height ints*/
            height: calc(5em + 7.5vh);
            margin-bottom: 2%;
            background-color: rgba(0, 51, 102, 0.75);
            display: flex;
            flex-flow: row nowrap;
            /*color of #*/
            color: lightgray;
            border: .2em solid rgba(240, 150, 65, 0.75);
            border-radius: 0 1em 0 1em;
        }

        /*Overall SVG styling*/
        svg {
            height: 1.5vmax;
            width: auto;
            fill: rgba(240, 150, 65, 0.75);
        }
            /*text redef SVG imgs*/
            .svg-pretext {
                color: rgba(240, 150, 65, 0.75);
                font-size: 1vmax;
            }

            #flex-portrait {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: left;
            }
                #flex-portrait > img {
                    height: calc(4em + 6vh);
                    width: auto;
                    border-radius: 100%;
                    
                    /*bring off the edge a lil*/
                    padding-left: 0.75em;
                }
                    #flex-portrait > img:hover {
                        filter: contrast(50%);
                        filter: saturate(165%);
                    }
            #flex-outcome {
                flex: 1;
                display: flex;
                flex-flow: column nowrap;
            }
                #flex-outcome > div {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    color: lightgray;
                }
                    /*change color of victory/defeat through p/c heiarchy*/
                    #flex-outcome > div:first-child {
                        font-size: 2.25vmax;
                    }
            #flex-playerscore {
                flex: 1;
                display: flex;
                flex-flow: column nowrap;
            }
                /*playerscore innerdivs are given flex properties for positioning*/
                #flex-playerscore > div {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    color: lightgray;
                }
            #flex-gold {
                flex: 1;
                display: flex;
                flex-flow: column nowrap;
            }
                #flex-gold > div {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    color: lightgray;
                }
            #flex-farm {
                flex: 1;
                display: flex;
                flex-flow: column nowrap;
            }
                #flex-farm > div {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    justify-content: left;
                    color: lightgray;
                }
            #flex-items {
                flex: 1;
                display: flex;
                flex-flow: column nowrap;
            }
                #flex-items > div {
                    flex: 1;
                    display: flex;
                    flex-flow: row nowrap;
                    align-items: center;
                    justify-content: center;
                }
                    #flex-items > div > div {
                        flex: 1;
                        display: flex;
                        height: 30%;
                        align-items: center;
                    }
                    .itemr {
                        justify-content: flex-end;
                    }
                    .itemc {   
                        justify-content: center;
                    }
                    .iteml  {
                        justify-content: flex-start;
                    }
                        #flex-items > div > div > img {
                            height: 85%;
                            width: auto;
                        }
            #flex-summoners {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-flow: column nowrap;
            }
                #flex-summoners > div {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 30%;
                }
                    #flex-summoners > div img {
                        height: 85%;
                    }

             @media (max-width: 750px) {
                 #flex-portrait > img {
                     padding-right: 5%;
                 }
             }

   </style>
</head>
<body ondragstart="return false;" ondrop="return false;">
        <!--Flexbox Navigation-->
        <header id="site-header">
              <div>
                <ul>
                    <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Dashboard</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="#" style="color: gray; text-decoration: overline;">Recents</a></li>
		    <li><a style="font-family: 'Righteous', cursive;" href="playercard.php">Playercard</a></li>
                    <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Game&nbsp;Info</a></li>
                    <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">PB&nbsp;Analytics</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="developer.php">Developer</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="includes/logout.inc.php">Logout</a></li>
                </ul>
              </div>
        </header>
    <div id="container">
        <div id="head">
            RECENT GAMES
        </div>
        <!--Column Heads-->
        <div id="subhead">
            <div>
                Champion
            </div>
            <div>
                Outcome
            </div>
            <div>
                KDA(r)
            </div>
            <div>
                Gold
            </div>
            <div>
                Farm
            </div>
            <div>
                Items
            </div>
            <div>
                Summoners
            </div>
        </div>
    </div>
	
</body>
</html>

<?php
$output = ob_get_contents();
$output = gzcompress($output);
ob_end_flush();
ob_clean();
$redis->setex($redis_cache_key, CACHE_TTL, $output);
/*
#initialize page cache
$cache = $_SERVER['DOCUMENT_ROOT'] . '/cache.html'; //cached file to return
$cache_timeout = 600; //10 minutes
//Serve up file from cache if timeout has not occured.
if (file_exists($cache) && time() - $cache_timeout < filemtime($cache)) {
    include($cache);
    echo '<!--You are being served cached data. You can update every 10 minutes. Please keep in mind that League of Legends matches\' data may take awhile longer to reach us.-->';
    die();
}
#Initialize Output Buffer for caching
ob_start();
*/
/*
//Create cache file
$cached = fopen($cache, 'w');
//Write Dynamic Data to file
fwrite($cached, ob_get_contents());
fclose($cached);

ob_end_flush(); //Send data to browser!
*/
?>
