<?php
    session_start();
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
        <link href="https://fonts.googleapis.com/css?family=Righteous|Sarpanch:900" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="navbar.css" />

        <style>
            html, body {margin: 0; padding: 0;}
            body {
                background: #ccc url(images/League_of_Legends_Battle_Background.jpg) no-repeat fixed;
                background-position: center;
                background-size: cover;
                user-select: none;
            }
            #or {
                color: rgb(240, 150, 65);
                font-size: calc(1em + .5vmax);
            }
            #main {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 92.5%;
                flex-flow: column nowrap;
            }
                #main > #main-image {
                    width: 100%;
                    height: 100%;
                    flex:4;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                    #main > #main-image img {
                        width: 60vw;
                        height: 25vw;  
                    }
                #main > #main-subhead {
                    width: 100%;
                    height: 100%;
                    flex: 1;
                    display: flex;
                    align-items: flex-start;
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
                <li><a style="font-family: 'Righteous', cursive;" href="index.php">HOME</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="login.php">LOGIN</a></li>
                <li><a style="font-family: 'Righteous', cursive;" href="signup.php">SIGN UP</a></li>
            </ul>
            </div>
        </header>
        <div id="main">
            <div id="main-image">
                <img src="images/LOGO.png" />
            </div>
            <div id="main-subhead">
                <span>Improve Your Game.</span>
            </div>
        </div>
    </body>
</html>