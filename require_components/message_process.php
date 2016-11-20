<?php
    
    // wyswietlam komentarz do otrzymanych wiadomosci
    echo "<h3>Twoje otrzymane wiadomości:</h3>";
    
    // wczytuje wszystkie wiadomosci otrzymane przez user'a
    $received_messages = Message::loadAllReceivedMessagesByUserId($conn, $_SESSION['userId']);
    
    // sprawdzam czy zmienna zostala czymkolwiek wypelniona
    if($received_messages == true){
        // mierze dlugosc zmiennej w ktorej znajduja sie obiekty klasy Message
        $messages_length = count($received_messages);

        // iteruje wszystkie wiadomosci
        for($i = 0; $i < $messages_length; $i++){

            // przypisuje pojedyncza wiadomosc do zmiennej
            $single_message = $received_messages[$i];

            // wyswietlam widomosc
            $single_message->showReceivedMessageAsHTMLLink();
        }
    }else{

        // jezeli w bazie nie zadncyh otrzymanych wiadomosci, wyswietlam komentarz
        echo "Nie masz zadnych otrzymanych wiadomosci!";
    }
    
    
/////////////////////////////////////////////////////////////////////////////////////    
    
    
    // wyswietlam komentarz do otrzymanych wiadomosci
    echo "<h3>Twoje wyslane wiadomości:</h3>";

    // wczytuje wszystkie wiadomosci wyslane przez user'a
    $sended_messages = Message::loadAllSendedMessagesByUserId($conn, $_SESSION['userId']);
    
    // sprawdzam czy zmienna zostala czymkolwiek wypelniona
    if($sended_messages == true){
        // mierze dlugosc zmiennej w ktorej znajduja sie obiekty klasy Message
        $messages_length = count($sended_messages);
        
        // iteruje wszystkie wiadomosci
        for($i = 0; $i < $messages_length; $i++){

            // przypisuje pojedyncza wiadomosc do zmiennej
            $single_message = $sended_messages[$i];

            // wyswietlam widomosc     ....................................
            $single_message->showSendedMessageAsHTMLLink();
        }        
    }else{
        
        // jezeli w bazie nie zadncyh wyslanych wiadomosci, wyswietlam komentarz
        echo "Nie masz zadnych wyslanych wiadomosci!";
    }
?>