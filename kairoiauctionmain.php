<?php
if( !defined('ABSPATH')){ 
	die;
} 
function kairoi_auction_main(){
?>
    <img src="/kairoi/wp-content/plugins/kairoiauction/assets/Preloader.gif" style="position:absolute; right:0%; top:0%; height:80px; width:80px">
    <h1 class="total-time" onclick="show_time_slots()">33574</h1>
    <a class="time-slot" href="minute-5/">5 minutes</a>
    <a class="time-slot" href="minute-15/">15 minutes</a>
    <a class="time-slot" href="minute-30/">30 minutes</a>
    <a class="time-slot" href="minute-60/">1 hour</a>
    <a class="time-slot" href="minute-360/">6 hours</a>
    <a class="time-slot" href="minute-720/">12 hours</a>
    <a class="time-slot" href="minute-1440/">1 day</a>

    <script>
        function show_time_slots(){
            console.log("Clicked on");
            for(let w = 0; w <7 ; w++){
                document.getElementsByClassName("time-slot")[w].style.display = "block";
            }
            
        }
    </script>
<?php
}
?>