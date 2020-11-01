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
    <div style="position:absolute; 
    top: 35%;
    text-align:-webkit-center;
    width:100%;">
    <form method="post"> 
    

    <input type="text" name="nickname" placeholder="Enter Temporary Name" style="font-family:'Raleway'; width: 55%;margin:10px 0px;" required/>
    <br>
    <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter Email" style="font-family:'Raleway'; width: 55%;margin:10px 0px;" required/>
    <br>
    <textarea maxlength="50" name="description" rows="3" placeholder="How will you occupy this time?"
    style="font-family:'Raleway';width: 55%;margin:8px 0px;" required></textarea>

    
    <input type="submit" name="create_new_bid"
            class="button" value="Send" style="background:#00687f;
    padding:5px;
    color:white;
    font-family:Raleway;border-radius:0px;"/> 
</form><br><br><br></div>

<div class="footer-div">
  <div class="col-img-1" style="background:#44474c;float:left;padding:10px;">
  <a href="https://www.facebook.com/fivemillionincidents/" target="_blank"><img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg"></a>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white">Total Time: <?php echo $total_time ?><br> <?php $useragent=$_SERVER['HTTP_USER_AGENT']; if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
    echo "Time in Auction: ".$time_in_auction.""; } ?></h5>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white">Time Left: <?php echo ($total_time - $time_consumed) ?><br> <?php $useragent=$_SERVER['HTTP_USER_AGENT']; if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
    echo "Time Auctioned: ".($time_consumed - $time_in_auction).""; } ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white">Time in Auction: <?php echo $time_in_auction ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h5>
  </div>
  <div class="col-img-2">
    <a href="https://www.goethe.de/ins/in/en/m/kul/sup/fmi.html" target="_blank"><img src="https://kairoi.in/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web-1.png"></a>
  </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/about"><h5>About</h5></a>
    <a href="/instructions"><h5>Instructions</h5></a>
    <a href="/rules"><h5>Rules</h5></a>
    <a href="/winners"><h5>Winners</h5></a>
    <a href="/contact"><h5>Contact</h5></a>
    <hr style="margin-left:25px;width:30%;color:#2bbdcd"  align="left">
    <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
    <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:30px;color:#ffffff;"></i></a>
    <a href="https://www.facebook.com/kairoi.auction" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:30px;color:#ffffff;"></i></a>
    <a href="mailto:auction@kairoi.in" style="display:inline" target="_blank"><i class="fa fa-google" style="font-size:30px;color:#ffffff;"></i></a>
    <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:30px;color:#ffffff;padding-left:20px;cursor:pointer"></i>      
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