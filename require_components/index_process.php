<?php

// obsluga tworzenia tweet'a
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['tweet_submit'])){  

    if(isset($_POST['tweet_text']) && strlen($_POST['tweet_text']) > 0 
       && strlen($_POST['tweet_text']) <= 140){

        // tworze obiekt user'a na podstawie id zapisanego w zmiennej sesyjnej 
        // powstałej podczas logowania/rejestracji
        $user = User::loadUserById($conn, $_SESSION['userId']);

        // przypisuje text do zmiennej
        $tweet_text = trim($_POST['tweet_text']);

        // tworze nowego tweet'a
        $newTweet = new Tweet($user, $tweet_text);

        if($newTweet){

            // zapisuje nowego tweet'a 
            $newTweet->saveToDB($conn);
        }
    }
}


////////////////////////////////////////////////////////////////////////////////

// obsluga tworzenia komentarza
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['tweet_id']) && isset($_GET['comment_text'])){  

    // ........... wartoby jeszcze dodac isset($_GET['comment_submit'])...........
    
    if(strlen($_GET['comment_text']) > 0 && strlen($_GET['comment_text']) <= 140 ){

        // tworze obiekt user'a na podstawie id zapisanego w zmiennej sesyjnej 
        // powstałej podczas logowania/rejestracji
        $user = User::loadUserById($conn, $_SESSION['userId']);        
        
        // przypisuje id tweet'a do zmiennej
        $tweet_id = $_GET['tweet_id'];  
        
        // tworze obiekt klasy Tweet
        $tweet = Tweet::loadTweetById($conn, $tweet_id);
        
        // przypisuje text do zmiennej
        $comment_text = trim($_GET['comment_text']);

        // tworze nowy komentarz
        $newComment = new Comment($comment_text, $user, $tweet);
        
        if($newComment){
            
            // zapisuje komentarz do bazy danych
            $newComment->saveCommentToDB($conn);
        }
    }
}


////////////////////////////////////////////////////////////////////////////////

// wczytuje wszystkie tweet'y z bazy
$arr_tweet = Tweet::loadAllTweets($conn);

// mierze dludosc tablicy
$tweet_length = count($arr_tweet);

for($i = 0; $i < $tweet_length; $i++){

       // wyciagam tweet'a z tablicy i przypisuje do zmiennej
        $tweet = $arr_tweet[$i];
    
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



?>