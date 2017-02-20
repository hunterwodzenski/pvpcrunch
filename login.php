<?php
    session_start();
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
        <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="navbar.css" />

        <style>
    
            html, body {margin: 0; padding: 0;}
            body {
                background: #000 url(images/corkybg.jpg) no-repeat fixed;
                background-position: center;
                background-size: cover;
                user-select: none;
            }
            #or {
                color: rgb(240, 150, 65);
                font-size: calc(1em + .5vmax);
            }

            /*INTRODUCTION SECTION*/
            #intro-section {
                width: 100%;
                height: 92.5%;
                background: transparent;
            }
                #intro-container{
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                    #intro-container > div:not(:nth-child(1)):not(:nth-child(3)) {
                        width: 35vw;
                        height: 65%;
                        background-color: rgba(0, 51, 102, 0.75);
                        border-radius: 5%;
                        display: flex;
                        align-items: flex-start;
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
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                flex-flow: column nowrap;
                            }
                                #intro-container > div > form > div > div {
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
                                    #intro-container > div > form > div > div > button {
                                        width: 40%;
                                        height: 7.5vh;
                                        background-color: transparent;);
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
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }
            @media (max-width: 750px)  {
                #intro-container > div:not(:nth-child(1)):not(:nth-child(3)) {
                    width: 90vw;
                }
                #intro-container > div:not(:nth-child(2)) {
                    visibility: hidden;
                    display: none;
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
                <li><a style="font-family: 'Righteous', cursive;" href="#">LOGIN</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="signup.php">SIGN UP</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="developer.html">DEVELOPER</a></li>
            </ul>
            </div>
        </header>
        <!--Introduction Section-->
        <section id="intro-section">
            <!--Intro Div Container-->
            <div id="intro-container">
                <div id="ad">
                    <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=14&l=ur1&category=gift_certificates&banner=0S32YAVKXXKQGNQSSGG2&f=ifr&linkID=8b513d59cd243260a71b27c32dbe6245&t=pvp0e-20&tracking_id=pvp0e-20" width="160" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
                </div>
                <div>
                    <form action="includes/login.inc.php" method="POST">
                        <div>
                            <div>
                                <span>Login</span>
                            </div>
                            <div>
                                <input type="text" name="Luid" placeholder="Username" required>
                            </div>
                            <div>
                                <input type="password" name="Lpwd" placeholder="Password" required>
                            </div>
                            <div>
                                <button onclick="">Login</button>
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
