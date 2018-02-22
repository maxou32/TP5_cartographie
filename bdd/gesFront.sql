-- MySQL Script generated by MySQL Workbench
-- Sun Feb  4 18:01:02 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `tp05_niveau`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tp05_points` ;
DROP TABLE IF EXISTS `tp05_contributeurFront` ;
DROP TABLE IF EXISTS `tp05_front` ;
DROP TABLE IF EXISTS `tp05_abonne` ;
DROP TABLE IF EXISTS `tp05_niveau` ;

CREATE TABLE IF NOT EXISTS `tp05_niveau` (
  `idniveau` INT(11) NOT NULL,
  `libelle` VARCHAR(45) NULL,
  PRIMARY KEY (`idniveau`))ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_niveau`
  MODIFY `idniveau` int(11) NOT NULL AUTO_INCREMENT;
-- -----------------------------------------------------
-- Table `tp05_avatar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tp05_avatar` ;

CREATE TABLE IF NOT EXISTS `tp05_avatar` (
  `idavatar` INT(11) NOT NULL, 
  `nom` VARCHAR(40) NOT NULL,
  `urlimage` VARCHAR(255) NULL,
  `typemarque` ENUM('avatar', 'marqueur') NULL,
  PRIMARY KEY (`idavatar`))ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_avatar`
  MODIFY `idavatar` int(11) NOT NULL AUTO_INCREMENT;
-- -----------------------------------------------------
-- Table `tp05_abonne`
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS `tp05_abonne` (
  `idabonne` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NOT NULL,
  `prénom` VARCHAR(45) NOT NULL,
  `email` TEXT(250) NOT NULL,
  `idavatar` INT(11) NULL,
  `status` ENUM('valide', 'à valider', 'invalide', 'suspendu') NULL,
  `datecreation` TIMESTAMP NULL,
  `idniveau` INT(11) NULL,
  PRIMARY KEY (`idabonne`),
  INDEX `idniveau_idx` (`idniveau` ASC),
  INDEX `idavatar_idx` (`idavatar` ASC),
  CONSTRAINT `idniveau`
    FOREIGN KEY (`idniveau`)
    REFERENCES `tp05_niveau` (`idniveau`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idavatar`
    FOREIGN KEY (`idavatar`)
    REFERENCES `tp05_avatar` (`idavatar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_abonne`
  MODIFY `idabonne` int(11) NOT NULL AUTO_INCREMENT;
  
-- -----------------------------------------------------
-- Table `tp05_front`
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS `tp05_front` (
  `idfront` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  `datedebut` DATETIME NULL,
  `datefin` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `valide` BOOLEAN NOT NULL,
  `idauteur` INT(11) NULL,
  `frontcol1` VARCHAR(45) NULL,	
  PRIMARY KEY (`idfront`),
  INDEX `idauteur_idx` (`idauteur` ASC),
  CONSTRAINT `idauteur`
    FOREIGN KEY (`idauteur`)
    REFERENCES `tp05_abonne` (`idabonne`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_front`
  MODIFY `idfront` int(11) NOT NULL AUTO_INCREMENT;


-- -----------------------------------------------------
-- Table `tp05_contributeurFront`
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS `tp05_contributeurFront` (
  `idcontributeurfront` INT(11) NOT NULL,
  `idfront` INT(11) NOT NULL,
  `idabonne` INT(11) NOT NULL,
  PRIMARY KEY (`idcontributeurfront`),
  INDEX `idfront_idx` (`idfront` ASC),
  INDEX `idabonne_idx` (`idabonne` ASC),
  CONSTRAINT `idfront`
    FOREIGN KEY (`idfront`)
    REFERENCES `tp05_front` (`idfront`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idabonne`
    FOREIGN KEY (`idabonne`)
    REFERENCES `tp05_abonne` (`idabonne`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_contributeurFront`
  MODIFY `idcontributeurfront` int(11) NOT NULL AUTO_INCREMENT;

-- -----------------------------------------------------
-- Table `tp05_lignefront`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tp05_lignefront` ;

CREATE TABLE IF NOT EXISTS `tp05_lignefront` (
  `idlignefront` INT(11) NOT NULL AUTO_INCREMENT,
  `datedeut` TIMESTAMP NULL,
  `datefin` TIMESTAMP NULL,
  `couleur` VARCHAR(45) NULL,
  `valide` BOOLEAN NULL,
  `idfront` INT(11) NOT NULL,
  `idcontributeurfront` INT(11) NOT NULL,
  PRIMARY KEY (`idlignefront`))ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_lignefront`
  MODIFY `idlignefront` int(11) NOT NULL AUTO_INCREMENT;
-- -----------------------------------------------------
-- Table `tp05_carte`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tp05_carte` ;

CREATE TABLE IF NOT EXISTS `tp05_carte` (
  `idcarte` INT(11) NOT NULL AUTO_INCREMENT,
  `zoom` INT(11) NULL,
  `lat` DECIMAL NULL,
  `long` DECIMAL NULL,
  `projection` VARCHAR(45) NULL,
  `layerOption` VARCHAR(200) NULL,
  `nom` VARCHAR(250) NULL,
  `idfront` INT(11) NOT NULL,
  PRIMARY KEY (`idcarte`),
  INDEX `idfront_idx` (`idfront` ASC))
  ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tp05_carte`
  MODIFY `idcarte` int(11) NOT NULL AUTO_INCREMENT;
-- -----------------------------------------------------
-- Table `tp05_points`
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS `tp05_points` (
  `idpoints` INT(11) NOT NULL AUTO_INCREMENT,
  `lat` DECIMAL NULL,
  `long` DECIMAL NULL,
  `idmarqueur` INT(11) NULL,
  `idligne` INT(11) NULL,
  PRIMARY KEY (`idpoints`),
  INDEX `idligne_idx` (`idligne` ASC),
  INDEX `idmarqueur_idx` (`idmarqueur` ASC),
  CONSTRAINT `idligne`
    FOREIGN KEY (`idligne`)
    REFERENCES `tp05_lignefront` (`idlignefront`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idmarqueur`
    FOREIGN KEY (`idmarqueur`)
    REFERENCES `tp05_avatar` (`idavatar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE=InnoDB DEFAULT CHARSET=utf8;

	
ALTER TABLE `tp05_points`
  MODIFY `idpoints` int(11) NOT NULL AUTO_INCREMENT;

-- -----------------------------------------------------
-- Table `tp05_media`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tp05_media` ;

CREATE TABLE IF NOT EXISTS `tp05_media` (
  `idmedia` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NOT NULL,
  `adresse` VARCHAR(250) NULL,
  `valide` BOOLEAN NULL,
  `idcontributeur` INT(11) NULL,
  `idligne` INT(11) NULL,
  PRIMARY KEY (`idmedia`),
  INDEX `idcontributeur_idx` (`idcontributeur` ASC),
  INDEX `idlignefront_idx` (`idligne` ASC),
  CONSTRAINT `idcontributeur`
    FOREIGN KEY (`idcontributeur`)
    REFERENCES `tp05_contributeurFront` (`idcontributeurfront`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `tp05_media`
  MODIFY `idmedia` int(11) NOT NULL AUTO_INCREMENT;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
