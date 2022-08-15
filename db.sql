SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema users
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `users` ;
USE `users` ;
-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users`.`assignments` (
    `AssignmentID` int(11) NOT NULL AUTO_INCREMENT,
    `Description` varchar(250) NOT NULL,
    `DueDate` datetime NOT NULL,
    PRIMARY KEY (`AssignmentID`)
    ) 
    ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4
-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users`.`assistants` (
    `AssistantID` int(11) NOT NULL AUTO_INCREMENT,
    `AssistantUsername` varchar(250) NOT NULL,
    `AssistantPassword` varchar(250) NOT NULL,
    PRIMARY KEY (`AssistantID`)
    ) 
    ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4
-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users`.`posts` (
    `PostID` int(11) NOT NULL AUTO_INCREMENT,
    `Header` varchar(40) NOT NULL,
    `Description` varchar(255) NOT NULL,
    `attachments` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`PostID`)
    ) 
    ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4
-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users`.`questions` (
    `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
    `Question` varchar(250) NOT NULL,
    `User` varchar(250) NOT NULL,
    `Answer` varchar(250) NOT NULL DEFAULT 'Not Answered yet',
    `Assistant` varchar(250) NOT NULL DEFAULT 'NA',
    `Answered` bit(1) NOT NULL DEFAULT b'0',
    `TeacherAnswer` varchar(255) NOT NULL DEFAULT 'Not Answered yet',
    `TeacherAnswered` bit(1) NOT NULL DEFAULT b'0',
    PRIMARY KEY (`QuestionID`)
    ) 
    ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4
-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users`.`users` (
    `Username` varchar(40) NOT NULL,
    `Password` varchar(250) NOT NULL,
    PRIMARY KEY (`Username`)
    ) 
    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users`.`work` (
    `WorkID` int(11) NOT NULL AUTO_INCREMENT,
    `UserID` varchar(250) NOT NULL,
    `AssignmentID` int(11) NOT NULL,
    `WorkFile` varchar(250) NOT NULL,
    `Late` int(1) NOT NULL DEFAULT 0,
    `Grade` int(11) NOT NULL,
    `Comments` varchar(255) NOT NULL DEFAULT 'No comments',
    `AssistantID` varchar(40) NOT NULL DEFAULT 'NA',
    `Corrected` bit(1) NOT NULL DEFAULT b'0',
    PRIMARY KEY (`WorkID`)
    ) 
    ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4