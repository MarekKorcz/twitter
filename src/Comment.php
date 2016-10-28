<?php

/*
 CREATE TABLE Comment(
 comment_id INT PRIMARY KEY AUTO_INCREMENT,
 p_id INT NOT NULL,
 comment_text VARCHAR(300),
 comment_owner VARCHAR(20),
 comment_date DATETIME,
 FOREIGN KEY(t_id) REFERENCES Tweet(tweet_id)
 ON DELETE CASCADE 
 )
 */ 

class Comment{
    private $comment_id;
    private $t_id;
    private $comment_text;
    private $comment_owner;
    private $comment_date;
    
    public function __construct(Tweet $tweet, $text, User $user){
        $this->comment_id = -1;
        $this->t_id = $tweet->getTweetId();
        $this->comment_text = $this->setCommentText($text);
        $this->comment_owner = $user->getUsername();
        $this->comment_date = date("Y-m-d h:i:s");
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
}