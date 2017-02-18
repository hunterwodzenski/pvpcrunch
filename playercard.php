<?php
session_start();

#check if user is logged in
if(isset($_SESSION['id'])) {

    #includes dependencies
    include 'includes/rate-limit.inc.php';

} else {

    #redirect to login page
    header('Location: login.php');
    //notify incorrect login
    die();

}

#create a redis/credis instance
$redis = new Credis_Client('localhost');

#set cache time to live
const CACHE_TTL = 10 * 60; //10 minutes

#create key string for cache
$redis_cache_key = 'cache:playercard:'.$_SESSION['id'];

#check if page is already in cache
if($redis->exists($redis_cache_key)) {

    #get cached page and uncompress
    $output = $redis->get($redis_cache_key);
    $output = gzuncompress($output);

    #inform user of cache time
    echo '<!--'.date("F j, Y, g:i a").':   You are being served cached data. You can update every 10 minutes. Please keep in mind that League of Legends matches\' data may take awhile longer to reach us.-->';
    #send cached page
    echo $output;

    die();

}

#start output buffer
ob_start();

#construct api call
$key = "RGAPI-a90129ff-a1fb-4d2e-aa9a-f9247c302355";
$url = "https://".$_SESSION['rgn'].".api.pvp.net/api/lol/".$_SESSION['rgn']."/v1.3/stats/by-summoner/".$_SESSION['sid']."/ranked?season=SEASON2017&api_key=".$key;

#request data from api
$result = request_data($url);

