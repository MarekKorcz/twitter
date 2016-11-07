<?php

// wczytuje wszystkie tweet'y danego user'a z bazy
$arr_own_tweets = Tweet::loadAllTweetsByUserId($conn, $_SESSION['userId']);

// mierze dludosc tablicy
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
            
            // nastepnie wyswietlam przy uzyciu petli for
            for($j = 0; $j < $comment_length; $j++){
                
                $comment = $arr_comment[$j];
                
                $comment->showCommentAsHTML();
            }
        }

       // a na koniec ostatniego z nich doczepiam formularz do dodania nowego 
       // komentarza ktoremu w parametrze podaje obiekt ostatniego tweetu
        Comment::addCommentHTMLForm($tweet);
}
