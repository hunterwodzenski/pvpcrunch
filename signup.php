<?php
    session_start();
?>
<html>
    <!--Copyright 2017 PvPCrunch-->
    <head>
        <title>
            PvPCrunch | Signup | League of Legends Stats | Summoner Profile Creation
        </title>
        
        <meta name="copyright" content="PvPCrunch">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="description" content="Create your PvPCrunch account here! You must sign-up/register to enjoy access to your personal Summoner profile and view game information.">

        <!--Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="navbar.css" />

        <style>
            html, body {margin: 0; padding: 0;}
            body {
                background: #000 url(images/swainbg.jpg) no-repeat fixed;
                background-position: center;
                background-size: cover;
                -webkit-user-select: none;
                   -moz-user-select: none;
                    -ms-user-select: none;
                        user-select: none;
            }
            #or {
                color: rgb(240, 150, 65);
                font-size: calc(1em + .5vmax);
            }
            #intro-section {
                width: 100%;
                height: 92.5%;
                background: transparent;
            }
                #intro-container{
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
                    #intro-container > div:not(:nth-child(1)):not(:nth-child(3)) {
                        width: 35vw;
                        height: 65%;
                        background-color: rgba(0, 51, 102, 0.75);
                        border-radius: 5%;
                        display: -webkit-box;
                        display: -ms-flexbox;
                        display: flex;
                        -webkit-box-align: start;
                            -ms-flex-align: start;
                                align-items: flex-start;
                        -webkit-box-pack: center;
                            -ms-flex-pack: center;
                                justify-content: center;
                        border: .15em solid rgb(240, 150, 65);
                    }
                        #intro-container > div > form {
                            background: transparent;
                            width: 100%;
                            height: 100%;
                            text-align: center;
                        }
                            #intro-container > div > form > div {
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
                                #intro-container > div > form > div > div {
                                    -webkit-box-flex: 1;
                                        -ms-flex: 1;
                                            flex: 1;
                                    width: 100%;
                                    height: 100%;
                                }
                                    #intro-container > div > form > div > div > span {
                                        color: #F0F0F0;
                                        font-size: calc(1em + 2.5vmax);    
                                    }
                                    #intro-container > div > form > div > div > input {
                                        width: 80%;
                                        height: 7.5vh;
                                        border: .15em solid lightgray;
                                        background-color: #F0F0F0;
                                        font-size: calc(1em + .75vmax);

                                    }
                                    #intro-container > div > form > div > div > select {
                                        width: 80%;
                                        height: 7.5vh;
                                        font-size: calc(1em + .75vmax);
                                    }
                                        #intro-container > div > form > div > div > select > option {
                                            font-size: calc(.25em + .75vmax);
                                        }
                                    #intro-container > div > form > div > div > button {
                                        width: 40%;
                                        height: 7.5vh;
                                        background-color: transparent;
                                        border: .15em solid lightgray;
                                        border-radius: 30% 0 0 0;
                                        font-size: calc(.5em + 1vmax);
                                        color: lightgray;
                                    }
                                        #intro-container > div > form > div > div > button:hover {
                                            border-color: rgb(240, 150, 65);
                                            color: rgb(240, 150, 65);
                                        }
            #intro-container > div:not(:nth-child(2)) {
                width: 30vw;
                height: 100%;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                    -ms-flex-align: center;
                        align-items: center;
                -webkit-box-pack: start;
                    -ms-flex-pack: start;
                        justify-content: flex-start;
            }
            @media (max-width: 750px)  {
                #intro-container > div:not(:nth-child(1)):not(:nth-child(3)) {
                    width: 90vw;
                }
                #intro-container > div:not(:nth-child(2)) {
                    visibility: hidden;
                    display: none;
                    -webkit-box-flex: 0;
                        -ms-flex: 0;
                            flex: 0;
                }
            }
        </style>
    </head>
    <!--Disable dragging-->
    <body ondragstart="return false;" ondrop="return false;">
        <!--Landing page header-->
        <header id="site-header">
            <div>
            <ul>
                <li><a style="font-family: 'Righteous', cursive;" href="index.php">HOME</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="login.php">LOGIN</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="#">SIGN UP</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="developer.html">DEVELOPMENT</a></li>
            </ul>
            </div>
        </header>
        <!--Introduction Section-->
        <section id="intro-section">
            <!--Intro Div Container-->
            <div id="intro-container">
                <div id="ad">
                    <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=14&l=ur1&category=primegift&banner=0ZWKW7ZFNM91W64BCX02&f=ifr&linkID=83dbf0855e74a700783f6e7c56b8aaf7&t=pvp0e-20&tracking_id=pvp0e-20" width="160" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
                </div>
                <div>
                    <!--Create Account-->
                    <form action="includes/signup.inc.php" method="POST">
                        <div>
                            <div>
                                <span>Disabled Until Launch</span>
                            </div>
                            <div>
                                <input type="text" name="Ruid" placeholder="Username" required disabled>
                            </div>
                            <div>
                                <input title="8-character minimum" type="password" name="Rpwd" placeholder="Password" required disabled>
                            </div>
                            <div>
                                <select name="Rrgn" required disabled>
                                    <option value="" disabled selected>Region</option>
                                    <option value="na">North America [NA]</option>
                                    <option value="eune">Europe Nordic & East [EUNE]</option>
                                    <option value="euw">Europe West [EUW]</option>
                                    <option value="jp">Japan [JP]</option>
                                    <option value="kr">Korea [KR]</option>
                                    <option value="lan">Latin America North [LAN]</option>
                                    <option value="las">Latin America South [LAS]</option>
                                    <option value="oce">Oceania [OCE]</option>
                                    <option value="ru">Russia [RU]</option>
                                    <option value="tr">Turkey [TR]</option>
                                </select>
                            </div>
                            <div>
                                <input type="text" name="Rsn" placeholder="Summoner Name" required disabled>
                            </div>
                            <div>
                                <button type="submit" disabled>Create&nbsp;Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="ad">
                </div>
            </div>
        </section>
    </body>
</html>
