<?php

/*
CREATE TABLE User (
user_id INT PRIMARY KEY AUTO_INCREMENT,
email VARCHAR(30) UNIQUE,
username VARCHAR(20),
hashed_password VARCHAR(100),
creation_date DATETIME
); 
*/

class User {

    private $user_id;
    private $email;
    private $username;
    private $hashed_password;
    private $creation_date;

    /**
     * User constructor.
     */
    public function __construct($email = "", $username = "", $hashed_password = "", $creation_date = "") {
        $this->user_id = -1;
        $this->email = $email;
        $this->username = $username;
        $this->hashed_password = $hashed_password;
        $this->creation_date = $creation_date;
    }

    /**
    * @param type $newEmail
    */
    public function setEmail($newEmail) {
        $this->email = $newEmail;
    }
    
    /**
     * @param type $newUsername
     */
    public function setName($newUsername) {
        $this->username = $newUsername;
    }

    /**
     * @param type $newPassword
     */
    public function setPassword($newPassword) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hashed_password = $newHashedPassword;
    }
    
    /**
     * @param type $newDate
     */
    public function setDate($newDate) {
        $this->creation_date = $newDate;
    }

    /**
     * @return type
     */
    public function getId(){
        return $this->user_id;
    }
    
    /**
    * @return type
    */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * @return type
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return type
     */
    public function getHashedPassword() {
        return $this->hashed_password;
    }
    
    /**
     * @return type
     */
    public function getDate(){
        return $this->creation_date;
    }

    public function saveToDB(mysqli $connection) {
        if ($this->user_id == -1) {
            //Saving new user to DB

            $sql = "INSERT INTO User(email, username, hashed_password, creation_date)
            VALUES ('$this->email', '$this->username', '$this->hashed_password', '$this->creation_date')";

            $result = $connection->query($sql);

            if ($result == true) {
                $this->user_id = $connection->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE User SET email='$this->email', username='$this->username', "
                 . "hashed_password='$this->hashed_password', creation_date='$this->creation_date' "
                 . "WHERE user_id='$this->user_id'";
            $result = $connection->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
       
    }
    
    
    public function delete(mysqli $connection){
        if($this->user_id != -1){
            $sql = "DELETE FROM User WHERE user_id=$this->user_id";
            $result = $connection->query($sql);
            if($result == true){
                $this->user_id = -1;
                return true;
            }
            return false;
        }
        return true;
    }
    
    public function showUserAsHTML(){
        
        // przypisuje dane do zmiennych
        $receiver_id = $this->getId();
        $username = $this->getUsername();
        $email = $this->getEmail();
        
        // wyświetlam dane user'a
        echo "<label>";
        echo "<input type=\"hidden\" name=\"receiver_id\" value=\"$receiver_id\">";
        echo "<input type=\"radio\" name=\"button\"><strong>Imie:&nbsp;</strong>".
             "$username&nbsp;<strong>Email:&nbsp;</strong>$email<br>";
        echo "</label>";
    }


    static public function loadUserByEmailAndPassword(mysqli $connection, $email, $pass){
        $sql = "SELECT * FROM User WHERE email='$email'";
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->user_id = $row['user_id'];
            $loadedUser->email = $row['email'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashed_password = $row['hashed_password'];
            $loadedUser->creation_date = $row['creation_date'];
            
            if(password_verify($pass, $loadedUser->getHashedPassword())){
                return $loadedUser;
            }else{
                return null;
            }
        }
        return null;
    }
    
    /**
     * @param mysqli $connection
     * @param type $id
     * @return \User
     */
    static public function loadUserById(mysqli $connection, $id){
        $sql = "SELECT * FROM User WHERE user_id='$id'";
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->user_id = $row['user_id'];
            $loadedUser->email = $row['email'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashed_password = $row['hashed_password'];
            $loadedUser->creation_date = $row['creation_date'];
            return $loadedUser;
        }
        return null;
    }
    
    /**
     * @param mysqli $connection
     * @return \User
     */
    static public function loadAllUsers(mysqli $connection){
        $sql = "SELECT * FROM User";
        $ret = [];

        $result = $connection->query($sql);
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedUser = new User();
                $loadedUser->user_id = $row['user_id'];
                $loadedUser->email = $row['email'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashed_password = $row['hashed_password'];
                $loadedUser->creation_date = $row['creation_date'];

                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }
}
 