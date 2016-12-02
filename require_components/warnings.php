<?php

// w razie przyjcia odpowiedniego powiadomienia wyswietlam je w skrypcie 
// i usuwam dana zmienna z pamieci
if(isset($_SESSION['index_reminder'])){
    echo $_SESSION['index_reminder'];
    unset($_SESSION['index_reminder']);
    }
if(isset($_SESSION['message_reminder'])){
    echo $_SESSION['message_reminder'];
    unset($_SESSION['message_reminder']);
    }
if(isset($_SESSION['about_reminder'])){
    echo $_SESSION['about_reminder'];
    unset($_SESSION['about_reminder']);
    }
   
?>

