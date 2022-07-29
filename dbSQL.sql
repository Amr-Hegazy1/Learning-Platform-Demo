-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema swd
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema swd
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `swd` ;
USE `swd` ;

-- -----------------------------------------------------
-- Table `swd`.`Assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swd`.`Assignments` (
  `idAssignments` INT NOT NULL AUTO_INCREMENT,
  `assignment_name` MEDIUMTEXT NULL,
  `due_date` DATE NULL,
  PRIMARY KEY (`idAssignments`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swd`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swd`.`Users` (
  `idUsers` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `gender` ENUM('M', 'F') NULL,
  `school` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `telephone_no` VARCHAR(45) NULL,
  `paid` TINYINT NULL DEFAULT 0,
  `passwords` LONGTEXT NULL,
  `role` VARCHAR(45) NULL,
  PRIMARY KEY (`idUsers`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swd`.`Submissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swd`.`Submissions` (
  `idSubmissions` INT NOT NULL AUTO_INCREMENT,
  `graded` TINYINT NULL,
  `pdf_name` LONGBLOB NULL,
  `grade` INT NULL,
  `assignment_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`idSubmissions`),
  INDEX `fk_Submissions_Assignments_idx` (`assignment_id` ASC) VISIBLE,
  INDEX `fk_Submissions_Users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_Submissions_Assignments`
    FOREIGN KEY (`assignment_id`)
    REFERENCES `swd`.`Assignments` (`idAssignments`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Submissions_Users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `swd`.`Users` (`idUsers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `swd` ;

-- -----------------------------------------------------
-- Placeholder table for view `swd`.`AssignmentView`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swd`.`AssignmentView` (`idAssignments` INT, `assignment_name` INT, `due_date` INT);

-- -----------------------------------------------------
-- Placeholder table for view `swd`.`SubmissionsView`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swd`.`SubmissionsView` (`idSubmissions` INT, `graded` INT, `pdf_name` INT, `grade` INT, `assignment_id` INT, `user_id` INT);

-- -----------------------------------------------------
-- Placeholder table for view `swd`.`UsersView`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swd`.`UsersView` (`idUsers` INT, `first_name` INT, `last_name` INT, `gender` INT, `school` INT, `email` INT, `telephone_no` INT, `paid` INT, `passwords` INT, `role` INT);

-- -----------------------------------------------------
-- View `swd`.`AssignmentView`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `swd`.`AssignmentView`;
USE `swd`;
CREATE  OR REPLACE VIEW `AssignmentView` AS
SELECT * FROM Assignments;

-- -----------------------------------------------------
-- View `swd`.`SubmissionsView`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `swd`.`SubmissionsView`;
USE `swd`;
CREATE  OR REPLACE VIEW `SubmissionsView` AS
SELECT * FROM Submissions;

-- -----------------------------------------------------
-- View `swd`.`UsersView`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `swd`.`UsersView`;
USE `swd`;
CREATE  OR REPLACE VIEW `UsersView` AS
SELECT * FROM Users;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
