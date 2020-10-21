<?php 

require_once("../../../../wp-load.php");
get_header(); //import header 
if ( is_user_logged_in() ){
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

<?php
global $time_from_url;
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
get_slot_sno();
}
else{
    echo "<div id='snackbar'>Please log in</div>
    
    <script>
    
      var x = document.getElementById('snackbar');
      x.className = 'show';
      setTimeout(function(){ x.className = x.className.replace('show', ''); }, 3000);
      window.location.assign('http://localhost/kairoi/wp-admin');
    </script>";
}
function get_slot_sno(){
    global $slot_time_sno;
    global $wpdb;
    global $count;
    $count = 0;
    global $slot_sno;
    global $no_of_bids;
    global $max_no;
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
            //echo '<a style="text-align:center" href="slot-'.$slot_sno.'/">Slot '.($key+1).'</a><br>';
            $count++;
            
        }  
    if ($count == 0)
    {
        global $slot_time_sno;
        global $wpdb;
        $wpdb->insert("wp_kairoi_slots", array(
        "slot_time_sno" => $slot_time_sno,
        "no_of_bids" => 0,
        "created_on" => date('Y-m-d H:i:s'),
        ));
        get_slot_sno(); 
    } 
    else{
        if($count <= $max_no){
            if( $no_of_bids >=5){
                global $slot_time_sno;
                global $wpdb;
                $wpdb->insert("wp_kairoi_slots", array(
                "slot_time_sno" => $slot_time_sno,
                "no_of_bids" => 0,
                "created_on" => date('Y-m-d H:i:s'),
                ));
                get_slot_sno();
            }
        }
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

<!-- <form method="post"> 
    <input type="submit" name="create_new_time_slot"
            class="button" value="Create New Slot"/> 
</form> -->
<div style="position:relative; max-height:80%; max-width:100%; text-align:center; margin-top: 10%;" >
    <image src="../wp-content/plugins/kairoiauction/assets/minute-page-bg.png" >
    <h2 class="main-heading-center"  style="position:absolute; 
    top: -5%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <?php echo $time_from_url; ?> minutes</h2> 
    
    <h3><a href="slot-<?php echo $slot_sno?>/bid/" style="position:absolute; 
    top: 81%;
    left:40%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;
    font-family:Raleway;">Start bidding</a></h3>
    
    <h3><a href="vote/" style="position:absolute; 
    top: 81%;
    left:60%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;
    font-family:Raleway;">Vote for best bid</a></h3>
</div>