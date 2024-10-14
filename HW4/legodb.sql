CREATE DATABASE  IF NOT EXISTS legoOrganizer;
USE legoOrganizer;

DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Collections;
DROP TABLE IF EXISTS Sets;
DROP TABLE IF EXISTS CollectedSets;

CREATE TABLE Users (
  username varchar(20),
  password varchar(20) NOT NULL,
  email varchar(50),
  phone int,
  PRIMARY KEY (username)
);

CREATE TABLE Sets (
  setID int,
  description mediumtext,
  price decimal(6,2),
  link text,
  category varchar(50),
  numPieces smallint,
  PRIMARY KEY (setID)
);

CREATE TABLE CollectedSets (
  itemID int,
  setID int NOT NULL,
  collectorID varchar(20) NOT NULL,
  dateAdded date,
  image mediumblob,
  PRIMARY KEY (itemID),
  FOREIGN KEY (setID) REFERENCES Sets (setID),
  FOREIGN KEY (collectorID) REFERENCES Users (username)
);