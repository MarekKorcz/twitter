<?php

/*
 CREATE TABLE Comment(
 comment_id INT PRIMARY KEY AUTO_INCREMENT,
 comment_date DATETIME,
 comment_text VARCHAR(200),
 comment_owner VARCHAR(20),
 t_id INT NOT NULL,
 FOREIGN KEY(t_id) REFERENCES Tweet(tweet_id)
 ON DELETE CASCADE 
 )
 */ 

class Comment{
    
    private $comment_id;
    private $comment_date;
    private $comment_text;
    private $comment_owner;
    private $t_id;
    
    public function __construct($text, User $user = NULL, Tweet $tweet = NULL){
        $this->comment_id = -1;
        $this->comment_date = date("Y-m-d h:i:s");
        $this->comment_text = $this->setCommentText($text);
        $user != NULL ? $this->comment_owner = $user->getUsername() : $this->comment_owner = "";
        $tweet != NULL ? $this->t_id = $tweet->getTweetId() : $this->t_id = -1;
    }
    
    public function setCommentText($text){
        if(is_string($text) && strlen($text) > 0){
             $this->comment_text = $text;
        }
    }
    
    public function getTweetId() {
        return $this->t_id;
    }
    
    public function getCommentText() {
        return $this->comment_text;
    }
    
    public function getCommentOwner() {
        return $this->comment_owner;
    }
    
    public function getCommentDate() {
        return $this->comment_date;
    }
    
    public function saveCommentToDB(mysqli $conn){
        if($this->comment_id == -1){
            $sql = "INSERT INTO Comment ('t_id', 'comment_text', 'comment_owner', "
                 . "'comment_date') VALUES ('$this->t_id', '$this->comment_text', "
                 . "'$this->comment_owner', '$this->comment_date')";
        }
        
        $result = $conn->query($sql);
        
        if($result == true){
            $this->comment_id = $conn->insert_id;
            return true;
        }
        return false;
    }
    
     static public function addCommentHTMLForm($tweet_id){

        // wyswietlam formularz do wpisania komentarza
        echo "<div name=\"comment\" data-id=\"$tweet_id\" style=\"width: 900px; height: 80px; "
           . "background-color: yellow; border: 5px solid orange;\">";
        echo "<form method=\"post\" action=\"#\">";
        echo "<strong>Dodaj&nbsp;komentarz:</strong><br>";
        echo "<textarea placeholder=\"Napisz swoj komentarz(max 140 znaków)!\" " 
           . "name=\"comment_text\" rows=\"3\" cols=\"110\" maxlength=\"140\"> "
           . "</textarea><br><br>";
        echo "<input type=\"submit\" value=\"Wyslij komentarz\" name=\"comment_submit\"/>";
        echo "</form></div><br><br>";
    }
    
    public function showCommentAsHTML(){

        // przypisuje wlasciwosci obiektu do zmiennych
        $tweet_id = $this->getTweetId();
        $u_name = $this->getUserName();
        $tweet_text = $this->getText();
        $tweet_date = $this->getDate();

        // wyswietlam tweet'a
        echo "<div name=\"tweet\" data-id=\"$tweet_id\" style=\"width: 900px; height: 80px; "
           . "background-color: green; border: 5px solid black;\">";
        echo "<strong>Tweet&nbsp;uzytkownika:</strong>&nbsp;$u_name<br>";
        echo "<strong>Tresc&nbsp;tweet'u:</strong>&nbsp;$tweet_text<br>";
        echo "<strong>Data&nbsp;stworzenia tweet'u:</strong>&nbsp;$tweet_date";
        echo "</div><br>";

    }
    
    static public function loadAllComments(mysqli $conn){
        $sql = "SELECT * FROM Comment";
        
        $arr = [];
        
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedComment = new Comment();
                $loadedComment->comment_id = $row['comment_id'];
                $loadedComment->comment_date = $row['comment_date'];
                $loadedComment->comment_text = $row['comment_text'];
                $loadedComment->comment_owner = $row['comment_owner'];
                $loadedComment->t_id = $row['t_id'];
                
                $arr[] = $loadedComment;
            }
        }return $arr;
    }
}