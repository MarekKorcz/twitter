<?php

// obsluga tworzenia tweet'a
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['tweet_submit'])){  

    if(isset($_POST['tweet_text']) && strlen($_POST['tweet_text']) > 0 
       && strlen($_POST['tweet_text']) <= 140){

        // tworze obiekt user'a na podstawie id zapisanego w zmiennej sesyjnej 
        // powstałej podczas logowania/rejestracji
        $user = User::loadUserById($conn, $_SESSION['userId']);

        // przypisuje text do zmiennej
        $tweet_text = $_POST['tweet_text'];

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
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['tweet_submit'])){  

    if(isset($_POST['comment_text']) && strlen($_POST['comment_text']) > 0 
       && strlen($_POST['comment_text']) <= 140 && isset($_POST['data-id'])){

        // tworze obiekt user'a na podstawie id zapisanego w zmiennej sesyjnej 
        // powstałej podczas logowania/rejestracji
        $user = User::loadUserById($conn, $_SESSION['userId']);
       
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>        
        
        // przypisuje id tweet'a do zmiennej            ALE SKĄD ????????????????
        $tweet_id = $_POST['data-id'];
  
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>        
        
        // tworze obiekt klasy Tweet
        $tweet = loadTweetById($conn, $tweet_id);
        
        // przypisuje text do zmiennej
        $comment_text = $_POST['comment_text'];

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
$arr = Tweet::loadAllTweets($conn);

// mierze dludosc tablicy
$length = count($arr);

for($i = 0; $i < $length; $i++){

       // wyciagam tweet'a z tablicy i przypisuje do zmiennej
        $tweet = $arr[$i];
    
       // następnie wyświtlam go przy uzyciu metody showAsHTML
        $tweet->showTweetAsHTML();

       // wyswietlam wszystkie komentarze 
        
        
       // a na koniec ostatniego z nich doczepiam formularz do dodania nowego 
       // komentarza ktoremu w parametrze podaje id ostatniego tweetu
        Comment::addCommentHTMLForm($tweet->getTweetId());
}



?>