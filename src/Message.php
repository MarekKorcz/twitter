<?php

/* 
CREATE TABLE Message(
message_id INT PRIMARY KEY AUTO_INCREMENT,
sender_id INT NOT NULL,
recipient_id INT NOT NULL,
FOREIGN KEY(sender_id) REFERENCES User(user_id)
ON DELETE CASCADE
FOREIGN KEY(recipient_id) REFERENCES User(user_id)
ON DELETE CASCADE
)
 */ 