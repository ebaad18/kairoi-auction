<?php
if( !defined('ABSPATH')){ 
	die;
} 
function kairoi_auction_main(){
    global $wpdb;
    global $count;
    $count = 0;
    global $array_for_display;
    $array_for_display = array();
    $table_name = 'wp_kairoi_bids';
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            "
        );  
    foreach($details as $key=>$val)
        {	
            $description = $val->description;
            array_push($array_for_display,$description);
            $count++;	
            
        }

    $table_name = 'wp_kairoi_auction_master';
    $details = $wpdb->get_results (
            "
            SELECT *
            FROM $table_name
            "
        );  
    foreach($details as $key=>$val)
        {	
            $total_time = $val->total_time;
            
        }
    
    
?>
    
    <div style="position:relative; max-height:80%; max-width:100%; text-align:center" >
    <span style="font-size:40px;cursor:pointer;position:absolute;right:0;margin-right:2%" onclick="openNav()">&#9776;</span> 
    
    <image id="bg-img" src="wp-content/plugins/kairoiauction/assets/main-page-bg-1.png" >

    <?php 
        if($count>1){
        for($i = 0 ; $i < 30 ; $i++){
        echo "<h5 class='floating' style='color:#00687f;
        position:absolute;
        z-index:4; 
        left:".rand(0,90)."%;  top:".rand(0,85)."%; opacity:0.".rand(0,100)."'>".$array_for_display[(rand(0,$count-1))]."<br>";
    }}?>
    
    <h1 class="main-heading-center" onclick="add_styles()" style="position:absolute; 
    top: 50%;
    left:49%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"><?php echo $total_time ?></h1>

    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 2%;
    left:52%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-5/">5 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 20%;
    left:71%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-15/">15 minutes</a> </h4>
    
    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 50%;
    left:73%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-30/">30 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 85%;
    left:72%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-60/">1 hour</a> </h4>

    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 89%;
    left:42%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-360/">6 hours</a> </h4>

    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 58%;
    left:26%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-720/">12 hours</a> </h4>

    <h4 class="time-slots-main-page-heading" style="position:absolute; 
    top: 26%;
    left:30%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-1440/">1 day</a> </h4>

    </div>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#"><h4>About</h4></a>
        <a href="#"><h4>Instructions</h4></a>
        <a href="#"><h4>Rules</h4></a>
        <a href="#"><h4>Winners</h4></a>
        <a href="#"><h4>Contact</h4></a>
    </div>


    
    <script>
        // var temp = document.getElementsByClassName("site-content")[0];
        // temp.setAttribute("style", "background-image:url('wp-content/plugins/kairoiauction/assets/main-page-bg.png'); background-position: center;background-repeat: no-repeat;background-size: contain;");
        function add_styles(){
            console.log("Clicked on");
            document.getElementById("bg-img").src = "wp-content/plugins/kairoiauction/assets/main-page-bg-2.png";
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
            document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            }
    </script>
<?php
}
?>