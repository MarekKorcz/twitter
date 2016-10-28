<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){  

    if(isset($_POST['tweet_text']) && strlen($_POST['tweet_text']) > 0 
       && strlen($_POST['tweet_text']) <= 140){

        // tworze obiekt user'a na podstawie id zapisanego w zmiennej sesyjnej 
        // powstałej podczas logowania/rejestracji
        $user = User::loadUserById($conn, $_SESSION['userId']);

        // przypisuje date do zmiennej
        $tweet_date = date("Y-m-d h:i:s");

        // przypisuje text do zmiennej
        $tweet_text = $_POST['tweet_text'];

        // tworze nowego tweet'a
        $newTweet = new Tweet($user, $tweet_text, $tweet_date);

        if($newTweet){

            // zapisuje nowego tweet'a 
            $newTweet->saveToDB($conn);
        }
    }
}

// wczytuje wszystkie tweet'y z bazy
$arr = Tweet::loadAllTweets($conn);

$length = count($arr);

for($i = 0; $i < $length; $i++){

    // wyciagam obiekt z tablicy i przypisuje do zmiennej poniewac w parametrze 
    // funkcji nie moge uzyć tablicy z indeksem
        $tweet = $arr[$i];
        $convertedTweet = (string)$tweet;
    
    // wyswietlam wszystkie tweet'y po kolei
        Tweet::showAsHTML($convertedTweet);
}

?>