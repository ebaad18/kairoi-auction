<?php
if( !defined('ABSPATH')){ 
	die;
}

//this function is called from the plugin config file and is a view that opens up when the shortcode is called

function kairoi_auction_main(){
    global $wpdb; //global variable for manipulation WordPress database
    global $count; //this count stores the total number of bids that have been submitted
    $count = 0; //begins with zero
    global $array_for_display; //this array stores the descriptions of all the bids
    $array_for_display = array(); 
    $table_name = 'wp_kairoi_bids'; //for getting all bids
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            "
        );  
    foreach($details as $key=>$val)
        {	
            $description = $val->description;
            array_push($array_for_display,$description); //pushing the descriptions in the array
            $count++;	
            
        }

    $table_name = 'wp_kairoi_auction_master'; //for displaying the total time remaining
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
            
        }
    
    
?>
    <head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
    <div class="nav-bar-icon" onclick="openNav()">&#9776;</div>
    <div id="mobile-center" style="position:relative; max-height:80%; max-width:100%;text-align:center" >
    
    
    <image id="bg-img" src="wp-content/plugins/kairoiauction/assets/main-page-bg-1.png" >

    <?php 
        if($count>1) //for when there are more than 1 bids submitted, only then will the code be executed
        {
            for($i = 0 ; $i < 30 ; $i++){
            echo "<h5 class='floating' style='color:#00687f;
            position:absolute;
            z-index:4; 
            left:".rand(0,90)."%;  top:".rand(0,85)."%; opacity:0.".rand(0,100)."'>".$array_for_display[(rand(0,$count-1))]."<br>";
            }
        }?>
    
    <h2 id="main-heading" class="main-heading-center" onclick="add_styles()" style="position:absolute; 
    top: 46%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"><?php echo ($total_time - $time_consumed) ?></h2>

    <h4 class="time-slots-main-page-heading slot-5" style="position:absolute; 
    top: 13%;
    left:52%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-5/">5 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading slot-720" style="position:absolute; 
    top: 29%;
    left:69%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-720/">12 hours</a> </h4>
    
    <h4 class="time-slots-main-page-heading slot-30" style="position:absolute; 
    top: 46%;
    left:77%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-30/">30 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading slot-1440" style="position:absolute; 
    top: 71%;
    left:71%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-1440/">1 day</a> </h4>

    <h4 class="time-slots-main-page-heading slot-360" style="position:absolute; 
    top: 83%;
    left:43%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-360/">6 hours</a> </h4>

    <h4 class="time-slots-main-page-heading slot-15" style="position:absolute; 
    top: 58%;
    left:20%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-15/">15 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading slot-60" style="position:absolute; 
    top: 29%;
    left:28%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-60/">1 hour</a> </h4>

    </div>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="about"><h5>About</h5></a>
        <a href="instructions"><h5>Instructions</h5></a>
        <a href="rules"><h5>Rules</h5></a>
        <a href="winners"><h5>Winners</h5></a>
        <a href="contact"><h5>Contact</h5></a>
        <hr style="width:40%;">
        <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
        <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:35px;color:#818181;"></i></a>
        <a href="https://www.facebook.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:35px;color:#818181;"></i></a>
        <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:35px;color:#818181;padding-left:20px;cursor:pointer"></i>      
    </div>


    
    <script>
        // var temp = document.getElementsByClassName("site-content")[0];
        // temp.setAttribute("style", "background-image:url('wp-content/plugins/kairoiauction/assets/main-page-bg.png'); background-position: center;background-repeat: no-repeat;background-size: contain;");
        function add_styles(){
            var element = document.getElementById("main-heading");
            element.classList.add("no-border");
            var element = document.getElementById("mobile-center");
            element.classList.add("mobile-center");
            document.getElementById("bg-img").src = "wp-content/plugins/kairoiauction/assets/main-page-bg-2-full.png";
            for(let w = 0; w <7 ; w++){
                var obj = document.getElementsByClassName("time-slot")[w];
                obj.setAttribute("style", "color:black !important;pointer-events:auto;");
            }
            for(let w = 0; w <30 ; w++){
                var obj = document.getElementsByClassName("floating")[w];
                obj.setAttribute("style", "display:none");
            }      
        }
        function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
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
<?php
}
?>