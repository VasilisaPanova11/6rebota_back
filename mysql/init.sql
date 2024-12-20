CREATE DATABASE IF NOT EXISTS appDb;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON appDb.* TO 'user'@'%';
FLUSH PRIVILEGES;
USE appDb;

CREATE TABLE IF NOT EXISTS users (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) CHARACTER SET ascii NOT NULL,
    password VARCHAR(50) CHARACTER SET ascii NOT NULL,
    PRIMARY KEY (ID)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS material (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    discription VARCHAR(255) NOT NULL,
    cost INT(10) NOT NULL,
    PRIMARY KEY (ID)
    ) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS purchasing (
    matID INT(10) NOT NULL,
    count INT(10) NOT NULL,
    city VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    FOREIGN KEY (matID) REFERENCES material (ID)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS charts (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    path VARCHAR(255) NOT NULL,
    PRIMARY KEY (ID)
)  DEFAULT CHARSET=utf8;

-- htpasswd -bns admin admin
INSERT INTO users (name, password)
SELECT * FROM (SELECT 'admin', '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc=') AS temp
WHERE NOT EXISTS (
        SELECT name FROM users WHERE name = 'admin' AND password = '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc='
    ) LIMIT 1;

-- htpasswd -bns user 1234
INSERT INTO users (name, password)
SELECT * FROM (SELECT 'user', '{SHA}cRDtpNCeBiql5KOQsKVyrA0sAiA=') AS temp
WHERE NOT EXISTS (
        SELECT name FROM users WHERE name = 'user' AND password = '{SHA}cRDtpNCeBiql5KOQsKVyrA0sAiA='
    ) LIMIT 1;

INSERT INTO material (title, discription, cost)
VALUES ('Bricks', 'The price for the material with a volume of one cubic meter is indicated', 7000),
    ('Stameska', 'The price for one piece is indicated', 1000),
    ('Cement', 'The price for the material with a volume of one cubic meter is indicated', 3500);


