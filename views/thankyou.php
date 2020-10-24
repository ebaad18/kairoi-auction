<?php 
require_once("../../../../wp-load.php");
get_header(); //import header

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
  
?>
<head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<div class="nav-bar-icon" onclick="openNav()">&#9776;</div>
<div class="mobile-center" style="position:relative; max-height:80%; max-width:100%; text-align:center; margin-top: 10%;" >
    
    <h2 class="thank-you-heading"  style="position:absolute;
    z-index:3; 
    top: -0%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> Thank you for engaging!</h2> 
    <image class="thank-page-bg" src="../../../wp-content/plugins/kairoiauction/assets/thank-page-bg.png" >

    <a class="thank-page-bid-link" href="../../../" style="position:absolute; 
    top: 95%;
    left:33%;
    height:27%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;"><img style="height:50px;width:50px;diplay:inline" src="../../../wp-content/plugins/kairoiauction/assets/loop.png"><h4 style="display:inline;vertical-align:20px;">Bid</h4></a>
    
    <a class="thank-page-vote-link" href="../../vote/" style="position:absolute; 
    top: 95%;
    left:68%;
    height:27%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;"><img style="height:50px;width:50px;diplay:inline" src="../../../wp-content/plugins/kairoiauction/assets/loop.png"><h4 style="display:inline;vertical-align:20px;">Vote</h4></a>
</div>

<div class="footer-div">
  <div class="col-img" style="width:12%;background:#44474c;float:left;padding:10px;width:100px;">
  <img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg">
  </div>
  <div class="col-empty">
  </div>
  <div class="col-text">
    <h4 style="font-family:'Raleway';color:white">Total Time: <?php echo $total_time ?></h4>
  </div>
  <div class="col-text">
    <h4 style="font-family:'Raleway';color:white">Time Left: <?php echo ($total_time - $time_consumed) ?> </h4>
  </div>
  <div class="col-text mobile-hide">
    <h4 style="font-family:'Raleway';color:white">Time in Auction: <?php echo $time_in_auction ?></h4>
  </div>
  <div class="col-text mobile-hide">
    <h4 style="font-family:'Raleway';color:white">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h4>
  </div>
  <div class="col-empty mobile-hide">
  </div>
  <div class="col-img" style="width:150px;margin-top:10px;">
    <img src="https://kairoi.in/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web-1.png">
  </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/about"><h5>About</h5></a>
    <a href="/instructions"><h5>Instructions</h5></a>
    <a href="/rules"><h5>Rules</h5></a>
    <a href="/winners"><h5>Winners</h5></a>
    <a href="/contact"><h5>Contact</h5></a>
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