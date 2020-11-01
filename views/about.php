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
    background-repeat: repeat;
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
    color:#2bbdcd !important;
    text-decoration:underline;
}
a:hover{
    color:white !important;
    opacity:0.9;
}
h2::before{
    content:none;
}
hr{
    width:20%;
    color: #2bbdcd;
    border-top: 1px dashed #2bbdcd;
}
</style>
<div class="nav-bar-icon-pages" onclick="openNav()">&#9776;</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <h2>About <b>KAIROI Time Auction</h2>
            <br>
            <h4>KAIROI Time Auction is an auction of time collected by a time-sensitive vending machine- KAIROI by <a style="color:#2bbdcd" href="https://sonamchaturvedi.com/"  target="_blank">sonam</a>. The machine is the closest embodiment of capitalism’s spatial and temporal shrinkage. Two vending machines were installed at Goethe-Institut/ Max Mueller Bhavan (New Delhi and Kolkata) for 6-months collecting time. Instead of money it took time as an input; one had to stand in front of the machine with one’s finger on the simulated-biometric scanner, and ‘spend’ time to get a product (snacks). A vending machine is the closest embodiment of capitalism’s spatial and temporal shrinkage, but here the role of money is displaced by time in the exchange economy. It forces the user to slow down and experience the passing of time to get something, instead of rushing to their speeding lives of infinite accumulation.<br><br>The time you see here i.e.33550 minutes [23 days: 7 hours: 10 minutes] has been accumulated by the machines from the users/ participants at the venues, and is put for auction here through non-monetary bids in the form of acts/ happenings. Go to <a style="color:#2bbdcd" href="instructions">instructions</a> to know how you can bid and get the agency to occupy this time. Read more about the machine and its documentation <a style="color:#2bbdcd" href="https://sonamchaturvedi.com/kairoi/" target="_blank">here</a>.</h4>
            <hr align="left">
            <h4><i>KAIROI is realised within the framework of Five Million Incidents 2019-2020 supported by Goethe-Institut / Max Mueller Bhavan in collaboration with Raqs Media Collective. Technical support: <a style="color:#2bbdcd" href="https://www.facebook.com/BananaHouseMakerspace/"  target="_blank">Banana House</a> (New Delhi) and <a style="color:#2bbdcd" href="https://www.linkedin.com/in/ebaad-ansari-8832b881/"  target="_blank">Ebaad Ansari</a>.</i></h4>
            <br><br><br><br><br><br><br><br>
        </div>
        <div class="col-sm-2"></div>
    </div>
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
    <a href="#"><h5>About</h5></a>
    <br>
    <a href="/instructions"><h5>Instructions</h5></a>
    <br>
    <a href="/rules"><h5>Rules</h5></a>
    <br>
    <a href="/winners"><h5>Winners</h5></a>
    <br>
    <a href="/contact"><h5>Contact</h5></a>
    <hr style="margin-left:25px;width:30%;color:#2bbdcd"  align="left">
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