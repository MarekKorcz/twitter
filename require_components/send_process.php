<?php

// obsluga tworzenia wiadomosci
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['receiver_id']) && isset($_POST['message_text'])){  
    
    if(strlen($_POST['message_text']) > 0 && strlen($_POST['message_text']) <= 500 ){

        // tworze obiekt user'a wysyłającego wiadomość na podstawie id zapisanego
        // w zmiennej sesyjnej powstałej podczas logowania/rejestracji
        $sender_user = User::loadUserById($conn, $_SESSION['userId']);        
        
        // tworze obiekt user'a do którego wiadomość ma zostać wysłana
        $receiver_user = User::loadUserById($conn, $_POST['receiver_id']);  
        
        // przypisuje text do zmiennej
        $message_text = trim($_POST['message_text']);

        // tworze nowy komentarz
        $newMessage = new Message($message_text, $sender_user, $receiver_user);
        
        // zapisuje wiadomosc do bazy danych
        if($newMessage->saveMessageToDB($conn)){

            // tworze zmienna by wyswietlic komentarz o udanym 
            // wyslaniu wiadomosci
            $_POST['messageResult'] = "<label style=\"color: green;\"> "
                              . "Wiadomosc zostala wyslana !</label>"; 
        }
        else{
            
            // tworze zmienna by wyswietlic komentarz o nieudanym 
            // wyslaniu wiadomosci
            $_POST['messageResult'] = "<label style=\"color: red;\"> "
                              . "Nieudalo sie wyslac wiadomosci !</label>"; 
        }
    }
}


////////////////////////////////////////////////////////////////////////////////



// wczytuje wszystkich user'ow do zmiennej
$users = User::loadAllUsers($conn);

// sprawdzam czy zmienna zostala czymkolwiek wypelniona
if($users == true){
    
    // mierze dlugosc zmiennej w ktorej znajduja sie obiekty klasy User
    $users_length = count($users);
    
    // iteruje i wyswietlam wszystkich userow z pominieciem siebie samego
    for($i = 0; $i < $users_length; $i++){
        
        $single_user = $users[$i];

        if($single_user->getId() != $_SESSION['userId']){
            $single_user->showUserAsHTML();
        }
    }
}else{
    
    // jesli w bazie nic nie ma wyswietlam komentarz
    echo "Ten serwis nie zawiera innych uzytkownikow poza Toba! Przepraszamy!";
}


?>