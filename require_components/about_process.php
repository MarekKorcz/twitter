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
    if(isset($_POST['newPass1']) && isset($_POST['newPass2']) &&
            $_POST['newPass1'] == $_POST['newPass2'] && isset($_POST['oldPass']) && 
            strlen($_POST['newPass1']) > 5){   
        
        // trimuje podane przez uzytkownika w formularzu stare haslo
        $oldPass = trim($_POST['oldPass']);

        // przypisuje email do zmiennej
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        // tworze obiekt klasy user
        $user = User::loadUserByEmailAndPassword($conn, $email, $oldPass);

        if($user == true){
   
            // trimuje nowe haslo
            $newPass1 = trim($_POST['newPass1']);

            // przypisuje nowe haslo do obiektu
            $user->setPassword($newPass1);

            // zapisuje zmiany
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
            // jesli nie uda sie stworzyc obiektu klasy user to tworze 
            // zminna z odpowiednim komunikatem
            $_POST['changedPass'] = "<label style=\"color: red;\"> "
                     . "Zostalo podane zle haslo od konta !</label>";
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