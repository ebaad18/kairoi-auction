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
    echo $_POST["nickname"];
    button1($_POST["nickname"],$_POST["description"]); 
} 
function button1($nickname,$description) //creating new time slots
{
    global $wpdb;
    GLOBAL $slot_sno_from_url;
    $current_user_id = get_current_user_id();
    
    $wpdb->insert("wp_kairoi_bidding_users", array(
        "ID" => $current_user_id,
        "nickname" => $nickname,
        "voted_bids" => 'vrr',
     )); 

    $table_name = 'wp_kairoi_bidding_users';
    global $wpdb;
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            WHERE ID = $current_user_id
            "
        );  
    foreach($details as $key=>$val)
        {			
            $temp = $val->user_sno;
        } 

    $wpdb->insert("wp_kairoi_bids", array(
    "slot_sno" => $slot_sno_from_url,
    "user_sno" => $temp,
    "description" => $description,
    "votes" => 0,    
    "bidded_on" => date('Y-m-d H:i:s'),
)); 
echo "<script> location.href='thank-you'; </script>";
exit();
} 
?>

<form method="post"> 
    <input type="text" name="nickname" placeholder="Enter Nickname"/>
    <textarea name="description" rows="3" placeholder="Enter Description"></textarea>
    <input type="submit" name="create_new_bid"
            class="button" value="Create New Bid"/> 
</form>