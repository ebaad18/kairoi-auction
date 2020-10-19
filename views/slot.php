<?php 

require_once("../../../../wp-load.php");
get_header(); //import header 
$content='';
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
$slot_sno_from_url = rtrim($slot_sno_from_url,'/');
$minute_from_url = $broken_parts[1];
$minute_from_url = rtrim($minute_from_url,'/slot');

$table_name = 'wp_kairoi_slot_time';
global $wpdb;
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE time = $minute_from_url
        "
    );  
foreach($details as $key=>$val)
    {			
        $slot_time_sno = $val->slot_time_sno; //getting the slot time serial number for getting access to slots for the slot time
    }

$table_name = 'wp_kairoi_slots';
global $wpdb;
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
        if($slot_sno == $slot_sno_from_url){
        $slot_index = ($key+1);
        }
    }    
$count_of_bids_in_a_slot = 0;
$table_name = 'wp_kairoi_bids';
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
    $bids_description = $val->description;
    $content.= ''.$bids_description.'<br>';
    $count_of_bids_in_a_slot++;
    
}

?>

<h2 class="slot-heading" style="text-align:center">

    <a style="float:left; margin-left:5%" href="bid/" <?php if ($count_of_bids_in_a_slot >= 5){ ?> class="disabled-links" <?php   } ?>>Bid</a>
    <?php echo $minute_from_url; ?> minutes Slot <?php echo $slot_index; ?>
    <a style="float:right; margin-right:5%"  href="vote/">Vote</a>
</h2> 

<h4><?php echo $content; ?></h4>



