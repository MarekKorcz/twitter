<?php

if(isset($_GET['id'])){  
    // wczytuje wszystkie tweet'y user'a z bazy
    $arr_own_tweets = Tweet::loadAllTweetsByUserId($conn, $_GET['id']);

    if($arr_own_tweets == true){

        // wyciagam imie user'a i je wyswietlam
        $username = User::loadUserById($conn, $_GET['id'])->getUsername();

        echo "<h2>Tweety uzytkownika: $username </h2>";

        // mierze dlugosc tablicy
        $own_tweets_length = count($arr_own_tweets);

        for($i = 0; $i < $own_tweets_length; $i++){

            // wyciagam pojedynczego tweet'a z tablicy i przypisuje do zmiennej
             $tweet = $arr_own_tweets[$i];

            // następnie wyświtlam go przy uzyciu metody showAsHTML
             $tweet->showTweetAsHTML();

            // wyciagam (jesli istnieja) komentarze do zmiennej 
             $arr_comment = Comment::loadCommentsByTweetId($conn, $tweet->getTweetId());

            // sprawdzam czy itnieja
            if(count($arr_comment) > 0){

                // licze ich ilosc w tablicy
                $comment_length = count($arr_comment);

                echo "<label style=\"margin-left:40em;\">Liczba komentarzy do postu: $comment_length</label><br><br>";
            }
        }
    }
}

?>
