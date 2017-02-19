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
                background: #000 url(images/swainbg.jpg) no-repeat fixed;
                background-position: center;
                background-size: cover;
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
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                    #intro-container > div {
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

                                    }
                                    #intro-container > div > form > div > div > select {
                                        width: 80%;
                                        height: 7.5vh;
                                    }
                                    #intro-container > div > form > div > div > button {
                                        width: 40%;
                                        height: calc(1.5em + 2.25vmax);
                                        background-color: rgba(240, 150, 65, .85);
                                        border-color: black;
                                        font-size: calc(.5em + .5vmax);
                                        font-color: gray;
                                    }
                                        #intro-container > div > form > div > div > button:hover {
                                            border-color: lightgray;
                                        }
            @media (max-width: 750px)  {
                #intro-container > div {
                    width: 90vw;
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
                <li><a style="font-family: 'Righteous', cursive;" href="developer.html">DEVELOPER</a></li>
            </ul>
            </div>
        </header>
        <!--Introduction Section-->
        <section id="intro-section">
            <!--Intro Div Container-->
            <div id="intro-container">
                <div>
                    <!--Create Account-->
                    <form action="includes/signup.inc.php" method="POST">
                        <div>
                            <div>
                                <span>Create an account</span>
                            </div>
                            <div>
                                <input type="text" name="Ruid" placeholder="Username | DISABLED 'TIL LAUNCH" required>
                            </div>
                            <div>
                                <input title="8-character minimum" type="password" name="Rpwd" placeholder="Password | DISABLED 'TIL LAUNCH" required>
                            </div>
                            <div>
                                <select name="Rrgn" required>
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
                                <input type="text" name="Rsn" placeholder="Summoner Name | DISABLED 'TIL LAUNCH" required>
                            </div>
                            <div>
                                <button type="submit">Create&nbsp;Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </body>
</html>
