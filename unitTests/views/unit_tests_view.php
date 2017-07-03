<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 7/2/2017
 * Time: 10:14 PM
 */
?>

<html>
<head>
    <title>UNIT TESTS SYSTEM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./views/resources/js/unitTests.js" type="text/javascript"></script>
    <style>
        #title{
            margin:0 auto;
        }

        #console{
            background-color: black;
            color: #dddddd;
            max-height: 550px;
            overflow: scroll;
        }

        #mainContent{
            height: 100%;
        }

        .max-width-1200-center{
            max-width: 1200px;
            margin:0 auto;

        }

        body{
            background-color: #f0f0f0;
        }


    </style>
</head>
<body>
<div id="mainContent" class="container max-width-1200-center">
    <H1 id="title">UNIT TESTS SYSTEM</H1>
    <div id="console" class="container">

    </div>
</div>

<script>unitTests.init()</script>
</body>
</html>

