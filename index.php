<?php
require_once("./functions.php");

if(isset($_GET['signup'])){
    showPage("signup",['title' => 'signup']);
}  else {
    showPage("welcome");
    
} 


?>