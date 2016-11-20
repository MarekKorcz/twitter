<?php

/*
CREATE TABLE Tweet (
tweet_id INT PRIMARY KEY AUTO_INCREMENT,
user_id INT NOT NULL,
user_name VARCHAR(20),
tweet_text VARCHAR(140),
tweet_creation_date DATETIME,
FOREIGN KEY(user_id) REFERENCES User(user_id)
ON DELETE CASCADE
)
*/ 

class Tweet{
    private $tweet_id;
    private $user_id;
    private $user_name;
    private $tweet_text;
    private $tweet_creation_date;
    
    public function __construct(User $user = NULL, $tweet_text = ""){
        
        $this->tweet_id = -1;
        $user != NULL ? $this->user_id = $user->getId() : $this->user_id = -1;
        $user != NULL ? $this->user_name = $user->getUsername() : $this->user_name = "";
        $this->tweet_text = $tweet_text;
        $this->tweet_creation_date = date("Y-m-d h:i:s");
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
        return $this->user_id;
    }
    
    public function getUserName(){
        return $this->user_name;
    }
    
    public function getText(){
        return $this->tweet_text;
    }

    public function getDate(){
        return $this->tweet_creation_date;
    }

    public function saveToDB(mysqli $connection){
        if($this->tweet_id == -1){
            $sql = "INSERT INTO Tweet (user_id, user_name, tweet_text, tweet_creation_date) "
                 . "VALUES ('$this->user_id', '$this->user_name','$this->tweet_text', '$this->tweet_creation_date')";
            
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

    public function showTweetAsHTML(){

        // przypisuje wlasciwosci obiektu do zmiennych
        $user_id = $this->getUserId();
        $user_name = "<a href=\"user.php?id=$user_id\">".$this->getUserName()."</a>";
        $tweet_text = $this->getText();
        $tweet_date = $this->getDate();

        // wyswietlam tweet'a
echo<<<EOT
        <div name="tweet" style="width: 900px; height: 80px; background-color: green; border: 5px solid black;">
            <strong>Tweet uzytkownika: </strong>$user_name<br>
            <strong>Tresc tweet'u: </strong>$tweet_text<br>
            <strong>Data stworzenia tweet'u: </strong>$tweet_date
        </div><br>
EOT;

    }
    
    static public function loadAllTweets(mysqli $connection){
        $sql = "SELECT * FROM Tweet ORDER BY tweet_creation_date DESC";
        
        $arr =[];
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedTweet = new Tweet();
                $loadedTweet->tweet_id = $row['tweet_id'];
                $loadedTweet->user_id = $row['user_id'];
                $loadedTweet->user_name = $row['user_name'];
                $loadedTweet->tweet_text = $row['tweet_text'];
                $loadedTweet->tweet_creation_date = $row['tweet_creation_date'];
                
                $arr[] = $loadedTweet;
            }
        }else{
                echo "Brak Tweet'ow w bazie danych!";
        }
        
        return $arr;
    }    
    
    static public function loadTweetById(mysqli $connection, $tweet_id){
        $sql = "SELECT * FROM Tweet WHERE tweet_id = \"$tweet_id\"";
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet->tweet_id = $row['tweet_id'];
            $loadedTweet->user_id = $row['user_id'];
            $loadedTweet->user_name = $row['user_name'];
            $loadedTweet->tweet_text = $row['tweet_text'];
            $loadedTweet->tweet_creation_date = $row['tweet_creation_date'];
            
            return $loadedTweet;
        }else{
            echo "Brak Tweet'ow o podanym id!";
        }
        return null;
    }
    
    static public function loadAllTweetsByUserId(mysqli $conn, $user_id){
        $sql = "SELECT * FROM Tweet WHERE user_id ='$user_id' ORDER BY tweet_creation_date DESC";
        
        $arr =[];
        
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedTweet = new Tweet();
                $loadedTweet->tweet_id = $row['tweet_id'];
                $loadedTweet->user_id = $row['user_id'];
                $loadedTweet->user_name = $row['user_name'];
                $loadedTweet->tweet_text = $row['tweet_text'];
                $loadedTweet->tweet_creation_date = $row['tweet_creation_date'];
                
                $arr[] = $loadedTweet;
            }
        }else{
            echo "Nie masz zadnych tweet'ow! ";
        }
        return $arr;
    }
}