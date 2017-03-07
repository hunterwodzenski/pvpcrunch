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
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: start;
            -ms-flex-align: start;
                align-items: flex-start;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
    }
        #ad1 {
            -webkit-box-flex: 1;
                -ms-flex: 1;
                    flex: 1;
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
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-flow: column nowrap;
                    flex-flow: column nowrap;
        }
        #ad1 > div {
            -webkit-box-flex: 1;
                -ms-flex: 1;
                    flex: 1;
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
        }
        #main {
            -webkit-box-flex: 4;
                -ms-flex: 4;
                    flex: 4;
            width: 100%;
            height: auto;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
            background-color: rgba(0, 51, 102, 0.5);
            border-right: .15vmax solid rgb(240, 150, 65);
            border-left: .15vmax solid rgb(240, 150, 65);
            border-bottom: .15vmax solid rgb(240, 150, 65);
            text-align: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-flow: column nowrap;
                    flex-flow: column nowrap;
            font-family: 'Merriweather Sans', sans-serif;
            font-weight: 200;
        }
        #main > div {
            -webkit-box-flex: 1;
                -ms-flex: 1;
                    flex: 1;
        }
            #notes,
            #credit,
            #notice {
                width: 100%;
                height: auto;
                -webkit-box-flex: 1;
                    -ms-flex: 1;
                        flex: 1;
                text-align: center;
                font-size: calc(.5em + 3vmax);
                color: white;
                text-decoration: overline;
            }
            #body {
                -webkit-box-flex: 7;
                    -ms-flex: 7;
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
            -webkit-box-flex: 1;
                -ms-flex: 1;
                    flex: 1;
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
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-flow: column nowrap;
                    flex-flow: column nowrap;
        }
        #ad2 > div {
            -webkit-box-flex: 1;
                -ms-flex: 1;
                    flex: 1;
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
        }
        #ad3 {
            width: 100%;
            height: auto;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
            margin-top: 5%;
            margin-bottom: 5%;
        }
        @media (max-width: 750px) {
            #ad1, #ad2 {
                visibility: hidden;
                display: none;
                -webkit-box-flex: 0;
                    -ms-flex: 0;
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
                    <li><a style="font-family: 'Righteous', cursive;" href="#"  style="color: gray; text-decoration: overline;">Developer</a></li>
                    <li><a style="font-family: 'Righteous', cursive;" href="includes/logout.inc.php">Logout</a></li>
                </ul>
              </div>
        </header>
    <div id="wrapper">
        <div id="ad1">
            <div>
                <iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=US&source=ss&ref=as_ss_li_til&ad_type=product_link&tracking_id=pvp0e-20&marketplace=amazon&region=US&placement=B014X427WM&asins=B014X427WM&linkId=d7e599515eeec9aa5c4f48b5182a8dd0&show_border=true&link_opens_in_new_window=true"></iframe>
            </div>
            <div>
                <iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=US&source=ss&ref=as_ss_li_til&ad_type=product_link&tracking_id=pvp0e-20&marketplace=amazon&region=US&placement=B0153XBEBM&asins=B0153XBEBM&linkId=0f460222934ff2ae7f094d3bd76c8b7e&show_border=true&link_opens_in_new_window=true"></iframe>
            </div>
        </div>
        <div id="main">
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
            <div>
                <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=29&l=ur1&category=mostwishforitem&banner=16FJBX4VDZHER5Y2EMG2&f=ifr&linkID=ea906fb79ea3caf159d37b7e661f7618&t=pvp0e-20&tracking_id=pvp0e-20" width="120" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    <div id="ad3">
        <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=48&l=ur1&category=game_downloads&banner=07YBAJRZ4ZYJNPDJS3G2&f=ifr&linkID=49e8c599c08d2c296c79e8dab103a107&t=pvp0e-20&tracking_id=pvp0e-20" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
    </div>
</body>
</html>

