CREATE DATABASE IF NOT EXISTS grades;
USE grades;

DROP TABLE IF EXISTS Students;
DROP TABLE IF EXISTS Scores;

CREATE TABLE Students (
    studentID varchar(8) PRIMARY KEY,
    firstName varchar(100) NOT NULL,
    lastName varchar(100) NOT NULL
);

CREATE TABLE Assignments (
    assignmentID int PRIMARY KEY AUTO_INCREMENT,
    assignmentName varchar(15) NOT NULL,
    weight decimal(2,2) NOT NULL
);

CREATE TABLE Scores (
    scoreID int PRIMARY KEY AUTO_INCREMENT,
    studentID varchar(8),
    assignmentID int,
    grade decimal(5,2),
    FOREIGN KEY (studentID) REFERENCES Students (studentID),
    FOREIGN KEY (assignmentID) REFERENCES Assignments (assignmentID)
);

INSERT INTO Students (studentID, firstName, lastName) VALUES 
    ('24386365', 'Rae', 'Gainer'),
    ('83275038', 'Kip', 'Russell'),
    ('38502758', 'Lindsay', 'Weir'),
    ('91111111', 'Leenik', 'Geelo');

INSERT INTO Assignments (assignmentName, weight) VALUES
    ('Homework 1', 0.20),
    ('Homework 2', 0.20),
    ('Homework 3', 0.20),
    ('Homework 4', 0.20),
    ('Homework 5', 0.20),
    ('Quiz 1', 0.10),
    ('Quiz 2', 0.10),
    ('Quiz 3', 0.10),
    ('Quiz 4', 0.10),
    ('Quiz 5', 0.10),
    ('Midterm', 0.30),
    ('Final Project', 0.40);