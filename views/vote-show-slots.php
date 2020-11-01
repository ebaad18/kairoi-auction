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
            top: 71%;
            left:".(30+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open' style='
            position:absolute; 
            top: 71%;
            left:".(30+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created' style='
            position:absolute; 
            top: 71%;
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
            top: 71%;
            left:".(2+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open' style='
            position:absolute; 
            top: 71%;
            left:".(2+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created' style='
            position:absolute; 
            top: 71%;
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
            top: 71%;
            left:".(15+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";
        
        if($i>=count($array_for_winners_slot_sno)&&$i<(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno))) //going through the voting open array
            echo"<a href='slot-".$array_for_voting_slot_sno[($i-count($array_for_winners_slot_sno))]."/' title='Vote here'><span class='open' style='
            position:absolute; 
            top: 71%;
            left:".(15+$i*5)."%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);'></span></a>";

        if($i>=(count($array_for_winners_slot_sno)+count($array_for_voting_slot_sno)))
            echo"<a href='#' title='Voting not open yet'><span class='not-created' style='
            position:absolute; 
            top: 71%;
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
  <a href="https://www.facebook.com/fivemillionincidents/" target="_blank"><img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg"></a>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white">Total Time: <?php echo $total_time ?> min <br><?php $useragent=$_SERVER['HTTP_USER_AGENT']; if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
    echo "Time in Auction: ".$time_in_auction." min"; } ?></h5>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white">Time Left: <?php echo ($total_time - $time_consumed) ?> min<br><?php $useragent=$_SERVER['HTTP_USER_AGENT']; if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
    echo "Time Auctioned: ".($time_consumed - $time_in_auction)." min"; } ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white">Time in Auction: <?php echo $time_in_auction ?> min</h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> min</h5>
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
    <div style="position:absolute;bottom:0px;">
    <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
    <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:30px;color:#ffffff;"></i></a>
    <a href="https://www.facebook.com/kairoi.auction" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:30px;color:#ffffff;"></i></a>
    <a href="mailto:auction@kairoi.in" style="display:inline" target="_blank"><i class="fa fa-envelope-o" style="font-size:30px;color:#ffffff;"></i></a>
    <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:30px;color:#ffffff;padding-left:20px;cursor:pointer"></i></div>      
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