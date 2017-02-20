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
        <link href="https://fonts.googleapis.com/css?family=Righteous|Sarpanch:900" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="navbar.css" />

        <style>
            html, body {margin: 0; padding: 0;}
            body {
                background: #ccc url(images/League_of_Legends_Battle_Background.jpg) no-repeat fixed;
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
            #main {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                    -ms-flex-align: center;
                        align-items: center;
                -webkit-box-pack: center;
                    -ms-flex-pack: center;
                        justify-content: center;
                width: 100%;
                height: 92.5%;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                    -ms-flex-flow: column nowrap;
                        flex-flow: column nowrap;
            }
                #main > #main-image {
                    width: 100%;
                    height: 100%;
                    -webkit-box-flex:4;
                        -ms-flex:4;
                            flex:4;
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
                    #main > #main-image img {
                        width: 60vw;
                        height: 25vw;  
                    }
                #main > #main-subhead {
                    width: 100%;
                    height: 100%;
                    -webkit-box-flex: 1;
                        -ms-flex: 1;
                            flex: 1;
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
                    #main > #main-subhead span {
                        color: rgba(240, 150, 65, 1);
                        font-size: 3vmax;
                        font-weight: 300;    
                        font-family: 'Sarpanch', sans-serif;
                    }
        </style>
    </head>
    <!--Disable dragging-->
    <body ondragstart="return false;" ondrop="return false;">
        <!--Landing page header-->
    <header id="site-header">
        <div>
        <ul>
            <li><a style="font-family: 'Righteous', cursive;" href="#">HOME</a></li>
            <li><a style="font-family: 'Righteous', cursive;" href="login.php">LOGIN</a></li>
            <li><a style="font-family: 'Righteous', cursive;" href="signup.php">SIGN UP</a></li>
            <li><a style="font-family: 'Righteous', cursive;" href="developer.html">DEVELOPER</a></li>
        </ul>
        </div>
    </header>
        <div id="main">
            <div id="main-image">
                <img src="images/LOGO.png" />
            </div>
            <div id="main-subhead">
                <span>Review & Improve Your Game.</span>
            </div>
        </div>
    </body>
</html>
