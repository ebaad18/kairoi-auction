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
$time_from_url = end($broken_parts);
$time_from_url = rtrim($time_from_url,'/');


?>
<h2 class="time-slot-heading" style="text-align:center"> <?php echo $time_from_url; ?> minutes slots</h2> 
<?php
GLOBAL $time_from_url;
$table_name = 'wp_kairoi_slot_time';
global $wpdb;
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

$count = 0;
$table_name = 'wp_kairoi_slots';
global $wpdb;
global $count;
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
        echo '<a style="text-align:center" href="slot-'.$slot_sno.'/">Slot '.($key+1).'</a><br>';
        $count++;
    }  
// echo $count;
if(array_key_exists('create_new_time_slot', $_POST)) { 
    button1(); 
} 
function button1() //creating new time slots
{   
    global $count;
    global $max_no;
    if ($count >= $max_no){
        echo "<script> alert('Maximum slots have already been created'); </script>";
    } 
    else{
        global $wpdb;
        GLOBAL $slot_time_sno;
        $wpdb->insert("wp_kairoi_slots", array(
    "slot_time_sno" => $slot_time_sno,
    "created_on" => date('Y-m-d H:i:s'),
    )); 
        global $key;
        global $slot_sno;
        if($key == 0 && $count == 0)
        echo '<a style="text-align:center" href="slot-'.$slot_sno.'/">Slot '.($key+1).'</a><br>';
        else
        echo '<a style="text-align:center" href="slot-'.$slot_sno.'/">Slot '.($key+2).'</a><br>';
        $count++;
    } 
}
    
?>  

<form method="post"> 
    <input type="submit" name="create_new_time_slot"
            class="button" value="Create New Slot"/> 
</form>

<script>
</script>