<?php
    session_start();
    if(isset($_SESSION['isLogged']) && isset($_SESSION['userId'])){
       
       // usuwam zmienne sesyjne zalogowanego uzytkownika 
       unset($_SESSION['isLogged']);
       unset($_SESSION['userId']);
       
       // przekierowuje spowrotem do strony logowania
       header('Location: login.php');
    }   
?>