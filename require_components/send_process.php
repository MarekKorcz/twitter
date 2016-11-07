<?php

// obsluga tworzenia wiadomoscie
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['receiver_id']) && isset($_GET['message_text'])){  

    // ........... wartoby jeszcze dodac isset($_GET['message_submit'])...........
    
    if(strlen($_GET['message_text']) > 0 && strlen($_GET['message_text']) <= 500 ){

        // tworze obiekt user'a wysyłającego wiadomość na podstawie id zapisanego
        // w zmiennej sesyjnej powstałej podczas logowania/rejestracji
        $sender_user = User::loadUserById($conn, $_SESSION['userId']);        
        
        // tworze obiekt user'a wysyłającego wiadomość na podstawie id zapisanego
        // w zmiennej sesyjnej powstałej podczas logowania/rejestracji
        $receiver_user = User::loadUserById($conn, $_GET['receiver_id']);  
        
        // przypisuje text do zmiennej
        $message_text = trim($_GET['message_text']);

        // tworze nowy komentarz
        $newMessage = new Message($sender_user, $receiver_user, $message_text);
        
        
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
        //var_dump($single_user);
        if($single_user->getId() != $_SESSION['userId']){
            $single_user->showUserAsHTML();
        }
    }
}else{
    
    // jesli w bazie nic nie ma wyswietlam komentarz
    echo "Ten serwis nie zawiera innych uzytkownikow poza Toba! Przepraszamy!";
}


?>