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
h1::before,h2::before,h3::before{
    content:none;
}
hr{
    width:20%;
    color: #44474c;
    border-top: 1px dashed #2bbdcd;
}
.winner-description{
    font-size:30px;
}
@media only screen and (max-width: 600px) {
    h1,h2{
        font-size:99% !important;
    }
    .winner-description{
    font-size:19px;
}
}
</style>
<div class="nav-bar-icon-pages" onclick="openNav()">&#9776;</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 most-recent">
            <h2 style="color:#2bbdcd;transform: rotateZ(270deg);margin-top:100%;margin-left:24%;text-align:right;border-bottom:2px dashed #2bbdcd">Most Recent</h2>  
        </div>
        <div class="col-sm-8">
            <h1 style="text-align:center;margin-bottom:4%;"><b class="contact-page-heading">Winners</b></h1>
            <h2><?php if($array_for_slot_time[0]=='1440'){ echo "&nbsp;1 day&nbsp;";}elseif($array_for_slot_time[0]=='720'){ echo "12 hours"; }elseif($array_for_slot_time[0]=='360'){ echo "6 hours"; }elseif($array_for_slot_time[0]=='60'){ echo "1 hour"; }elseif($array_for_slot_time[0]=='30'){ echo "30 minutes"; }elseif($array_for_slot_time[0]=='15'){ echo "15 minutes"; }else{ echo "5 minutes";}?> <span style="color:#2bbdcd">//</span> <span class="winner-description"><?php echo $array_for_description[0]; ?> </span><span style="color:#2bbdcd"> by <?php echo $array_for_nickname[0]; ?> </span></h2>
            <h2><?php if($array_for_slot_time[1]=='1440'){ echo "&nbsp;1 day&nbsp;";}elseif($array_for_slot_time[1]=='720'){ echo "12 hours"; }elseif($array_for_slot_time[1]=='360'){ echo "6 hours"; }elseif($array_for_slot_time[1]=='60'){ echo "1 hour"; }elseif($array_for_slot_time[1]=='30'){ echo "30 minutes"; }elseif($array_for_slot_time[1]=='15'){ echo "15 minutes"; }else{ echo "5 minutes";}?> <span style="color:#2bbdcd">//</span> <span class="winner-description"><?php echo $array_for_description[1]; ?> </span><span style="color:#2bbdcd"> by <?php echo $array_for_nickname[1]; ?> </span></h2>
            <h2><?php if($array_for_slot_time[2]=='1440'){ echo "&nbsp;1 day&nbsp;";}elseif($array_for_slot_time[2]=='720'){ echo "12 hours"; }elseif($array_for_slot_time[2]=='360'){ echo "6 hours"; }elseif($array_for_slot_time[2]=='60'){ echo "1 hour"; }elseif($array_for_slot_time[2]=='30'){ echo "30 minutes"; }elseif($array_for_slot_time[2]=='15'){ echo "15 minutes"; }else{ echo "5 minutes";}?> <span style="color:#2bbdcd">//</span> <span class="winner-description"><?php echo $array_for_description[2]; ?> </span><span style="color:#2bbdcd"> by <?php echo $array_for_nickname[2]; ?> </span></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br>
</div>

<div class="footer-div">
  <div class="col-img-1" style="background:#44474c;float:left;padding:10px;">
  <a href="https://www.facebook.com/fivemillionincidents/"><img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg"></a>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Total Time: <?php echo $total_time ?></h5>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time Left: <?php echo ($total_time - $time_consumed) ?> </h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time in Auction: <?php echo $time_in_auction ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h5>
  </div>
  <div class="col-img-2" style="margin-top:5px;">
    <a href="https://www.goethe.de/ins/in/en/m/kul/sup/fmi.html"><img src="https://kairoi.in/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web-1.png"></a>
  </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/about"><h5>About</h5></a>
    <br>
    <a href="/instructions"><h5>Instructions</h5></a>
    <br>
    <a href="/rules"><h5>Rules</h5></a>
    <br>
    <a href="#"><h5>Winners</h5></a>
    <br>
    <a href="/contact"><h5>Contact</h5></a>
    <hr style="margin-left:25px;width:30%;color:#2bbdcd"  align="left">
    <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
    <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:35px;color:#ffffff;"></i></a>
    <a href="https://www.facebook.com/kairoi.auction" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:30px;color:#ffffff;"></i></a>
    <a href="mailto:auction@kairoi.in" style="display:inline" target="_blank"><i class="fa fa-google" style="font-size:30px;color:#ffffff;"></i></a>
    <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:35px;color:#ffffff;padding-left:20px;cursor:pointer"></i>      
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