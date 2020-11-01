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
$time_from_url = rtrim($time_from_url,'/vote');

global $array_for_voting_slot_sno;
$array_for_voting_slot_sno = array(); //contains all slot numbers in which voting is open
global $array_for_winners_slot_sno;
$array_for_winners_slot_sno = array(); //contains all slot numbers in which winner is decided
global $wpdb;
//getting slot time
$table_name = 'wp_kairoi_slot_time';
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
//getting all slots of that particular time
$table_name = 'wp_kairoi_slots';
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
        $is_slot_open_for_voting = $val->is_slot_open_for_voting;
        if($is_slot_open_for_voting==true)
        array_push($array_for_voting_slot_sno,$slot_sno); //pushing into array if slot is open for voting
        if($is_slot_open_for_voting==false&&$no_of_bids==5)
        array_push($array_for_winners_slot_sno,$slot_sno); //pushing into array if winner is decided (basically, when a slot is full and is closed for voting)
    }
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
<style>
.winner {
  border-left: 25px solid #73a657;
  height: 250px;
  text-align:center;
}
.open {
  border-left: 25px solid #00687f;
  height: 250px;
  text-align:center;
}
.not-created {
  border-left: 25px solid #d3d3d3;
  height: 250px;
  text-align:center;
  cursor: not-allowed;
}

.winner-phone{
  border-top: 25px solid #73a657;
  width: 50%;
  text-align:center;
}
.open-phone{
  border-top: 25px solid #00687f;
  width: 50%;
  text-align:center;
}
.not-created-phone{
  border-top: 25px solid #d3d3d3;
  width: 50%;
  text-align:center;
  cursor: not-allowed;
}

</style>
<head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<div class="nav-bar-icon-pages" onclick="openNav()">&#9776;</div>
<div class="vote-slots-desktop" style="position:relative; max-height:80%; max-width:100%; text-align:center; margin-top: 10%;" >
    <h3 class="vote-slots-heading"  style="z-index:3;
    position:absolute; 
    top: 0%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> Vote</h3> 
    <image class="vote-slots-page-bg" src="../../wp-content/plugins/kairoiauction/assets/vote-bg-desktop.png" >
    
    
<?php
//10 maximum number is for i day slot, 15 for 5 minutes, and 10 for 15, 30, 60, 360, and 720 minutes 
//for desktop view
if($max_no==10){
    for($i = 0 ; $i < $max_no ; $i++){
        if($i<count($array_for_winners_slot_sno))
            echo"<a href='slot-".$array_for_winners_slot_sno[$i]."/' title='Voting closed''><span class='winner' style='
            position:absolute; 
            top: 68%;
            left:".(30+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open' style='
            position:absolute; 
            top: 68%;
            left:".(30+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created' style='
            position:absolute; 
            top: 68%;
            left:".(30+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
    }
}
if($max_no==20){
    for($i = 0 ; $i < $max_no ; $i++){
        if($i<count($array_for_winners_slot_sno))
            echo"<a href='slot-".$array_for_winners_slot_sno[$i]."/' title='Voting closed''><span class='winner' style='
            position:absolute; 
            top: 68%;
            left:".(2+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open' style='
            position:absolute; 
            top: 68%;
            left:".(2+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created' style='
            position:absolute; 
            top: 68%;
            left:".(2+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
    }
}
if($max_no==15){
    for($i = 0 ; $i < $max_no ; $i++){
        if($i<count($array_for_winners_slot_sno)) //going through the winners array
            echo"<a href='slot-".$array_for_winners_slot_sno[$i]."/' title='Voting closed''><span class='winner' style='
            position:absolute; 
            top: 68%;
            left:".(15+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno))) //going through the voting open array
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open' style='
            position:absolute; 
            top: 68%;
            left:".(15+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created' style='
            position:absolute; 
            top: 68%;
            left:".(15+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
    }
}
?></div>

<div class="vote-slots-phone" style="position:relative; max-height:80%; max-width:100%; text-align:center; margin-top: 10%; overflow:scroll" >
    <h2 class="vote-slots-heading"  style="z-index:3;
    position:absolute; 
    top: 0%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> Vote</h2> 
    <image class="vote-slots-page-bg" src="../../wp-content/plugins/kairoiauction/assets/vote-bg-phone.png">
    
    
<?php 
//for mobile view
if($max_no==10){
    for($i = 0 ; $i < $max_no ; $i++){
        if($i<count($array_for_winners_slot_sno)) //going through the winners array
            echo"<a href='slot-".$array_for_winners_slot_sno[$i]."/' title='Voting closed''><span class='winner-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno))) //going through the voting open array
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
    }
}
if($max_no==20){
    for($i = 0 ; $i < $max_no ; $i++){
        if($i<count($array_for_winners_slot_sno))
            echo"<a href='slot-".$array_for_winners_slot_sno[$i]."/' title='Voting closed''><span class='winner-phone' style='
            position:absolute; 
            left:50%;
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
    }
}
if($max_no==15){
    for($i = 0 ; $i < $max_no ; $i++){
        if($i<count($array_for_winners_slot_sno))
            echo"<a href='slot-".$array_for_winners_slot_sno[$i]."' title='Voting closed''><span class='winner-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created-phone' style='
            position:absolute;
            left:50%; 
            top:".(15+$i*4)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
    }
}
?>

</div>
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