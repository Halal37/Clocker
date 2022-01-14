CREATE TABLE User (
id INT NOT NULL AUTO_INCREMENT ,
username VARCHAR( 50 ) NOT NULL ,
lastname VARCHAR(50) NOT NULL,
email VARCHAR( 50 ) NOT NULL ,
password VARCHAR( 2048 ) NOT NULL ,
datatime datetime NOT NULL ,
PRIMARY KEY (id))
ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;

CREATE TABLE Client (
id INT NOT NULL AUTO_INCREMENT ,
userID INT NOT NULL ,
clientName VARCHAR( 50 ) NOT NULL,
description VARCHAR(50) NOT NULL,
photoClient VARCHAR(250) NOT NULL,
PRIMARY KEY ( id ),
INDEX ( userID ), 
FOREIGN KEY ( userID ) REFERENCES User (id) ON DELETE CASCADE
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;

CREATE TABLE Project (
id INT NOT NULL AUTO_INCREMENT ,
userID INT NOT NULL ,
clientID INT NOT NULL ,
groupID INT NOT NULL,
projectName VARCHAR( 50 ) NOT NULL,
PRIMARY KEY ( id ),
 INDEX(userID, clientID, groupID), 
 FOREIGN KEY ( clientID ) REFERENCES Client(id) ON DELETE CASCADE, 
 FOREIGN KEY ( userID ) REFERENCES User(id) ON DELETE CASCADE
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;

CREATE TABLE Groups (
id INT NOT NULL AUTO_INCREMENT ,
userID INT NOT NULL ,
projectID INT NOT NULL ,
groupID INT NOT NULL ,
groupName VARCHAR( 50 ) NOT NULL,
PRIMARY KEY ( id ), 
INDEX(userID, projectID), 
FOREIGN KEY ( projectID ) REFERENCES Project(id) ON DELETE CASCADE, 
FOREIGN KEY ( userID ) REFERENCES User(id) ON DELETE CASCADE
) ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;

ALTER TABLE Project ADD FOREIGN KEY ( groupID ) REFERENCES Groups(id) ON DELETE CASCADE;


CREATE TABLE Task (
id INT NOT NULL AUTO_INCREMENT ,
userID INT NOT NULL ,
projectID INT NOT NULL,
groupID INT NOT NULL,
nameTask VARCHAR( 200 ) NOT NULL ,
startTime DATETIME NULL ,
stopTime DATETIME NULL ,
status ENUM('active','inprogress','inactive'), 
PRIMARY KEY ( id ), 
INDEX(userID, projectID, groupID),
FOREIGN KEY ( userID ) REFERENCES User(id) ON DELETE CASCADE, 
FOREIGN KEY ( projectID ) REFERENCES Project(id) ON DELETE CASCADE,
FOREIGN KEY ( groupID ) REFERENCES Groups(id) ON DELETE CASCADE) 
ENGINE = INNODB CHARACTER SET utf32 COLLATE utf32_general_ci;

