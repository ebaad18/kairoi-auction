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


if(array_key_exists('create_new_bid', $_POST)) { 
    //echo $_POST["nickname"];
    button1($_POST["nickname"],$_POST["description"],$_POST["email"]); 
} 
function button1($nickname,$description,$email) //creating new time slots
{
    global $wpdb;
    GLOBAL $slot_sno_from_url;
    //$current_user_id = get_current_user_id();
    
    $wpdb->insert("wp_kairoi_bidding_users", array(
        "nickname" => $nickname,
        "email" => $email,
        "voted_bids" => 'vrr',
     )); 
    
    $table_name = 'wp_kairoi_slots';
    global $wpdb;
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
    
    $wpdb->update('wp_kairoi_slots', array('no_of_bids'=>($no_of_bids +1)), array('slot_sno'=>$slot_sno_from_url));  

    $table_name = 'wp_kairoi_bidding_users';
    global $wpdb;
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
    echo $ip_address;

    $wpdb->insert("wp_kairoi_bids", array(
    "slot_sno" => $slot_sno_from_url,
    "user_sno" => $temp,
    "description" => $description,
    "ip" => $ip_address,
    "votes" => 0,    
    "bidded_on" => date('Y-m-d H:i:s'),
)); 
echo "<script> location.href='thank-you'; </script>";
exit();
}     
?>
<span style="font-size:40px;cursor:pointer;position:absolute;right:0;margin-right:2%" onclick="openNav()">&#9776;</span> 
<h2 class="main-heading-center"  style="position:absolute; 
    top: 20%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <?php echo $minute_from_url; ?> minutes</h2>
    <form method="post"> 
    

    <input type="text" name="nickname" placeholder="Enter Temporal Name" style="position:absolute; 
    top: 40%;
    left:50%;
    width: 55%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"/>

    <input type="text" name="email" placeholder="Enter Email" style="position:absolute; 
    top: 50%;
    left:50%;
    width: 55%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"/>

    <textarea maxlength="50" name="description" rows="3" placeholder="Enter Description"
    style="position:absolute; 
    top: 65%;
    left:50%;
    width: 55%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"></textarea>

    
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
<div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#"><h4>About</h4></a>
        <a href="#"><h4>Instructions</h4></a>
        <a href="#"><h4>Rules</h4></a>
        <a href="#"><h4>Winners</h4></a>
        <a href="#"><h4>Contact</h4></a>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>