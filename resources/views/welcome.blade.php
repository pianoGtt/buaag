{{--<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BUAAG</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Beihang University Group
                </div>

                <div class="links">
                    <a href="#">Documentation</a>
                    <a href="#">News</a>
                    <a href="#">Forge</a>
                    <a href="#">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>--}}

<!DOCTYPE HTML>
<!--@author yang-->
<html>
    <head>
        <title>贪吃蛇</title>
        <link rel="stylesheet" type="text/css" href="/css/snake.css">
    </head>
    <body>
        <canvas id="canvas" width="500" height="500"></canvas>
            <div id="markpad">
                <p>Score:<span id="score">0</span></p>
                <p>Level:<span id="level">1</span></p>
                <p><font size="1">按回车开始游戏</font></p>
            </div>
        <script src="/js/snake.js" type="text/javascript"></script>
    </body>
</html>
