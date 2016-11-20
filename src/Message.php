<?php

/* 
CREATE TABLE Message(
message_id INT PRIMARY KEY AUTO_INCREMENT,
message_text VARCHAR(500),
sender_name VARCHAR(20),
receiver_name VARCHAR(20),
sender_id INT NOT NULL,
receiver_id INT NOT NULL,
receiver_switch VARCHAR (1),
message_date DATETIME,
FOREIGN KEY(sender_id) REFERENCES User(user_id)
ON DELETE CASCADE,
FOREIGN KEY(receiver_id) REFERENCES User(user_id)
ON DELETE CASCADE
)
 */ 

class Message{
    private $message_id;
    private $message_text;
    private $sender_name;
    private $receiver_name;
    private $sender_id;
    private $receiver_id;
    private $receiver_switch;
    private $message_date;
    
    public function __construct($text = "", User $senderUser = NULL, User $receiverUser = NULL, $switch = 0){
        $this->message_id = -1;
        $this->message_text = $text;
        $senderUser != NULL ? $this->sender_name = $senderUser->getUsername() : $this->sender_name = "";
        $receiverUser != NULL ? $this->receiver_name = $receiverUser->getUsername() : $this->receiver_id = "";
        $senderUser != NULL ? $this->sender_id = $senderUser->getId() : $this->sender_id = -1;
        $receiverUser != NULL ? $this->receiver_id = $receiverUser->getId() : $this->receiver_id = -1;
        $this->receiver_switch = $switch;
        $this->message_date = date("Y-m-d h:i:s");
    }
    
