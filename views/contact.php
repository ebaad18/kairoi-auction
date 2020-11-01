<?php 
require_once("../../../../wp-load.php");
get_header(); //import header  

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

if(array_key_exists('submit_info', $_POST)) { 
    submit_function($_POST["name"],$_POST["comment"],$_POST["email"]); 
} 
function submit_function($name,$comment,$email){ //submitting contact info
    global $wpdb;
    $wpdb->insert("wp_kairoi_contacts", array(
        "email" => $email,
        "comment" => $comment,
        "name" => $name,   
        "posted_on" => date('Y-m-d H:i:s'),
    )); 
    echo "<div id='snackbar'>Thank you for contacting us</div>

            <script>

            var x = document.getElementById('snackbar');
            x.className = 'show';
            setTimeout(function(){ x.className = x.className.replace('show', ''); }, 3000);
            setTimeout(function() { location.href='../'; }, 3000);
            </script>";
     exit();
}
?>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- For navbar icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
.site{
    background: url('wp-content/plugins/kairoiauction/assets/content-bg.jpg');
    background-repeat: no-repeat;
    background-size: 100%;
}
.container-fluid{
    margin-top:10%;
    margin-right:0px;
    margin-left:0px;
    text-align:left;
    font-family:'Raleway';
    color: white;
    background:#44474ccc;
}
a{
    color:white !important;
    text-decoration:underline;
}
a:hover{
    color:white;
    opacity:0.9;
}
h2::before,h1::before{
    content:none;
}
hr{
    width:20%;
    color: #44474c;
    border-top: 1px dashed #00687f;
}
input[type="text"], input[type="email"]{
    height:65px;
    width:50%;
    font-size:24px;
    margin-top: 2%;
}
input[type="email"]{
    width:100%;
}
textarea{
    width:100%;
    font-size:24px;
    margin-top: 2%;

}
.contact-button{
    font-size:24px !important;
    border-radius: 0px !important;
    background:#2bbdcd !important;
    padding:5px !important;
    color:white !important;
    font-family:'Raleway' !important;
    margin-top: 2% !important;
}
@media only screen and (max-width: 600px) {
    input[type="text"], input[type="email"]{
    height:35px;
    width:50%;
    font-size:16px;
    margin-top: 2%;
    }
    input[type="email"]{
        width:100%;
    }
    textarea{
        width:100%;
        font-size:16px;
        margin-top: 2%;
    }
    .contact-button{
        font-size:16px !important;
    }
    h1,h2{
        font-size:99% !important;
    }
}
</style>
<div class="nav-bar-icon-pages" onclick="openNav()">&#9776;</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <h1 style="text-align:center;margin-bottom:4%;"><b class="contact-page-heading">Contact</b></h1>
            <form method="post"> 
                <input type="text" name="name" placeholder="Enter Name" style="font-family:'Raleway';"/>

                <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter Email" style="font-family:'Raleway';"/>

                <textarea maxlength="80" name="comment" rows="3" placeholder="Add a comment"
                style="font-family:'Raleway';"></textarea>
 
                <input type="submit" name="submit_info"
                        class="button contact-button" value="Submit"/> 
            </form>   
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br><br><br><br><br><br><br>
</div>

<div class="footer-div">
  <div class="col-img-1" style="background:#44474c;float:left;padding:10px;">
  <a href="https://www.facebook.com/fivemillionincidents/"><img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg"></a>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Total Time: <?php echo $total_time ?></h5>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time Left: <?php echo ($total_time - $time_consumed) ?> </h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time in Auction: <?php echo $time_in_auction ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h5>
  </div>
  <div class="col-img-2" style="margin-top:5px;">
    <a href="https://www.goethe.de/ins/in/en/m/kul/sup/fmi.html"><img src="https://kairoi.in/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web-1.png"></a>
  </div>
</div>

<div class="footer-div">
  <div class="col-img-1" style="background:#44474c;float:left;padding:10px;">
  <a href="https://www.facebook.com/fivemillionincidents/" target="_blank"><img src="https://kairoi.in/wp-content/uploads/2020/10/fmi.jpg"></a>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Total Time: <?php echo $total_time ?> <?php $useragent=$_SERVER['HTTP_USER_AGENT']; if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
    echo "Time in Auction: ".$time_in_auction.""; } ?></h5>
  </div>
  <div class="col-text">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time Left: <?php echo ($total_time - $time_consumed) ?> <?php $useragent=$_SERVER['HTTP_USER_AGENT']; if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
    echo "Time Auctioned: ".($time_consumed - $time_in_auction).""; } ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time in Auction: <?php echo $time_in_auction ?></h5>
  </div>
  <div class="col-text mobile-hide">
    <h5 style="font-family:'Raleway';color:white;font-weight:bold;font-size:22px;margin-top:10px">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h5>
  </div>
  <div class="col-img-2">
    <a href="https://www.goethe.de/ins/in/en/m/kul/sup/fmi.html" target="_blank"><img src="https://kairoi.in/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web-1.png"></a>
  </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/about"><h5>About</h5></a>
    <br>
    <a href="/instructions"><h5>Instructions</h5></a>
    <br>
    <a href="/rules"><h5>Rules</h5></a>
    <br>
    <a href="/winners"><h5>Winners</h5></a>
    <br>
    <a href="#"><h5>Contact</h5></a>
    <hr style="margin-left:25px;width:30%;color:#2bbdcd"  align="left">
    <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
    <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:35px;color:#ffffff;"></i></a>
    <a href="https://www.facebook.com/kairoi.auction" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:30px;color:#ffffff;"></i></a>
    <a href="mailto:auction@kairoi.in" style="display:inline" target="_blank"><i class="fa fa-google" style="font-size:30px;color:#ffffff;"></i></a>
    <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:35px;color:#ffffff;padding-left:20px;cursor:pointer"></i>      
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