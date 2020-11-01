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
    <head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    </head>
    <style>
    .fadeIn{
        display: none; 
    }
    </style>
    <?php 
        if($count>1) //for when there are more than 1 bids submitted, only then will the code be executed
        {   
            $useragent=$_SERVER['HTTP_USER_AGENT']; 
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
                for($i = 0 ; $i < 20 ; $i++){
                    echo "<div class='fadeIn'><h5 class='bids' style='font-family:Raleway;color: #00687f'>".stripslashes($array_for_display[(rand(0,$count-1))])."</h5></div>";
                } 
            }
            else{
                for($i = 0 ; $i < 60 ; $i++){
                    echo "<div class='fadeIn'><h5 class='bids' style='font-family:Raleway;color: #00687f'>".stripslashes($array_for_display[(rand(0,$count-1))])."</h5></div>";
                }
            }
            
        }?>
    <div class="nav-bar-icon" onclick="openNav()">&#9776;</div>
    <div class="mobile-center" style="position:relative; max-height:80%; max-width:100%;text-align:center" >
    
    
    <image id="bg-img" src="wp-content/plugins/kairoiauction/assets/main-page-bg-1-full.jpg" >
    
    
    <h2 id="main-heading" class="main-heading-center" onclick="add_styles()" style="position:absolute; 
    top: 45%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"><?php echo ($total_time - $time_consumed) ?></h2>

    <h4 class="time-slots-main-page-heading slot-5" style="position:absolute; 
    top: 13%;
    left:52%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-5/">5 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading slot-720" style="position:absolute; 
    top: 28%;
    left:70%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-720/">12 hours</a> </h4>
    
    <h4 class="time-slots-main-page-heading slot-30" style="position:absolute; 
    top: 44.5%;
    left:75%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-60/">1 hour</a> </h4>

    <h4 class="time-slots-main-page-heading slot-1440" style="position:absolute; 
    top: 69%;
    left:71%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-1440/">1 day</a> </h4>

    <h4 class="time-slots-main-page-heading slot-360" style="position:absolute; 
    top: 81%;
    left:43%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-360/">6 hours</a> </h4>

    <h4 class="time-slots-main-page-heading slot-15" style="position:absolute; 
    top: 56%;
    left:19%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-15/">15 minutes</a> </h4>

    <h4 class="time-slots-main-page-heading slot-60" style="position:absolute; 
    top: 28%;
    left:28%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> <a class="time-slot" href="minute-30/">30 minutes</a> </h4>

    </div>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="about"><h5>About</h5></a>
        <a href="instructions"><h5>Instructions</h5></a>
        <a href="rules"><h5>Rules</h5></a>
        <a href="winners"><h5>Winners</h5></a>
        <a href="contact"><h5>Contact</h5></a>
        <hr style="margin-left:25px;width:30%;color:#2bbdcd"  align="left">
        <a href="#" style="pointer-events:none"><h5>&#8826; social &#8827;</h5></a>
        <a href="https://www.instagram.com/kairoi.thetimes/" style="display:inline" target="_blank"><i class="fa fa-instagram" style="font-size:30px;color:#ffffff;"></i></a>
        <a href="https://www.facebook.com/kairoi.auction" style="display:inline" target="_blank"><i class="fa fa-facebook-square" style="font-size:30px;color:#ffffff;"></i></a>
        <a href="mailto:auction@kairoi.in" style="display:inline" target="_blank"><i class="fa fa-envelope-o" style="font-size:30px;color:#ffffff;"></i></a>
        <i onclick="copy_url()" class="fa fa-share-alt" style="font-size:30px;color:#ffffff;padding-left:20px;cursor:pointer"></i>      
    </div>
    <audio id="myAudio">
    <source src="wp-content/plugins/kairoiauction/assets/beep.mp3" type="audio/mp3">
    Your browser does not support the audio element.
    </audio>
    <script>
        // var temp = document.getElementsByClassName("site-content")[0];
        // temp.setAttribute("style", "background-image:url('wp-content/plugins/kairoiauction/assets/main-page-bg.png'); background-position: center;background-repeat: no-repeat;background-size: contain;");
        
        function add_styles(){
            var x = document.getElementById("myAudio");        
            x.play();
            var element = document.getElementById("main-heading");
            element.classList.add("no-border");
            // var element = document.getElementById("mobile-center");
            // element.classList.add("mobile-center");
            document.getElementById("bg-img").src = "wp-content/plugins/kairoiauction/assets/main-page-bg-2-full.png";
            for(let w = 0; w <7 ; w++){
                var obj = document.getElementsByClassName("time-slot")[w];
                obj.setAttribute("style", "color:black !important;pointer-events:auto;");
            }
            for(let w = 0; w <70 ; w++){
                var obj = document.getElementsByClassName("bids")[w];
                obj.setAttribute("style", "color:#ffffff00");
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
        (function fadeInDiv(){
            var divs = $('.fadeIn');
            var divsize = ((Math.random()*100) + 50).toFixed();
            var posx = (Math.random() * ($(document).width() - divsize)).toFixed();
            var posy = (Math.random() * ($(document).height() - divsize)).toFixed();
            var maxSize = 18;
            var minSize = 10;
            var size = (Math.random()*maxSize+minSize)
            
            var elem = divs.eq(Math.floor(Math.random()*divs.length));
            
            if (!elem.is(':visible')){
                elem.fadeIn(Math.floor(Math.random()*700),fadeInDiv);
                elem.css({
                    'z-index':'999',
                    'position':'absolute',
                    'left':posx+'px',
                    'top':posy+'px',
                    'font-size': size+'px'
                });
            } else {
                elem.fadeOut(Math.floor(Math.random()*700),fadeInDiv); 
            }
        })();    
    </script>
<?php
}
?>