    public function setSwitchOff(){
        $this->receiver_switch = 1;
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
    
    public function getReceiverName(){
        return $this->receiver_name;
    }

    public function getSenderId() {
        return $this->sender_id;
    }
    
    public function getReceiverId() {
        return $this->receiver_id;
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
          . "sender_id, receiver_id, receiver_switch, message_date) VALUES ('$this->message_text', "
          . "'$this->sender_name', '$this->receiver_name', '$this->sender_id', '$this->receiver_id', "
          . "'$this->receiver_switch', '$this->message_date')";
        
            $result = $conn->query($sql);
            if($result == true){
                $this->message_id = $conn->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE Message SET message_text='$this->message_text', "
          . "sender_name='$this->sender_name', receiver_name='$this->receiver_name', "
          . "sender_id='$this->sender_id', receiver_id='$this->receiver_id', "
          . "receiver_switch='$this->receiver_switch', message_date='$this->message_date' "
          . "WHERE message_id='$this->message_id'";
            
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
        
        // wyświetlam wiadomosc
        echo "<label>";
        if($switch == 0) {echo "<strong>";}
        echo "<a href=\"received_message.php?id=$message_id\">";
        //echo "<input type=\"hidden\" name=\"message_id\" value=\"$message_id\">";
        echo "<i>Data:&nbsp;</i>$message_date, ".
             "<i>Wiadomosc od:&nbsp;</i>$sender_name, ".
             "<i>Tresc:&nbsp;</i>$short_message_text.<br>";
        echo "</a>";
        if($switch == 0) {echo "</strong>";}
        echo "</label>";
    }
    
    public function showReceivedMessageAsHTML($conn){
        
        // przelaczam na wiadomosc odczytana
        $this->setSwitchOff();
        // zapisuje w bazie danych
        $this->saveMessageToDB($conn);
        
        $sender_id = $this->getSenderId();
        $sender_name = "<a href=\"user.php?id=$sender_id\">".$this->getSenderName()."</a>";   
        $message_text = $this->getMessageText();
        $message_date = $this->getMessageDate();
        
        // kod wyswietlajacy wiadomosc
echo<<<EOT
        <div name="message" style="width: 900px; height: 80px; background-color: #42f4b9; border: 5px solid black;">
        <strong>Wiadomosc od uzytkownika: </strong>$sender_name<br>
        <strong>Tresc wiadomosci: </strong>$message_text<br>
        <strong>Data wyslania wiadomosci: </strong>$message_date
        </div><br>
EOT;
    }
    
    public function showSendedMessageAsHTMLLink(){
        
        // przypisuje dane do zmiennych
        $message_id = $this->getMessageId();
        $receiver_name = $this->getReceiverName();   
        $short_message_text = substr($this->getMessageText(), 0, 30);
        $message_date = $this->getMessageDate();
        
        // wyświetlam wiadomosc
echo<<<EOT
        <label>
        <a href="sended_message.php?id=$message_id">
        <i>Data: </i>$message_date, 
        <i>Wiadomosc wyslana do: </i>$receiver_name, 
        <i>Tresc: </i>$short_message_text.<br>
        </a></label>
EOT;
    }
    
    public function showSendedMessageAsHTML(){
        
        $receiver_id = $this->getReceiverId();
        $receiver_name = "<a href=\"user.php?id=$receiver_id\">".$this->getReceiverName()."</a>";   
        $message_text = $this->getMessageText();
        $message_date = $this->getMessageDate();
        
        // kod wyswietlajacy wiadomosc
echo<<<EOT
        <div name="message" style="width: 900px; height: 80px; background-color: #42f4b9; border: 5px solid black;">
        <strong>Wiadomosc do uzytkownika: </strong>$receiver_name<br>
        <strong>Tresc wiadomosci: </strong>$message_text<br>
        <strong>Data wyslania wiadomosci: </strong>$message_date
        </div><br>
EOT;

    }
    
    static public function loadMessageById(mysqli $connection, $message_id){
        $sql = "SELECT * FROM Message WHERE message_id='$message_id'";
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedMessage = new Message();
            $loadedMessage->message_id = $row['message_id'];
            $loadedMessage->message_text = $row['message_text'];
            $loadedMessage->sender_name = $row['sender_name'];
            $loadedMessage->receiver_name = $row['receiver_name'];
            $loadedMessage->sender_id = $row['sender_id'];
            $loadedMessage->receiver_id = $row['receiver_id'];
            $loadedMessage->receiver_switch = $row['receiver_switch'];
            $loadedMessage->message_date = $row['message_date'];
            
            return $loadedMessage;
        }else{
            echo "Nie istnieje wiadomosc o takim id w bazie danych! ";
        }
        return null;
    }

    static public function loadAllReceivedMessagesByUserId(mysqli $connection, $id){
        $sql = "SELECT * FROM Message WHERE receiver_id = '$id'";
        
        $arr =[];
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedMessage = new Message();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->message_text = $row['message_text'];
                $loadedMessage->sender_name = $row['sender_name'];
                $loadedMessage->receiver_name = $row['receiver_name'];
                $loadedMessage->sender_id = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->receiver_switch = $row['receiver_switch'];
                $loadedMessage->message_date = $row['message_date'];
                
                $arr[] = $loadedMessage;
            }
        }else{
                echo "Baza danych pusta! ";
        }
        
        return $arr;
    } 
    
    static public function loadAllSendedMessagesByUserId(mysqli $connection, $id){
        $sql = "SELECT * FROM Message WHERE sender_id = '$id'";
        
        $arr =[];
        
        $result = $connection->query($sql);
        
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
                $loadedMessage = new Message();
                $loadedMessage->message_id = $row['message_id'];
                $loadedMessage->message_text = $row['message_text'];
                $loadedMessage->sender_name = $row['sender_name'];
                $loadedMessage->receiver_name = $row['receiver_name'];
                $loadedMessage->sender_id = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->receiver_switch = $row['receiver_switch'];
                $loadedMessage->message_date = $row['message_date'];
                
                $arr[] = $loadedMessage;
   
            }
        }else{
                echo "Baza danych pusta! ";
        }
        
        return $arr;
    } 
}