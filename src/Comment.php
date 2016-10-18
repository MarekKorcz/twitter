<?php

/*
 CREATE TABLE Comment(
 comment_id INT PRIMARY KEY AUTO_INCREMENT,
 p_id INT NOT NULL,
 comment_text VARCHAR(300),
 comment_owner VARCHAR(20),
 comment_date DATETIME,
 FOREIGN KEY(p_id) REFERENCES Post(post_id)
 ON DELETE CASCADE 
 )
 */ 