function call($result) {
    
    #load champion data
    $json = file_get_contents('data/static.champions.json');
    $champdata = json_decode($json);

    #the following loop cross-checks static.champions data with api data to match champion data to ids
    $i = 0;
    foreach($result->champions as $champion) {

        if(isset($champion->id)) {

            #build default page and overall view function
            if($champion->id == '0') {

                echo <<<DOC
                    document.getElementById("overall").innerHTML = "<button id='overallButton'>View Overall</button>";
                    var overall = document.getElementById("overallButton");
                    overall.onclick = function() {  
                        document.getElementById("body").style.backgroundImage = "url('images/overallbg.png')";
                        document.getElementById("champName").innerHTML = "Overall";
                        document.getElementById("stats-container").innerHTML = "<div>"+
                        "<div><span>Games Played: {$champion->stats->totalSessionsPlayed}</span></div>" +
                        "<div><span>Wins: {$champion->stats->totalSessionsWon}</span></div>" +
                        "<div><span>Losses: {$champion->stats->totalSessionsLost}</span></div>" +
                        "<div><span>Kills: {$champion->stats->totalChampionKills}</span></div>" +
                        "<div><span>Deaths: {$champion->stats->totalDeathsPerSession}</span></div>" +
                        "<div><span>Assists: {$champion->stats->totalAssists}</span></div>" +
                        "<div><span>Double Kills: {$champion->stats->totalDoubleKills}</span></div>" +
                        "<div><span>Triple Kills: {$champion->stats->totalTripleKills}</span></div>" +
                        "<div><span>Quadra Kills: {$champion->stats->totalQuadraKills}</span></div>" +
                        "<div><span>Penta Kills: {$champion->stats->totalPentaKills}</span></div>" +
                        "<div><span>Legendary Kills: {$champion->stats->totalUnrealKills}</span></div>" +
                        "<div><span>First Bloods: {$champion->stats->totalFirstBlood}</span></div>" +
                        "<div><span>Killing Sprees: {$champion->stats->killingSpree}</span></div>" +
                        "<div><span>Largest Killing Spree: {$champion->stats->maxLargestKillingSpree}</span></div>" +
                        "</div>" +
                        "<div>" +
                        "<div><span>Farm: {$champion->stats->totalMinionKills}</span></div>" +
                        "<div><span>Monster Kills: {$champion->stats->totalNeutralMinionsKilled}</span></div>" +
                        "<div><span>Gold Earned: {$champion->stats->totalGoldEarned}</span></div>" +
                        "<div><span>Turret Kills: {$champion->stats->totalTurretsKilled}</span></div>" +
                        "<div><span>Damage Dealt: {$champion->stats->totalDamageDealt}</span></div>" +
                        "<div><span>Physical Damage Dealt: {$champion->stats->totalPhysicalDamageDealt}</span></div>" +
                        "<div><span>Magic Damage Dealt: {$champion->stats->totalMagicDamageDealt}</span></div>" +
                        "<div><span>Highest Crit: {$champion->stats->maxLargestCriticalStrike}</span></div>" +
                        "<div><span>Healing: {$champion->stats->totalHeal}</span></div>" +
                        "<div><span>Most Kills: {$champion->stats->mostChampionKillsPerSession}</span></div>" +
                        "<div><span>Most Deaths: {$champion->stats->maxNumDeaths}</span></div>" +
                        "<div><span>Largest Lifetime: {$champion->stats->maxTimeSpentLiving}</span></div>" +
                        "<div><span>Longest Game: {$champion->stats->maxTimePlayed}</span></div>" +
                        "<div></div>"+
                        "</div>";
                    };
                    document.getElementById("overallButton").click();
DOC;

            } else {

                #declare champion string
                $championStr = '';

                foreach($champdata->data as $championd) {

                    #cross reference api data to static.champion data
                    if($champion->id == $championd->id) {

                        #get string value for ddragon calls
                        $championStr = $championd->key;

                        #use name for stats container header
                        $championName = $championd->name;

                        break;

                    }

                }

                #Generate Stats
                echo 'portraitsContainer.innerHTML += "<div><a title=\''.$championStr.'\' id=\''.$championStr.'\' href=\'#_'.$championStr.'\' onclick=\'document.getElementById(\"champName\").innerHTML = \"'.$championName.'\";document.getElementById(\"body\").style.backgroundImage=\"url(\\\\\"http://ddragon.leagueoflegends.com/cdn/img/champion/splash/'.$championStr.'_1.jpg\\\\\")\";document.getElementById(\"stats-container\").innerHTML = \"<div><div><span>Wins: '.$champion->stats->totalSessionsWon.'</span></div><div><span>Losses: '.$champion->stats->totalSessionsLost.'</span></div><div><span>Kills: '.$champion->stats->totalChampionKills.'</span></div><div><span>Deaths: '.$champion->stats->totalDeathsPerSession.'</span></div><div><span>Assists: '.$champion->stats->totalAssists.'</span></div><div><span>Double Kills: '.$champion->stats->totalDoubleKills.'</span></div><div><span>Triple Kills: '.$champion->stats->totalTripleKills.'</span></div><div><span>Quadra Kills: '.$champion->stats->totalQuadraKills.'</span></div><div><span>Penta Kills: '.$champion->stats->totalPentaKills.'</span></div><div><span>Legendary Kills: '.$champion->stats->totalUnrealKills.'</span></div><div><span>First Bloods: '.$champion->stats->totalFirstBlood.'</span></div></div><div><div><span>Farm: '.$champion->stats->totalMinionKills.'</span></div><div><span>Gold Earned: '.$champion->stats->totalGoldEarned.'</span></div><div><span>Turret Kills: '.$champion->stats->totalTurretsKilled.'</span></div><div><span>Damage Dealt: '.$champion->stats->totalDamageDealt.'</span></div><div><span>Physical Damage Dealt: '.$champion->stats->totalPhysicalDamageDealt.'</span></div><div><span>Magic Damage Dealt: '.$champion->stats->totalMagicDamageDealt.'</span></div><div><span>Max Kills: '.$champion->stats->mostChampionKillsPerSession.'</span></div><div><span>Max Deaths: '.$champion->stats->maxNumDeaths.'</span></div><div><span>Max Spell Casts: '.$champion->stats->mostSpellsCast.'</span></div><div><span>Damage Taken: '.$champion->stats->totalDamageTaken.'</span></div><div></div></div>\"\'><img src=\'http://ddragon.leagueoflegends.com/cdn/6.22.1/img/champion/'.$championStr.'.png\' /></a></div>";'.PHP_EOL;
            
            }

        } /*else {

            do nothing

        }*/

        $i += 1;

    }

}

