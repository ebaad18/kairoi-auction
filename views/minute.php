<?php 

require_once("../../../../wp-load.php");
get_header(); //import header 
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
  
// Here append the common URL characters. 
$link .= "://"; 
  
// Append the host(domain name, ip) to the URL. 
$link .= $_SERVER['HTTP_HOST']; 
  
// Append the requested resource location to the URL 
$link .= $_SERVER['REQUEST_URI']; 
      
// Print the link 
// echo $link;

$parts = parse_url($link);

//for offset parameters
$broken_parts= @explode('-', $parts[path]); //@ is used to suppress warnings
$time_from_url = end($broken_parts); //fetches time of slot from URL
$time_from_url = rtrim($time_from_url,'/');


?>

<?php
global $time_from_url; //making it global for usage in all of the code
$table_name = 'wp_kairoi_slot_time'; 
global $wpdb;
global $no_of_bids;
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE time = $time_from_url
        "
    );  
foreach($details as $key=>$val)
    {			
        $slot_time_sno = $val->slot_time_sno;
        $max_no = $val->max_no;
    }

//get slots of a particular minute

global $wpdb;
global $count;
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

get_slot_sno();

function get_slot_sno(){
    global $slot_time_sno;
    global $wpdb;
    global $count;
    $count = 0;
    global $slot_sno;
    global $no_of_bids;
    global $max_no;

    $table_name = 'wp_kairoi_slots'; //getting all slots of a particular time that was fetched from the URL
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            WHERE slot_time_sno = $slot_time_sno
            "
        );  
    foreach($details as $key=>$val)
        {	
            $slot_sno = $val->slot_sno;	
            $no_of_bids = $val->no_of_bids;	
            $count++;
            
        }  
    if ($count == 0) //if there are no slots, then make one
    {
        global $slot_time_sno;
        global $wpdb;
        $wpdb->insert("wp_kairoi_slots", array(
        "slot_time_sno" => $slot_time_sno,
        "no_of_bids" => 0,
        "voted_ips" => '',
        "created_on" => date('Y-m-d H:i:s'),
        ));
        get_slot_sno(); 
    } 
    else{
        //if there are slots, then check if the maximum number of slots allowed are not exceeded
        if($count <= $max_no){
            //if the number of slots do not exceed the maximum number then check if the previous slot has 5 bids or not. If yes, make another slot
            if( $no_of_bids >=5){
                global $slot_time_sno;
                global $wpdb;
                $wpdb->insert("wp_kairoi_slots", array(
                "slot_time_sno" => $slot_time_sno,
                "no_of_bids" => 0,
                "voted_ips" => '',
                "created_on" => date('Y-m-d H:i:s'),
                ));
                get_slot_sno();
            }
        }
        //if number of slots are equal to the max number allowed, then send a notification that mor slots cannot be made
        else{
            echo "<div id='snackbar'>All slots have been bidded on.</div>
    
            <script>

            var x = document.getElementById('snackbar');
            x.className = 'show';
            setTimeout(function(){ x.className = x.className.replace('show', ''); }, 3000);

            </script>";
            echo "<a style='text-align:center'  href='vote/'>Vote</a>";
            exit();
        }
    }  
}    
?>  
<head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<div class="nav-bar-icon" onclick="openNav()">&#9776;</div>
<div class="mobile-center" style="position:relative; max-height:80%; max-width:100%;text-align:center" > 
<div style="position:relative; max-height:80%; max-width:100%; text-align:center; margin-top: 10%;" >

    
    <h2 class="minute-heading"  style="z-index:3;
    position:absolute; 
    top: 0%;
    left:51%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <?php echo $time_from_url; ?> minutes</h2> 
    <image class="minute-page-bg" src="../wp-content/plugins/kairoiauction/assets/minute-page-bg.png" >
    <h3><a class="minute-page-bid-link" href="slot-<?php echo $slot_sno?>/bid/" style="position:absolute; 
    top: 85%;
    left:28%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;
    font-family:Raleway;">Start bidding</a></h3>
    
    <h3><a class="minute-page-vote-link" href="vote/" style="position:absolute; 
    top: 85%;
    left:72%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;
    font-family:Raleway;">Vote bid</a></h3>
</div>
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