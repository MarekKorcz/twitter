<?php

$user = User::loadUserById($conn, $_SESSION['userId']);

$name = $user->getUsername();
$email = $user->getEmail();
$date = $user->getDate();
$userPass = $user->getHashedPassword();



echo "<h3>O mnie: </h3>";
echo "Moje imie to: ".$name." <br>";
echo "Moj email to: ".$email." <br>";
echo "Data stworzenia mojego konta: ".$date." <br>";


//////////////////////////////////////////////////////////////////////////////////////////


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){  

    // sprawdzam czy ktos wyslal cos formularzem zmiany hasla oraz sprawdzam zgodnosc nowego hasla
    if(isset($_POST['newPass1']) && isset($_POST['newPass2']) && isset($_POST['oldPass']) &&
             $_POST['newPass1'] == $_POST['newPass2'] && strlen($_POST['newPass1'] > 5)){

        // trimuje nowe haslo
        $newPass = trim($_POST['newPass1']);

        // hashuje nowe podane przez user'a haslo
        $new_hashed_pass = password_hash($newPass, PASSWORD_DEFAULT);

        // trimuje podane przez uzytkownika w formularzu stare haslo
        $oldPass = trim($_POST['oldPass']);

        // hashuje stare podane przez user'a haslo
        //$old_hashed_pass = password_hash($oldPass, PASSWORD_DEFAULT);

        // porownuje podane przez user'a stare haslo z tym z bazy danych
        if(password_verify($oldPass, $userPass)){

            // zmieniam haslo w atrybucie obiektu user'a
            $user->setPassword($new_hashed_pass);

            // zapisuje zmiany w obiekcie
            if($user->saveToDB($conn)){
                
                // jesli uda sie zapisac tworze zminna z odpowiednim komunikatem
                $_POST['changedPass'] = "<label style=\"color: green;\"> "
                                      . "Haslo zostalo zmienione !! </label>";
            }else{
                
                // jesli nie uda sie zapisac tworze zminna z odpowiednim komunikatem
                $_POST['changedPass'] = "<label style=\"color: red;\"> "
                                      . "Hasla nie udalo sie zmienic. Blad !! </label>";
            }
        }else{
            
            // jesli podane przez user'a stare haslo rozni sie od tego z bazy danych, 
            // tworze zminna z odpowiednim komunikatem
            $_POST['changedPass'] = "<label style=\"color: red;\"> "
                                  . "Podane przez Ciebie stare haslo rozni "
                                  . "sie od tego z bazy danych !! </label>";
        }
    }else{
        
        // jesli hasla roznia sie od siebie lub maja zla dluosc tworze zminna 
        // z odpowiednim komunikatem
        $_POST['changedPass'] = "<label style=\"color: red;\"> "
                                      . "Hasla roznia sie od siebie lub "
                                      . "maja inna dlugosc !! </label>";
    }
}
?>