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
?>
<h2 class="time-slot-heading" style="text-align:center"> Vote for bids in the <?php echo $time_from_url; ?> minutes slots</h2> 
<?php

if(array_key_exists('post_vote', $_POST)) { 
    echo $_POST["radio-buttons-for-voting"];
    button1($_POST["radio-buttons-for-voting"]); 
}

function button1($description_from_form){
    echo $description_from_form;
}

global $wpdb;
$table_name = 'wp_kairoi_bids';
$details = $wpdb->get_results (
        "
        SELECT *
        FROM $table_name
        WHERE slot_sno = $slot_sno_from_url
        "
    );
    echo "<form method='post'>";  
foreach($details as $key=>$val)
    {			
        $description = $val->description;
        echo "<input type='radio' name='radio-buttons-for-voting' id='vote-".$key."' value='".$description."'>
                            <label for='".$key."'> ".$description."</label><br><br>";
    }
    echo "
                <input type='submit' name='post_vote'
                class='button' value='Submit Your Vote'/> 
            </form>"
?>



