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
$slot_sno_from_url = end($broken_parts);
$slot_sno_from_url = rtrim($slot_sno_from_url,'/bid');

$minute_from_url = $broken_parts[1];
$minute_from_url = rtrim($minute_from_url,'/slot');

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
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
{
$ip_address = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
{
$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from remote address
else
{
$ip_address = $_SERVER['REMOTE_ADDR'];
}

$table_name = 'wp_kairoi_bids'; //getting all bids from this slot
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE slot_sno = $slot_sno_from_url
        "
    );  
foreach($details as $key=>$val)
    {			
        $temp = $val->ip;
        if($temp == $ip_address){
            echo "<div id='snackbar'>You have already bidded in this slot</div>

            <script>

            var x = document.getElementById('snackbar');
            x.className = 'show';
            setTimeout(function(){ x.className = x.className.replace('show', ''); }, 3000);
            setTimeout(function() { location.href='../../../'; }, 3000);
            </script>";
            exit();
        }    
    }
//submit bid functionality
if(array_key_exists('create_new_bid', $_POST)) { 
    button1($_POST["nickname"],$_POST["description"],$_POST["email"]); 
} 
function button1($nickname,$description,$email){ //posting a bid
    global $wpdb;
    global $slot_sno_from_url;
    global $minute_from_url;
    global $ip_address;
    
    
    //saving info of user who bidded

    $wpdb->insert("wp_kairoi_bidding_users", array(
        "nickname" => $nickname,
        "email" => $email,
        "voted_bids" => 'na',
     )); 
    
     //adding the new bid to the slot

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
            $no_of_bids = $val->no_of_bids;
        }
    
    $wpdb->update('wp_kairoi_slots', array('no_of_bids'=>($no_of_bids +1)), array('slot_sno'=>$slot_sno_from_url)); //incrementing the number of bids in a slot
    
    if(($no_of_bids+1) == 5) //if a slot gets full
    {
        $table_name = 'wp_kairoi_auction_master';
        $details = $wpdb->get_results (
                "
                SELECT *
                FROM $table_name
                "
            );  
        foreach($details as $key=>$val)
            {			
                $time_consumed = $val->time_consumed;
                $time_in_auction = $val->time_in_auction;
            }
        $temp = (int)$minute_from_url;    
        $wpdb->update('wp_kairoi_auction_master', array('time_consumed'=>($time_consumed + $temp)), array('sno'=>1)); //if a slot is full, then deduct from total time
        $wpdb->update('wp_kairoi_auction_master', array('time_in_auction'=>($time_in_auction + $temp)), array('sno'=>1)); //if a slot is full, then add to time in auction
        $wpdb->update('wp_kairoi_slots', array('is_slot_open_for_voting'=> true), array('slot_sno'=>$slot_sno_from_url)); //once a slot is full, it is open for voting
        $wpdb->update('wp_kairoi_slots', array('opened_for_voting_on'=> date('Y-m-d H:i:s')), array('slot_sno'=>$slot_sno_from_url)); //once a slot is full, voting opening timestamp is entered
    }

    $table_name = 'wp_kairoi_bidding_users';
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            "
        );  
    foreach($details as $key=>$val)
        {			
            $temp = $val->user_sno;
        }
    
    //finally inserting the new bid into the database

    $wpdb->insert("wp_kairoi_bids", array(
    "slot_sno" => $slot_sno_from_url,
    "user_sno" => $temp,
    "description" => $description,
    "ip" => $ip_address,
    "votes" => 0,   
    "bidded_on" => date('Y-m-d H:i:s'),
)); 
echo "<script> location.href='thank-you'; </script>"; //redirecting to thank you page
exit();
}     
?>
<head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<div class="nav-bar-icon-pages" onclick="openNav()">&#9776;</div>
<h3 class="bid-heading"  style="position:absolute; 
    top: 22%;
    left:51%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <?php if($minute_from_url=='1440'){ echo "&nbsp;1 day&nbsp;";}elseif($minute_from_url=='720'){ echo "12 hours"; }elseif($minute_from_url=='360'){ echo "6 hours"; }elseif($minute_from_url=='60'){ echo "1 hour"; }elseif($minute_from_url=='30'){ echo "30 minutes"; }elseif($minute_from_url=='15'){ echo "15 minutes"; }else{ echo "5 minutes";}?></h3>
    <form method="post"> 
    

    <input type="text" name="nickname" placeholder="Enter Temporary Name" style="font-family:'Raleway';
    position:absolute; 
    top: 40%;
    left:50%;
    width: 55%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);" required/>

    <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter Email" style="font-family:'Raleway';
    position:absolute; 
    top: 50%;
    left:50%;
    width: 55%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);" required/>

    <textarea maxlength="50" name="description" rows="3" placeholder="How will you occupy this time?"
    style="font-family:'Raleway';
    position:absolute; 
    top: 65%;
    left:50%;
    width: 55%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);" required></textarea>

    
    <input type="submit" name="create_new_bid"
            class="button" value="Send" style="position:absolute; 
    top: 80%;
    left:50%;
    border-radius: 0px;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;
    font-family:Raleway;"/> 
</form>

<div class="footer-div">
  <div class="col-img-1" style="background:#44474c;float:left;padding:10px;">
  <a href="https://www.facebook.com/fivemillionincidents/"><img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg"></a>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white">Total Time: <?php echo $total_time ?></h5>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white">Time Left: <?php echo ($total_time - $time_consumed) ?> </h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white">Time in Auction: <?php echo $time_in_auction ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h5>
  </div>
  <div class="col-img-2" style="margin-top:5px;">
    <a href="https://www.goethe.de/ins/in/en/m/kul/sup/fmi.html"><img src="https://kairoi.in/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web-1.png"></a>
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