CREATE DATABASE IF NOT EXISTS grades;
USE grades;

DROP TABLE IF EXISTS Students;
DROP TABLE IF EXISTS Scores;

CREATE TABLE Students (
    studentID varchar(8) UNIQUE NOT NULL,
    firstName varchar(30) NOT NULL,
    lastName varchar(30) NOT NULL,
    PRIMARY KEY (studentID)
);

CREATE TABLE Scores (
    studentID varchar(8),
    hw1 tinyint UNSIGNED,
    hw2 tinyint UNSIGNED,
    hw3 tinyint UNSIGNED,
    hw4 tinyint UNSIGNED,
    hw5 tinyint UNSIGNED,
    quiz1 tinyint UNSIGNED,
    quiz2 tinyint UNSIGNED,
    quiz3 tinyint UNSIGNED,
    quiz4 tinyint UNSIGNED,
    quiz5 tinyint UNSIGNED,
    midterm tinyint UNSIGNED,
    finalProject tinyint UNSIGNED,
    FOREIGN KEY (studentID) REFERENCES Students (studentID)
);

INSERT INTO Students (studentID, firstName, lastName) VALUES 
    ('24386365', 'Rae', 'Gainer'),
    ('83275038', 'Kip', 'Russell'),
    ('38502758', 'Lindsay', 'Weir'),
    ('11111111', 'Leenik', 'Geelo');