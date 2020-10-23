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
    background-repeat: repeat;
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
h2::before{
    content:none;
}
h4{
    font-family:'Raleway';
}
hr{
    width:20%;
    color: #44474c;
    border-top: 1px dashed #00687f;
}
</style>
<div class="nav-bar-icon" onclick="openNav()">&#9776;</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <h2><b>Rules of Action</b></h2>
            <h3><b>I. Harm/Damage</b> (A,B,C,D,E)</h3>
            <h4>The bidder must not propose an occupation of time which requires the involved parties to indulge in any kind of: physical or mental self-harm</h4>
            <h4>A. harm to another. </h4>
            <h4>B. harm to any property.</h4>
            <h4>C. Creation of any environment or situation leading to the above.</h4>
            <hr align="left">
            <h3><b>II. Exchange</b> (A,B,C,D)</h3>
            <h4>The bidder must not propose an occupation of time which requires either of the involved parties to indulge in any kind of: Monetary exchange/ benefit before, during or after the enactment</h4>
            <h4>A. Exchange of service/labour.</h4>
            <h4>B. Sexual favour.</h4>
            <h4>C. Creation of any environment or situation leading to the above.</h4>
            <hr align="left">
            <h3><b>III. Freedom and Discrimination</b> (A,B,C)</h3>
            <h4>The bidder must not propose an occupation of time which requires any of the involved parties to act in a way that:</h4>
            <h4>A. Restricts freedom of speech</h4>
            <h4>B. Restricts/ discriminates one’s identity on the basis of but not limited to sex, color, religion, caste, age, nationality, ideology and belief, among others.</h4>
            <h4>C. Creation of any environment or situation leading to the above.</h4>
            <hr align="left">
            <h3><b>IV. Mutual Agreement </b>(only if more than one person involved) (A,B)</h3>
            <h4>The bidder should propose an occupation of time which requires any of the involved parties to act in a way that:</h4>
            <h4>A. All parties mutually agree upon a date, time and location (if not specific to the proposed occupation) to carry out the occupation of time.</h4>
            <h4>B. At least one of them is actively involved in the activity proposed.</h4>
            <hr align="left">
            <h3><b>V. Rights of Documentation</b> (A)</h3>
            <h4>The bidder should propose an occupation of time which requires any of the involved parties to act in a way that:</h4>
            <h4>A. The activity is properly documented.</h4>
            <hr align="left">
            <h3><b>VI. Copyrights and Credits</b> (A,B,C)</h3>
            <h4>The bidder should propose an occupation of time keeping in mind that the enactment (and it’s documentation material) is:</h4>
            <h4>A. The property of and available only to the artist and Goethe-Institut / Max Mueller Bhavan for publicity or any future use.</h4>
            <h4>B. Any part or whole of the enactment cannot be used without the permission of and crediting the artist and Goethe-Institut / Max Mueller Bhavan (a credit format will be provided and is to be used as it is).</h4>
            <h4>C. Under strict copyrights and violation of the same can result in legal action.</h4>
            <hr align="left">
            <h3><b>VII. Right to Bid/Suffrage</b> (A,B)</h3>
            <h4>A person is qualified to bid solely as per the below conditions:</h4>
            <h4>A. Any person irrespective of nationality, religion, caste, gender, race is qualified to bid.</h4>
            <h4>B. She/ he must respect difference of opinion and not indulge in any kind of extremism like patriotism, fascism, religious extremism, misogyny, racism, casteism etc.</h4>
            <hr align="left">
            <h3><b>VIII. Culmination and Punitive Action</b> (A,B,C)</h3>
            <h4>The bidder should propose an occupation of time keeping in mind that:</h4>
            <h4>A. The enactment must take place and no party can withdraw once the winner is announced and the time is auctioned out.</h4>
            <h4>B. Any of the parties cannot transfer their indulgence to any third party.</h4>
            <h4>C. Any violation of any of the above articles can lead to legal action resulting in a minimum of 5 days of fine (agency of the artist over their occupation of time).</h4>       
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>

<div class="footer-div">
  <div class="col-img" style="width:12%;background:#44474c;float:left;padding:10px;width:100px;">
  <img src="http://localhost/kairoi/wp-content/uploads/2020/10/fmi.jpg">
  </div>
  <div class="col-empty">
  </div>
  <div class="col-text">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Total Time: <?php echo $total_time ?></h3>
  </div>
  <div class="col-text">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Time Left: <?php echo ($total_time - $time_consumed) ?> </h3>
  </div>
  <div class="col-text mobile-hide">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Time in Auction: <?php echo $time_in_auction ?></h3>
  </div>
  <div class="col-text mobile-hide">
    <h3 style="font-family:'Raleway';color:white;font-weight:bold">Time Auctioned: <?php echo ($time_consumed - $time_in_auction) ?> </h3>
  </div>
  <div class="col-empty mobile-hide">
  </div>
  <div class="col-img" style="width:150px;margin-top:10px;">
    <img src="http://localhost/kairoi/wp-content/uploads/2020/10/GI-MMB-horizontal-white-s-RGB-web.png">
  </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/about"><h5>About</h5></a>
    <a href="/instructions"><h5>Instructions</h5></a>
    <a href="#"><h5>Rules</h5></a>
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