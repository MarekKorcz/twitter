<?php

/* 
CREATE TABLE Message(
message_id INT PRIMARY KEY AUTO_INCREMENT,
message_text VARCHAR(140),
s_id INT NOT NULL,
r_id INT NOT NULL,
receiver_switch TINYINT ZEROFILL,
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
    
    public function __construct(User $senderUser, User $receiverUser, $text, $switch = 0){
        $this->message_id = -1;
        $this->message_text = $this->setMessageText($text);
        $this->s_id = $senderUser->getId();
        $this->r_id = $receiverUser->getId();
        $this->receiver_switch = $switch;
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
    
    public function saveMessageToDB(mysqli $conn){
        if($this->message_id == -1){
            $sql = "INSERT INTO Message (message_text, s_id, r_id, receiver_switch)"
                 . "VALUES ('$this->message_text', '$this->s_id', '$this->r_id', '$this->receiver_switch')";
        
            $result = $conn->query($sql);

            if($result == true){
                $this->message_id = $conn->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE Message SET message_text = '$this->message_text', "
                 . "s_id = '$this->s_id', r_id = '$this->r_id', "
                 . "receiver_switch = '$this->receiver_switch' WHERE message_id = '$this->message_id'";
            
            $result = $conn->query($sql);
            
            if($result == true){
                return true;
            }
        }
        return false;
    }
}