<?php

// formularz rejestracji z register.php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
        
        // walidacja name'a
        if(isset($_POST['name']) && strlen(trim($_POST['name'])) > 3){
            
            // dodaje imie ktore przyszlo post'em do zmiennej
            $user_name = trim($_POST['name']);
        }else{
            
            // jesli imie nie przeszlo walidacji to tworze zmienna oznaczajaca error
            $_POST['error_name'] = true;
        }
        
        
        //walidacja email'a
        if(isset($_POST['email']) && filter_var($_POST['email'], 
           FILTER_VALIDATE_EMAIL)){
            
            // dodaje email ktory przyszedl post'em do zmiennej
            $user_email = $_POST['email'];
        }else{
            
            // jesli email nie przeszedl walidacji to tworze zmienna oznaczajaca error
            $_POST['error_email'] = true;
        }
        
        
        // walidacja hasla
        if(isset($_POST['pass1']) && strlen(trim($_POST['pass1'])) > 5 
           && ($_POST['pass1'] == trim($_POST['pass2']))){
            
            // dodaje haslo ktore przyszlo post'em do zmiennej
            $user_password = trim($_POST['pass1']);
        }else{
            
            // jesli haslo nie przeszlo walidacji to tworze zmienna oznaczajaca error
            $_POST['error_pass'] = true;
        }
        
        
        // Sprawdzenie czy zmienna (badz zmienne) 'error' istnieje/a. 
        // Jesli nie to wykonuje probe zapisu User'a do bazy danych.
        if(isset($_POST['error_name']) || isset($_POST['error_email']) 
           || isset($_POST['error_pass'])){
            
            // jesli nie to generuje wiadomosc o bledzie rejestracji 
                $_POST['error_reg'] = "<label style=\"color: red;\">"
                                    . "Blad rejestracji</label>";
        }else{
            
            // hash'uje haslo
            $hashed_pass = password_hash($user_password, PASSWORD_DEFAULT);
            
            // przypisuje date do zmiennej
            $date = date("Y-m-d h:i:s");
            
            // tworze obiekt klasy User
            $user = new User($user_email, $user_name, $hashed_pass, $date);
            
            // nastepnie robie probe zapisu do bazy danych
            if($user->saveToDB($conn)){

                // tworze zmienne sesyjne zalogowanego uzytkownika
                $_SESSION['isLogged'] = true;
                $_SESSION['userId'] = $user->getId();

                // przekierowuje do strony glownej
                header("Location: index.php");
            }else{
                
                // gdyby zapis sie nie udal to tworze komunikat 
                // o zajetym juz adresie email
                $_POST['busy_email'] = true;
            }
        }
    }