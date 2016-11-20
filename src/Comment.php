<?php

/*
 CREATE TABLE Comment(
 comment_id INT PRIMARY KEY AUTO_INCREMENT,
 comment_date DATETIME,
 comment_text VARCHAR(60),
 comment_owner VARCHAR(20),
 comment_owner_id INT NOT NULL,
 tweet_id INT NOT NULL,
 FOREIGN KEY(tweet_id) REFERENCES Tweet(tweet_id)
 ON DELETE CASCADE 
 )
 */ 

class Comment{
    
    private $comment_id;
    private $comment_date;
    private $comment_text;
    private $comment_owner;
    private $comment_owner_id;
    private $tweet_id;

    
    public function __construct($text = "", User $user = NULL, Tweet $tweet = NULL){
        $this->comment_id = -1;
        $this->comment_date = date("Y-m-d h:i:s");
        $this->comment_text = $text;
        $user != NULL ? $this->comment_owner = $user->getUsername() : $this->comment_owner = "";
        $user != NULL ? $this->comment_owner_id = $user->getId() : $this->comment_owner_id = "";
        $tweet != NULL ? $this->tweet_id = $tweet->getTweetId() : $this->tweet_id = -1;
    }
    
    public function setCommentText($text){
        if(is_string($text) && strlen($text) > 0){
             $this->comment_text = $text;
        }
    }
    
    public function getTweetId() {
        return $this->tweet_id;
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
    
    public function getCommentOwnerId() {
        return $this->comment_owner_id;
    }
    
    public function getCommentId(){
        return $this->comment_id;
    }
    
    public function saveCommentToDB(mysqli $conn){
        if($this->comment_id == -1){
            $sql = "INSERT INTO Comment (comment_date, comment_text, "
                 . "comment_owner, comment_owner_id, tweet_id) VALUES ('$this->comment_date', "
                 . "'$this->comment_text', '$this->comment_owner', '$this->comment_owner_id', "
                 . "'$this->tweet_id')";
        }
        
        $result = $conn->query($sql);
        
        if($result == true){
            $this->comment_id = $conn->insert_id;
            return true;
        }
        return false;
    }
    
    public function showCommentAsHTML(){

        // przypisuje wlasciwosci obiektu do zmiennych
        $comment_owner_id = $this->getCommentOwnerId();
        $comment_owner = "<a href=\"user.php?id=$comment_owner_id\">".$this->getCommentOwner()."</a>";
        $comment_text = $this->getCommentText();
        $comment_date = $this->getCommentDate();

        // wyswietlam tweet'a
echo<<<EOT
        <div name="comment" style="width: 900px; height: 80px; background-color: red; border: 5px solid black;">
        <strong>Komentarz uzytkownika: </strong>$comment_owner<br>
        <strong>Tresc komentarza: </strong>$comment_text<br>
        <strong>Data stworzenia komentarza: </strong>$comment_date
        </div><br>
EOT;

    }
    
    static public function addCommentHTMLForm(Tweet $tweet){

        $tweet_id = $tweet->getTweetId();
         
        // wyswietlam formularz do wpisania komentarza
        echo "<div name=\"comment\" style=\"width: 900px; height: 80px; "
           . "background-color: yellow; border: 5px solid orange;\">";
        echo "<form method=\"GET\" action=\"#\">";
        echo "<input type=\"hidden\" name=\"tweet_id\" value=\"$tweet_id\">";
        echo "<strong>Dodaj&nbsp;komentarz:</strong><br>";
        echo "<textarea placeholder=\"Napisz swoj komentarz(max 60 znaków)!\" " 
           . "name=\"comment_text\" rows=\"3\" cols=\"110\" maxlength=\"140\"> "
           . "</textarea><br><br>";
        echo "<input type=\"submit\" value=\"Wyslij komentarz\" name=\"comment_submit\">";
        echo "</form></div><br><br>";
    }
    
    static public function loadCommentsByTweetId(mysqli $conn, $tweet_id){
        $sql = "SELECT * FROM Comment WHERE tweet_id = \"$tweet_id\"";
        
        $result = $conn->query($sql);
        
        $arr = [];
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedComment = new Comment();
                $loadedComment->comment_id = $row['comment_id'];
                $loadedComment->comment_date = $row['comment_date'];
                $loadedComment->comment_text = $row['comment_text'];
                $loadedComment->comment_owner = $row['comment_owner'];
                $loadedComment->comment_owner_id = $row['comment_owner_id'];
                $loadedComment->tweet_id = $row['tweet_id'];
                
                $arr[] = $loadedComment;
            }
            
            return $arr;
        }
        return null;
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
                $loadedComment->comment_owner_id = $row['comment_owner_id'];
                $loadedComment->tweet_id = $row['tweet_id'];
                
                $arr[] = $loadedComment;
            }
        }return $arr;
    }
}