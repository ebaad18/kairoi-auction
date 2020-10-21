<?php 
require_once("../../../../wp-load.php");
get_header(); //import header 
if ( is_user_logged_in() ){


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
 
?>
<div style="position:relative; max-height:80%; max-width:100%; text-align:center; margin-top: 10%;" >
    <image src="../../../wp-content/plugins/kairoiauction/assets/minute-page-bg.png" >
    <h2 class="main-heading-center"  style="position:absolute; 
    top: -5%;
    left:50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);"> Thank you for engaging!</h2> 
    

    <a href="../../../" style="position:absolute; 
    top: 81%;
    left:40%;
    height:15%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;"><img style="height:50px;width:50px;diplay:inline" src="../../../wp-content/plugins/kairoiauction/assets/loop.png"><h4 style="display:inline;vertical-align:20px;">Bid</h4></a>
    
    <a href="../../vote/" style="position:absolute; 
    top: 81%;
    left:60%;
    height:15%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background:#00687f;
    padding:5px;
    color:white;"><img style="height:50px;width:50px;diplay:inline" src="../../../wp-content/plugins/kairoiauction/assets/loop.png"><h4 style="display:inline;vertical-align:20px;">Vote</h4></a>
</div>