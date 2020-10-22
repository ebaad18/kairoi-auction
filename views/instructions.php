<?php 
require_once("../../../../wp-load.php");
get_header(); //import header      
?>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
.site{
    background: url('wp-content/plugins/kairoiauction/assets/content-bg.jpg');
    background-repeat: no-repeat;
    background-size: 100%;
}
.container-fluid{
    margin-top:10%;
    margin-right:0px;
    margin-left:0px;
    text-align:left;
    font-family:'Raleway';
    color: white;
    background:#44474ccc;
}
a{
    color:white !important;
    text-decoration:underline;
}
a:hover{
    color:white;
    opacity:0.9;
}
h2::before{
    content:none;
}
hr{
    width:20%;
    color: #44474c;
    border-top: 1px dashed #00687f;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <h2><b>Instructions</b></h2>
            <h3><b>Instructions to bid</b></h3>
            <h4>Step 1: Select the time you want to bid for and go to bidding section.</h4>
            <h4>Step 2: Bid by writing the activity you would be willing to do for that duration of time. Read the <a href="rules">rules</a> to keep in mind while deciding the activity. Note that the auction is non-monetary and the agency over the time can only be occuppied or possessed through an activity/ task.</h4>
            <h4>Step 3: Submit your bid. You can continue to bid for a different duration or go to vote.</h4>
            <hr align="left">
            <h3><b>Instructions to vote</b></h3>
            <h4>Step 1: Select on the time you want to vote for and go to voting section.</h4>
            <h4>Step 2: Vote on the activity that you find most deserving to win in order to occupy that duration of time.</h4>
            <h4>Step 3: Submit your vote. You can continue to vote for a different duration/ timeslot or go to bid. Note that you can only vote once in any given timeslot.</h4>    
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>