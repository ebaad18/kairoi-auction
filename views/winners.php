<?php 
require_once("../../../../wp-load.php");
get_header(); //import header  

$array_for_description = array(); 
$array_for_nickname = array(); 
$array_for_slot_time = array(); 
$count = 0;

$table_name = 'wp_kairoi_auction_master'; //getting auction master for footer
global $wpdb;
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        "
    );  
foreach($details as $key=>$val)
    {			
        $total_time = $val->total_time;
        $time_consumed = $val->time_consumed;
        $time_in_auction = $val->time_in_auction;
    }

$table_name = 'wp_kairoi_winners'; //getting winners
global $wpdb;
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        "
    );  
foreach($details as $key=>$val)
    {			
        $nickname = $val->nickname;
        $description = $val->description;
        $slot_time = $val->slot_time;
        array_push($array_for_slot_time,$slot_time); //pushing the slot times in the array
        array_push($array_for_description,$description); //pushing the descriptions in the array
        array_push($array_for_nickname,$nickname); //pushing the nicknames in the array
        $count++;
    }



?>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- For navbar icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    background:#44474c;
}
a{
    color:white !important;
    text-decoration:underline;
}
a:hover{
    color:white;
    opacity:0.9;
}
h1::before,h2::before,h3::before{
    content:none;
}
hr{
    width:20%;
    color: #44474c;
    border-top: 1px dashed #00687f;
}
input[type="text"], input[type="email"]{
    height:65px;
    width:50%;
    font-size:24px;
    margin-top: 2%;
}
input[type="email"]{
    width:100%;
}
textarea{
    width:100%;
    font-size:24px;
    margin-top: 2%;

}
.contact-button{
    font-size:24px !important;
    border-radius: 0px !important;
    background:#00687f !important;
    padding:5px !important;
    color:white !important;
    font-family:'Raleway' !important;
    margin-top: 2% !important;
}
</style>
<div class="nav-bar-icon" onclick="openNav()">&#9776;</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 most-recent">
            <h2 style="color:#00687f;transform: rotateZ(270deg);margin-top:90%;margin-left:70%;text-align:right;border-bottom:2px dashed #00687f">Most Recent</h2>  
        </div>
        <div class="col-sm-8">
            <h1 style="text-align:center;margin-bottom:4%;"><b class="contact-page-heading">Winners</b></h1>
            <h2><?php echo $array_for_slot_time[0]; ?> minutes <span style="color:#00687f">//</span> <span style="font-size:40px;"><?php echo $array_for_description[0]; ?> </span><span style="color:#00687f"> by <?php echo $array_for_nickname[0]; ?> </span></h2>
            <h2><?php echo $array_for_slot_time[1]; ?> minutes <span style="color:#00687f">//</span> <span style="font-size:40px;"><?php echo $array_for_description[1]; ?> </span><span style="color:#00687f"> by <?php echo $array_for_nickname[1]; ?> </span></h2>
            <h2><?php echo $array_for_slot_time[2]; ?> minutes <span style="color:#00687f">//</span> <span style="font-size:40px;"><?php echo $array_for_description[2]; ?> </span><span style="color:#00687f"> by <?php echo $array_for_nickname[2]; ?> </span></h2>
            <h2><?php echo $array_for_slot_time[3]; ?> minutes <span style="color:#00687f">//</span> <span style="font-size:40px;"><?php echo $array_for_description[3]; ?> </span><span style="color:#00687f"> by <?php echo $array_for_nickname[3]; ?> </span></h2>
            <h2><?php echo $array_for_slot_time[4]; ?> minutes <span style="color:#00687f">//</span> <span style="font-size:40px;"><?php echo $array_for_description[4]; ?> </span><span style="color:#00687f"> by <?php echo $array_for_nickname[4]; ?> </span></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br><br><br><br><br><br><br>
    
</div>

<div style="border-top:1px solid white" class="footer-div">
  <div class="col-img" style="width:12%;background:#44474c;float:left;padding:10px;width:100px;">
  <img src="http://localhost/kairoi/wp-content/uploads/2020/10/fmi.jpg">
  </div>
  <div class="col-empty">
  </div>
  <div class="col-text">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Total Time: <?php echo $total_time ?></h3>
  </div>
  <div class="col-text">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Time Left: <?php echo ($total_time - $time_consumed) ?> </h3>
  </div>
  <div class="col-text mobile-hide">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Time in Auction: <?php echo $time_in_auction ?></h3>
  </div>
  <div class="col-text mobile-hide">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h3>
  </div>
  <div class="col-empty mobile-hide">
  </div>
  <div class="col-img" style="width:150px;margin-top:10px;">
    <img src="http://localhost/kairoi/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web.png">
  </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/about"><h5>About</h5></a>
    <a href="/instructions"><h5>Instructions</h5></a>
    <a href="/rules"><h5>Rules</h5></a>
    <a href="/winners"><h5>Winners</h5></a>
    <a href="#"><h5>Contact</h5></a>
    <hr style="width:40%;">
    <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
    <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:35px;color:#818181;"></i></a>
    <a href="https://www.facebook.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:35px;color:#818181;"></i></a>
    <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:35px;color:#818181;padding-left:20px;cursor:pointer"></i>      
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    function copy_url() {
        const el = document.createElement('textarea');
        el.value = "https://kairoi.in";
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert("Link copied to clipboard");
    }
</script>