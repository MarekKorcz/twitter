<?php

// formularz logowania z login.php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){        
        
        //walidacja email'a
        if(isset($_POST['email']) && filter_var($_POST['email'], 
          FILTER_VALIDATE_EMAIL)){
            // dodaje email ktory przyszedl post'em do zmiennej
            $user_email = $_POST['email'];
        }else{
            // tworze error kiedy email ma zla strukture 
            $_POST['error_email'] = true;
        }
        
        
        // waliduje haslo
        if(isset($_POST['pass'])){
            
            //przypisuje haslo do zmiennej
            $user_password = $_POST['pass'];
        }
        
        
        // Sprawdzenie czy zmienna (badz zmienne) 'error' istnieje/a. 
        // Jesli nie to wykonuje probe logowania User'a.
        if(isset($_POST['error_name']) || isset($_POST['error_email']) 
           || isset($_POST['error_pass'])){
            
            /// jesli istnieje/ą to generuje wiadomosc o bledzie logowania 
            $_POST['error_log'] = "<label style=\"color: red;\">"
                                 . "Blad logowania</label>";
        }else{
            
            // hash'uje haslo zeby porownac je z hash'em z bazy danych
            $hashed_pass = password_hash($user_password, PASSWORD_DEFAULT);
            
            // wywoluje statyczna metode klasy User w celu wczytania user'a z bazy danych
            $user = User::loadUserByEmailAndPassword($conn, $user_email, $hashed_pass);
            
            // sprawdzam czy logowanie powiodlo sie
            if($user){

                // tworze zmienne sesyjne zalogowanego uzytkownika
                $_SESSION['isLogged'] = true;
                $_SESSION['userId'] = $user->getId();
                
                // przekierowywuje do strony glownej
                header("Location: index.php");
            }else{
                
                // jesli nie to generuje wiadomosc o bledzie logowania 
                $_POST['error_log'] = "<label style=\"color: red;\">"
                        . "Blad logowania</label>";
            }
        }
        
    }
    
?>