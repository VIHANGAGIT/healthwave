<?php 
//Page redirect
function redirect($destination){
    header('location: ' . URLROOT . '/' . $destination);
}