?>
<html>
    <head>
        <title>
            PVPCrunch.COM
        </title>
        
        <meta name="copyright" content="Hunter D. Wodzenski">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">

        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">

        <!--Navigation Styles-->
        <link rel="stylesheet" type="text/css" href="navbar.css" />

        <script type="text/javascript">
            window.onload = function() {
                var portraitsContainer = document.getElementById('portraits-container');
                var statsContainer = document.getElementById('stats-container');
                <?php
                    call($result);
                ?>
            }
        </script>

        <style>
            html, body {margin: 0; padding: 0;}
            body {
                background: #000 url(images/rumblebg.jpg) no-repeat fixed;
                background-position: center;
                background-size: cover;
                user-select: none;
            }

            /*INTRODUCTION SECTION*/
            #main-section {
                width: 100%;
                height: 100%;
                background: rgba(0, 51, 102, 0.75);
            }
                #main-container{
                    width: 100%;
                    height: 92.5%;
                    display: flex;
                    flex-flow: row nowrap;
                }
                    #main-container > #portraits-container {
                        /*override flex with viewport size to match image children*/
                        width: 15vw;
                        height: 100%;
                        /*border-right: .15em solid white;*/
                        overflow-y: scroll;
                    }
                        #main-container > #portraits-container > div {
                            width: 100%;
                            height: auto;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background: rgba(0, 0, 0, .5);/*linear-gradient(to right, transparent, black, transparent);*/
                            padding-top: 2vmax;
                        }
                            #main-container > #portraits-container > div img {
                                width: 10vw;
                                height: 10vw;
                                border-radius: 75% 0 75% 0;
                                border: .25em solid black;
                            }
                                #main-container > #portraits-container > div img:hover {
                                    #filter: contrast(30%);
                                    #filter: saturate(165%);
                                    border: .25em solid rgba(240, 150, 65, .75);
                                }
                    #main-container > #data {
                        flex: 4;
                        width: 100%;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-flow: column nowrap;
                    }
                        #main-container > #data > #data-head {
                            flex: 1;
                            width: 100%;
                            height: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                            #main-container > #data > #data-head > div {
                                flex: 1;
                                width: 100%;
                                height: 100%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: rgba(0, 51, 102, 0.75);
                                /*provide text outline*/
                                text-shadow: 1px 1px 0 rgba(240, 150, 65, .75),
                                    -1px 1px 0 rgba(240, 150, 65, .75),
                                    1px -1px 0 rgba(240, 150, 65, .75),
                                    -1px -1px 0 rgba(240, 150, 65, .75),
                                    0px 1px 0 rgba(240, 150, 65, .75),
                                    0px -1px 0 rgba(240, 150, 65, .75),
                                    -1px 0px 0 rgba(240, 150, 65, .75),
                                    1px 0px 0 rgba(240, 150, 65, .75),
                                    2px 2px 0 rgba(240, 150, 65, .75),
                                    -2px 2px 0 rgba(240, 150, 65, .75),
                                    2px -2px 0 rgba(240, 150, 65, .75),
                                    -2px -2px 0 rgba(240, 150, 65, .75),
                                    0px 2px 0 rgba(240, 150, 65, .75),
                                    0px -2px 0 rgba(240, 150, 65, .75),
                                    -2px 0px 0 rgba(240, 150, 65, .75),
                                    2px 0px 0 rgba(240, 150, 65, .75),
                                    1px 2px 0 rgba(240, 150, 65, .75),
                                    -1px 2px 0 rgba(240, 150, 65, .75),
                                    1px -2px 0 rgba(240, 150, 65, .75),
                                    -1px -2px 0 rgba(240, 150, 65, .75),
                                    2px 1px 0 rgba(240, 150, 65, .75),
                                    -2px 1px 0 rgba(240, 150, 65, .75),
                                    2px -1px 0 rgba(240, 150, 65, .75),
                                    -2px -1px 0 rgba(240, 150, 65, .75);
                                font-family:  'Righteous', cursive;
                                font-size: 2vmax;

                            }
                                #main-container > #data > #data-head > div > button {
                                    width: calc(3em + 5vmax);
                                    height: calc(1.75em + 1vmax);
                                    font-size: calc(.25em + .75vmax);
                                    font-family: 'Righteous', cursive;
                                    color: rgba(240, 150, 65, 1);
                                    border-radius: 0 25% 0 25%;
                                    background: rgba(0, 51, 102, 0.75);
                                    outline: none;
                                    border: .15em solid rgba(240, 150, 65, .75);
                                }
                                    #main-container > #data > #data-head > div > button:hover {
                                        border-color: rgba(100, 100, 100, .75);
                                    }
                    #main-container > #data > #stats-container {
                        flex: 8;
                        width: 100%;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;

                    }
                        #main-container > #data > #stats-container > div {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 100%;
                            height: 100%;
                            flex-flow: column nowrap;
                            flex: 1;
                        }
                        #main-container > #data > #stats-container > div > div {
                            width: 100%;
                            height: 100%;
                            display: flex;
                            align-items: center;
                            justify-content: left;
                            border-bottom: .06em solid rgba(100, 100, 100, .35);
                            flex: 1;
                        }
                            #main-container > #data > #stats-container > div > div > span {
                                font-family: 'Righteous', cursive;
                                font-weight: 300;
                                text-shadow: 1px 1px 0 #000,
                                    -1px 1px 0 #000,
                                    1px -1px 0 #000,
                                    -1px -1px 0 #000,
                                    0px 1px 0 #000,
                                    0px -1px 0 #000,
                                    -1px 0px 0 #000,
                                    1px 0px 0 #000,
                                    2px 2px 0 #000,
                                    -2px 2px 0 #000,
                                    2px -2px 0 #000,
                                    -2px -2px 0 #000,
                                    0px 2px 0 #000,
                                    0px -2px 0 #000,
                                    -2px 0px 0 #000,
                                    2px 0px 0 #000,
                                    1px 2px 0 #000,
                                    -1px 2px 0 #000,
                                    1px -2px 0 #000,
                                    -1px -2px 0 #000,
                                    2px 1px 0 #000,
                                    -2px 1px 0 #000,
                                    2px -1px 0 #000,
                                    -2px -1px 0 #000;
                                font-size: 1.5vmax;                              
                                color: white;
                                padding-left: 7.5%;
                            }

            /*Scrollbar Styles*/
            ::-webkit-scrollbar {
                height: auto;
                width: 1em;
                background: rgba(0, 51, 102, 0.75);
            }

            ::-webkit-scrollbar-thumb {
                background: rgba(240, 150, 65, 0.75);
                -webkit-border-radius: .75em 0 .75em 0;
                -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
            }

            ::-webkit-scrollbar-corner {
                background: rgba(0, 0, 0, .75);
            }
        </style>
    </head>
    <!--Disable dragging-->
    <body id="body" ondragstart="return false;" ondrop="return false;" style="overflow: hidden">
        <!--Landing page header-->
        <header id="site-header">
              <div>
                <ul>
                    <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Dashboard</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="recents.php">Recents</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="#" style="color: gray; text-decoration: overline;">Playercard</a></li>
                    <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Game&nbsp;Info</a></li>
                    <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">PB&nbsp;Analytics</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="developer.php">Developer</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="includes/logout.inc.php">Logout</a></li>
                </ul>
              </div>
        </header>

        <!--Introduction Section-->
        <section id="main-section">
            <div id="main-container">
                <div id="portraits-container">
                </div>
                <div id="data">
                    <div id="data-head">
                        <div>
                            Ranked Stats
                        </div>
                        <div id="champName">
                            Overall            
                        </div>
                        <div id="overall">
                        </div>
                    </div>
                    <div id="stats-container">
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>

<?php
//collect output buffer
$output = ob_get_contents();
$output = gzcompress($output);

//flush buffer
ob_end_flush();
ob_clean();

//initiate cache key
$redis->setex($redis_cache_key, CACHE_TTL, $output);
?>
