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
?>
<html>
    <!--Copyright 2017 PvPCrunch-->
    <head>
        <title>
            PVPCrunch.COM
        </title>
        
        <meta name="copyright" content="PvPCrunch">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">

        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Righteous|Sarpanch:900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="navbar.css" />

    <style>
    html, body {
        margin: 0;
        padding: 0;
    }
    body {
         background: #000 url(images/League_of_Legends_Battle_Background.jpg);
         background-size: cover;
         background-position: center;
         background-attachment: fixed;
    }
    #wrapper {
        width: 100%;
        height: auto;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }
        #ad1 {
            flex: 1;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #main {
            flex: 4;
            width: 100%;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 51, 102, 0.5);
            border-right: .15vmax solid rgb(240, 150, 65);
            border-left: .15vmax solid rgb(240, 150, 65);
            border-bottom: .15vmax solid rgb(240, 150, 65);
            text-align: center;
            flex-flow: column nowrap;
            font-family: 'Merriweather Sans', sans-serif;
            font-weight: 200;
        }
        #main > div {
            flex: 1;
        }
            #notes,
            #credit,
            #notice {
                width: 100%;
                height: auto;
                flex: 1;
                text-align: center;
                font-size: calc(.5em + 3vmax);
                color: white;
                text-decoration: overline;
            }
            #body {
                flex: 7;
                height: auto;
                width: 100%;
                color: white;
                text-align: left;
                font-size: calc(.5em + 1vmax);
            }
            h1 {
                color: white;
                font-size: calc(.5em + 1vmax);
            }
                #body span {
                    text-decoration: underline;
                    font-size: calc(.5em + 1.5vmax);
                }
                    #body ul {
                        margin-top: 3%;
                    }
                            #body li {
                                margin-top: 2%;
                            }
        #ad2 {
            flex: 1;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #ad3 {
            width: 100%;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5%;
            margin-bottom: 5%;
        }
        @media (max-width: 750px) {
            #ad1, #ad2 {
                visibility: hidden;
                display: none;
                flex: 0;
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
                                <li><a style="font-family: 'Righteous', cursive;" href="recents.php">Recents</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="playercard.php">Playercard</a></li>
                <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">Game&nbsp;Info</a></li>
                <li style="background: none;"><a title="Under Development" style="color: darkred;font-family: 'Righteous', cursive;" href="#0">PB&nbsp;Analytics</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="#" style="color: gray; text-decoration: overline;">Developer</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="includes/logout.inc.php">Logout</a></li>
            </ul>
          </div>
    </header>
    <div id="wrapper">
        <div id="ad1">
            <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=14&l=ur1&category=computers_accesories&banner=09X96K4BJ164TAQ1EJR2&f=ifr&linkID=0f38e94b229c451ca6d090d245e6b38e&t=pvp0e-20&tracking_id=pvp0e-20" width="160" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0">
            </iframe>
            <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=14&l=ur1&category=gold&banner=03XNA10Y90SRJTP9Z282&f=ifr&linkID=1c0d45570c81ce00aea4ae9d54f3c401&t=pvp0e-20&tracking_id=pvp0e-20" width="160" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0">
            </iframe>
        </div>
        <div id="main">
             <div>
                <div id="notice" style="margin-top: 5%;">
                    NOTICE
                </div>
                <div id="body">
                    <ul>
                        <span>I'M NOT RITO</span>
                        <li>
                            PvPCrunch isn't endorsed by Riot Games and doesn't reflect the views or opinions of Riot Games or anyone officially involved in producing or managing League of Legends. League of Legends and Riot Games are trademarks or registered trademarks of Riot Games, Inc. League of Legends © Riot Games, Inc.
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div id="notes" style="margin-top: 5%;">
                    DEVELOPER NOTES
                </div>
                <h1>*AWAITING APPLCIATION APPROVAL BEFORE OFFICIAL LAUNCH</h1>
                <div id="body">
                    <ul>
                        <span>On the way!</span>
                        <li>
                            A suggestion box on this page for YOUR ideas. | DEVELOPER
                        </li>
                        <li>
                            Mobile versions of existing pages | ALL
                        </li>
                        <li>
                            Basic account features and management system | SETTINGS
                        </li>
                        <li>
                            Informative drop-downs for an in-depth look at stats  | RECENTS
                        </li>
                        <li>
                            Access to the Dashboard, an UI with interactive charts and diagrams to filter and break down gampeplay. Manage and save game information and displays, creating a personal page unique to this site | DASHBOARD
                        </li>
                        <li>
                            Better support for Firefox. | ALL
                        </li>
                    </ul>
                     <ul>
                        <span>Backlog</span>
                        <li>
                            Better information present at first-look | RECENTS
                        </li>
                        <li>
                            Searchbar for champion buttons | PLAYERCARD
                        </li>
                        <li>
                            Access to the game information page for map, item, champion, and ability specifics | GAME INFO
                        </li>
                        <li>
                            Updated champion portraits | ALL
                        </li>
                        <li>
                             Access to the PBAnalytics (Playerbase Analytics) page, which runs numbers from the sites users, generating ranks, averages, and general comparisons. | PBANALYTICS
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div id="credit" style="margin-top: 5%;">
                    CREDIT
                </div>
                <div id="body">
                    <ul>
                        <span>SVGs</span>
                        <li>
                            Rockicon @ the Noun Project | Coin
                        </li>
                        <li>
                            Store Black @ the Noun Project | Hat
                        </li>
                        <li>
                            iconsmind.com @ the Noun Project | Wolf
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="ad2">
<a target="_blank"  href="https://www.amazon.com/gp/offer-listing/B0153XHRPY/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B0153XHRPY&linkCode=am2&tag=pvp0e-20&linkId=83a3f95ac902d4b51c656e5b3cc993a4"><img border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=US&ASIN=B0153XHRPY&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL250_&tag=pvp0e-20" ></a><img src="//ir-na.amazon-adsystem.com/e/ir?t=pvp0e-20&l=am2&o=1&a=B0153XHRPY" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
        </div>
    </div>
    <div id="ad3">
        <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=48&l=ur1&category=game_downloads&banner=07YBAJRZ4ZYJNPDJS3G2&f=ifr&linkID=49e8c599c08d2c296c79e8dab103a107&t=pvp0e-20&tracking_id=pvp0e-20" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
        <a target="_blank"  href="https://www.amazon.com/gp/offer-listing/B0153X7HKY/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B0153X7HKY&linkCode=am2&tag=pvp0e-20&linkId=d7ba82e838cf19b46902e716010adf08"><img border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=US&ASIN=B0153X7HKY&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL250_&tag=pvp0e-20" ></a><img src="//ir-na.amazon-adsystem.com/e/ir?t=pvp0e-20&l=am2&o=1&a=B0153X7HKY" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
    </div>
</body>
</html>
