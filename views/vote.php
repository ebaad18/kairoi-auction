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
$time_from_url = $broken_parts[1];
$time_from_url = rtrim($time_from_url,'/vote/sl');
$slot_sno_from_url = end($broken_parts);
$slot_sno_from_url = rtrim($slot_sno_from_url,'/');

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
<div style="position:relative; max-height:80%; max-width:100%; text-align:left; margin-top: 10%;" >
    <h2 class="vote-heading"  style="position:absolute; 
    top: -5%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <?php echo $time_from_url; ?> minutes</h2>
<?php

if(array_key_exists('post_vote', $_POST)) { 
    button1($_POST["radio-buttons-for-voting"]); 
}

function button1($description_from_form){
    $table_name = 'wp_kairoi_bids';
    global $wpdb;
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            WHERE description = '$description_from_form'
            "
        );  
    foreach($details as $key=>$val)
        {			
            $votes = $val->votes;
            $bid_sno = $val->bid_sno;
        }
    
    $wpdb->update('wp_kairoi_bids', array('votes'=>($votes +1)), array('bid_sno'=>$bid_sno));    
    echo "<script> location.href='thank-you'; </script>";
}

global $wpdb;

$table_name = 'wp_kairoi_slots';
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE slot_sno = $slot_sno_from_url
        "
    );

foreach($details as $key=>$val)
{			
    $is_slot_open_for_voting = $val->is_slot_open_for_voting;
    $no_of_bids = $val->no_of_bids;
}

if($is_slot_open_for_voting==false&&$no_of_bids==5){

    $table_name = 'wp_kairoi_bids';
    $details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE slot_sno = $slot_sno_from_url
        "
    );
    echo "<br>";
    foreach($details as $key=>$val)
    {			
        $description = $val->description;
        $votes = $val->votes;
        //building display for winners display
        echo "<h3 style='margin-left:30%;font-family:Raleway'> ".$description."<span style='background:#00687f;font-size:50%;padding:5px;color:white;margin-left:40px;'>".$votes." votes</span></h3>";
    }
    echo "<h5 style='margin-left:30%;font-family:Raleway'>Slot is closed for voting</h5>";

}

elseif($is_slot_open_for_voting==false&&$no_of_bids<5){
    echo "Wait for all bids to come";
}
else{
$table_name = 'wp_kairoi_bids';
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE slot_sno = $slot_sno_from_url
        "
    );
    echo "<form method='post'><br><br>";  
foreach($details as $key=>$val)
    {			
        $description = $val->description;
        //building display for voting form
        echo "<input style='margin-left:30%;' checked type='radio' name='radio-buttons-for-voting' id='vote-".$key."' value='".$description."'>
                            <label class='voting-labels' for='".$key."'> ".$description."</label><br>";
    }
    echo "
                <br><input type='submit' name='post_vote'
                class='button vote-button' value='Vote'/> 
            </form></div>";
        }
?>
<div class="footer-div">
  <div class="col-img" style="width:12%;background:#44474c;float:left;padding:10px;width:100px;">
  <img src="http://localhost/kairoi/wp-content/uploads/2020/10/fmi.jpg">
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
    <img src="http://localhost/kairoi/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web.png">
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




