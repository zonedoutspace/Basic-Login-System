CREATE TABLE users
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(64) NOT NULL,
    reg_ip VARCHAR(255) NOT NULL,
    ip VARCHAR(255) NOT NULL
);
CREATE UNIQUE INDEX unique_email ON users (email);
CREATE UNIQUE INDEX unique_username ON users (username);