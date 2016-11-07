<?php
/*
if(!isset($_SESSION['loggedUserId'])){
    header('Location: test2.php');
}else{
    echo "test1.php";
}
 */


echo "<div name=\"tweet\" style=\"width: 900px; height: 80px; "
    . "background-color: green; border: 5px solid black;\">";
echo "<strong>Tweet&nbsp;uzytkownika:</strong>&nbsp;Zbyszko<br>";
echo "<strong>Tresc&nbsp;tweet'u:</strong>&nbsp;Hop Cola to scierwo<br>";
echo "<strong>Data&nbsp;stworzenia tweet'u:</strong>&nbsp;12-12-2012";
echo "</div><br>";


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['comment_submit'])){  

    if(isset($_POST['comment_text']) && strlen($_POST['comment_text']) > 0 
       && strlen($_POST['comment_text']) <= 140 ){

        
        // przypisuje id tweet'a do zmiennej
        $tweet_id = $_POST['tweet_id'];
        
        // przypisuje text do zmiennej
        $comment_text = $_POST['comment_text'];

        echo "Tresc textu: ".$comment_text."<br>";
        echo $tweet_id;
        
    }
}


echo "<div name=\"comment\" style=\"width: 900px; height: 80px; "
    . "background-color: yellow; border: 5px solid orange;\">";
echo "<form method=\"POST\" action=\"#\">";
echo "<input type=\"hidden\" name=\"tweet_id\" value=\"13\">";
echo "<strong>Dodaj&nbsp;komentarz:</strong><br>";
echo "<textarea placeholder=\"Napisz swoj komentarz(max 140 znaków)!\" " 
    . "name=\"comment_text\" rows=\"3\" cols=\"110\" maxlength=\"140\"> "
    . "</textarea><br><br>";
echo "<input type=\"submit\" value=\"Wyslij komentarz\" name=\"comment_submit\">";
echo "</form></div><br><br>";



?>