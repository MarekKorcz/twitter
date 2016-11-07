<?php
    
    // wczytuje wszystkie wiadomosci otrzymane przez user'a
    $messages = Message::loadAllMessagesByUserId($conn, $_SESSION['userId']);
    
    // sprawdzam czy zmienna zostala czymkolwiek wypelniona
    if($messages == true){
        // mierze dlugosc zmiennej w ktorej znajduja sie obiekty klasy User
        $messages_length = count($messages);

        // iteruje wszystkie wiadomosci
        for($i = 0; $i < $messages_length; $i++){

            // przypisuje pojedyncza wiadomosc do zmiennej
            $single_message = $messages[$i];

            // wyswietlam widomosc     ....................................
        }
    }else{

        // jezeli w bazie nie zadncyh wiadomosci, wyswietlam komentarz
        echo "Skrzynka pusta!";
    }

?>