<?php

session_start();
    
    if(isset($_SESSION['isLogged']) && isset($_SESSION['userId'])){
        header("Location: index.php");
        exit();
    }

?>