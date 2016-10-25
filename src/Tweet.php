<?php

/*
CREATE TABLE Tweet (
tweet_id INT PRIMARY KEY AUTO_INCREMENT,
u_id INT NOT NULL,
tweet_text VARCHAR(140),
tweet_creation_date DATETIME,
FOREIGN KEY(u_id) REFERENCES User(user_id)
ON DELETE CASCADE
)
*/ 

class Tweet{
    private $tweet_id;
    private $u_id;
    private $tweet_text;
    private $tweet_creation_date;
    
    public function __construct(User $user, $tweet_text = "", $tweet_creation_date = ""){
        $this->tweet_id = -1;
        $this->u_id = setUserId($user->getId());  
        $this->tweet_text = $tweet_text;
        $this->tweet_creation_date = $tweet_creation_date;
    }
    
    public function setUserId($user_id) {
        if(is_integer($user_id) && $user_id > 0){
            $this->u_id = $user_id;
        }
    }
    
    public function setText($newText) {
        if(is_string($newText) && strlen($newText) > 0){
            $this->tweet_text = $newText;
        }
    }
    
    public function setDate($newDate){
        if(strlen($newDate) > 0){
            $this->tweet_creation_date = $newDate;
        }
    }
    
    public function getTweetId(){
        return $this->tweet_id;
    }

    public function getUserId() {
        return $this->u_id;
    }
    
    public function getText(){
        return $this->tweet_text;
    }

    public function getDate(){
        return $this->tweet_creation_date;
    }

    public function saveToDB(mysqli $connection){
        if($this->tweet_id == -1){
            $sql = "INSERT INTO Tweet (u_id, tweet_text, tweet_creation_date) "
                 . "VALUES ('$this->u_id', '$this->tweet_text', '$this->tweet_creation_date')";
            
            $result = $connection->query($sql);
            
            if($result == true){
                $this->tweet_id = $connection->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE Tweet SET tweet_text = '$this->tweet_text', "
                 . "tweet_creation_date = '$this->tweet_creation_date' "
                 . "WHERE tweet_id = '$this->tweet_id'";
            $result = $connection->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    }
    
    static public function loadAllTweets(mysqli $connection){
        $sql = "SELECT * FROM Tweet";
        
        $arr =[];
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedTweet = new Tweet();
                $loadedTweet->tweet_id = $row['tweet_id'];
                $loadedTweet->u_id = $row['u_id'];
                $loadedTweet->tweet_text = $row['tweet_text'];
                $loadedTweet->tweet_creation_date = $row['tweet_creation_date'];
                
                $arr = $loadedTweet;
            }
        }else{
                echo "Brak Tweet'ow w bazie danych!";
        }
        
        return $arr;
    }    
    
    static public function loadTweetById(mysqli $connection, $tweet_id){
        $sql = "SELECT * FROM Tweet WHERE tweet_id = $tweet_id";
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows == 0){
            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet->tweet_id = $row['tweet_id'];
            $loadedTweet->u_id = $row['u_id'];
            $loadedTweet->tweet_text = $row['tweet_text'];
            $loadedTweet->tweet_creation_date = $row['tweet_creation_date'];
            
            return $loadedTweet;
        }else{
            echo "Brak Tweet'ow o podanym id!";
        }
        return null;
    }
    
    static public function loadAllTweetsByUserId(mysqli $connection, User $user){
        $sql = "SELECT * FROM Tweet WHERE u_id = $user->getId()";
        
        $arr =[];
        
        $result = $connection->query($sql);
        
        if($result == true && $result != 0){
            foreach($result as $row){
                $loadedTweet = new Tweet();
                $loadedTweet->tweet_id = $row['tweet_id'];
                $loadedTweet->u_id = $row['u_id'];
                $loadedTweet->tweet_text = $row['tweet_text'];
                $loadedTweet->tweet_creation_date = $row['tweet_creation_date'];
                
                $arr = $loadedTweet;
            }
        }else{
            echo "Brak Tweet'ow nalezacych do danego User'a";
        }
        return $arr;
    }
}