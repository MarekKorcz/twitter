<?php

/* 
CREATE TABLE Message(
message_id INT PRIMARY KEY AUTO_INCREMENT,
message_text VARCHAR(140),
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
    private $s_id;
    private $r_id;
    private $receiver_switch;
    private $message_date;
    
    public function __construct(User $senderUser, User $receiverUser, $text, $switch = 0){
        $this->message_id = -1;
        $this->message_text = $this->setMessageText($text);
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

    public function setSenderId(User $senderUser){
        $this->s_id = $senderUser->getId();
    }
    
    public function setReceiverId(User $receiverUser){
        $this->r_id = $receiverUser->getId();
    }
    
    public function setSwitchOn(){
        $this->receiver_switch = 1;
    }
    
    public function setSwitchOff() {
        $this->receiver_switch = 0;
    }
    
    public function getMessageText() {
        return $this->message_text;
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
            $sql = "INSERT INTO Message (message_text, s_id, r_id, receiver_switch, message_date)"
                 . "VALUES ('$this->message_text', '$this->s_id', '$this->r_id', "
                 . "'$this->receiver_switch', '$this->message_date')";
        
            $result = $conn->query($sql);

            if($result == true){
                $this->message_id = $conn->insert_id;
                return true;
            }
        }
        return false;
    }
}