DROP DATABASE IF EXISTS readit;
CREATE DATABASE readit;

use readit;

CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    activation_code VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    active BOOLEAN DEFAULT false,
    location VARCHAR(50),
    bio TEXT,
    datejoined datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usersbooks (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(50) NOT NULL,
    rating INT(11) NOT NULL
);