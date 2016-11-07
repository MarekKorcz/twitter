<?php

/* 
CREATE TABLE Message(
message_id INT PRIMARY KEY AUTO_INCREMENT,
message_text VARCHAR(500),
sender_name VARCHAR(20),
receiver_name VARCHAR(20),
s_id INT NOT NULL,
r_id INT NOT NULL,
receiver_switch TINYINT ZEROFILL,
message_date DATETIME,
FOREIGN KEY(s_id) REFERENCES User(user_id)
ON DELETE CASCADE,
FOREIGN KEY(r_id) REFERENCES User(user_id)
ON DELETE CASCADE
)
 */ 

class Message{
    private $message_id;
    private $message_text;
    private $sender_name;
    private $receiver_name;
    private $s_id;
    private $r_id;
    private $receiver_switch;
    private $message_date;
    
    public function __construct(User $senderUser, User $receiverUser, $text, $switch = 1){
        $this->message_id = -1;
        $this->message_text = $this->setMessageText($text);
        $this->sender_name = $senderUser->getUsername();
        $this->receiver_name = $receiverUser->getUsername();
        $this->s_id = $senderUser->getId();
        $this->r_id = $receiverUser->getId();
        $this->receiver_switch = $switch;
        $this->message_date = date("Y-m-d h:i:s");
    }
    
    public function setMessageText($text){
        if(is_string($text) && strlen($text) > 0 && strlen($text) <= 140){
            $this->message_text = $text;
        }
    }
    
    public function setSwitchOff(){
        $this->receiver_switch = 0;
    }
    
    public function getMessageId(){
        return $this->message_id;
    }
    
    public function getMessageText() {
        return $this->message_text;
    }
    
    public function getSenderName(){
        return $this->sender_name;
    }
    
    public function getReveiverName(){
        return $this->receiver_name;
    }

    public function getSenderId() {
        return $this->s_id;
    }
    
    public function getReceiverId() {
        return $this->r_id;
    }
    
    public function getReceiverSwitch(){
        return $this->receiver_switch;
    }
    
    public function getMessageDate() {
        return $this->message_date;
    }
    
    public function saveMessageToDB(mysqli $conn){
        if($this->message_id == -1){
            $sql = "INSERT INTO Message (message_text, sender_name, receiver_name, "
          . "s_id, r_id, receiver_switch, message_date) VALUES ('$this->message_text', "
          . "'$this->sender_name', '$this->receiver_name', '$this->s_id', '$this->r_id', "
          . "'$this->receiver_switch', '$this->message_date')";
        
            $result = $conn->query($sql);
            if($result == true){
                $this->message_id = $conn->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE Message SET message_text='$this->message_text', "
          . "sender_name='$this->sender_name', receiver_name='$this->receiver_name', "
          . "s_id='$this->s_id', r_id='$this->r_id', receiver_switch='$this->receiver_switch', "
          . "message_date='$this->message_date' WHERE message_id='$this->message_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }return false;
    }
    
    public function showReceivedMessageAsHTMLLink(){
        
        // przypisuje dane do zmiennych
        $message_id = $this->getMessageId();
        $sender_name = $this->getSenderName();   
        $short_message_text = substr($this->getMessageText(), 0, 30);
        $message_date = $this->getMessageDate();
        $switch = $this->getReceiverSwitch();
        
        // wyświetlam dane user'a
        echo "<label>";
        if($switch) {echo "<strong>";}
        echo "<a href=\"current_message.php\">";
        echo "<input type=\"hidden\" name=\"message_id\" value=\"$message_id\">";
        echo "<strong>Data:&nbsp;</strong>$message_date&nbsp;".
             "<strong>Wiadomosc od:&nbsp;</strong>$sender_name&nbsp;".
             "<strong>Tresc:&nbsp;</strong>$short_message_text&nbsp;<br><br>";
        echo "</a>";
        if($switch) {echo "</strong>";}
        echo "</label>";
    }
    
    public function showReceivedMessageAsHTML($conn){
        
        // przelaczam na wiadomosc odczytana
        $this->setSwitchOff();
        // zapisuje w bazie danych
        $this->saveMessageToDB($conn);
        
        
        $sender_name = $this->getSenderName();   
        $message_text = $this->getMessageText();
        $message_date = $this->getMessageDate();
        
        // kod wyswietlajacy wiadomosc
        
    }
    
    static public function loadMessageById(mysqli $connection, $message_id){
        $sql = "SELECT * FROM Message WHERE message_id='$message_id'";
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedMessage = new Message();
            $loadedMessage->message_id = $row['message_id'];
            $loadedMessage->message_text = $row['message_text'];
            $loadedMessage->sender_name = $row['senders_name'];
            $loadedMessage->receiver_name = $row['receiver_name'];
            $loadedMessage->s_id = $row['s_id'];
            $loadedMessage->r_id = $row['r_id'];
            $loadedMessage->receiver_switch = $row['receiver_switch'];
            $loadedMessage->message_date = $row['message_date'];
            
            return $loadedMessage;
        }else{
            echo "Nie istnieje wiadomosc o takim id w bazie danych! ";
        }
        return null;
    }

    static public function loadAllMessagesByUserId(mysqli $connection, $id){
        $sql = "SELECT * FROM Message WHERE r_id = '$id'";
        
        $arr =[];
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedMessage = new Message();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->message_text = $row['message_text'];
                $loadedMessage->sender_name = $row['senders_name'];
                $loadedMessage->receiver_name = $row['receiver_name'];
                $loadedMessage->s_id = $row['s_id'];
                $loadedMessage->r_id = $row['r_id'];
                $loadedMessage->receiver_switch = $row['receiver_switch'];
                $loadedMessage->message_date = $row['message_date'];
                
                $arr[] = $loadedMessage;
            }
        }else{
                echo "Nie masz żadnych wiadomosci w bazie danych! ";
        }
        
        return $arr;
    } 
}