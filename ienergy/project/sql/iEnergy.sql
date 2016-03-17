SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `iEnergyDatabase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `iEnergyDatabase`;

-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`user` (
  `iduser` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `login` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  PRIMARY KEY (`iduser`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`devices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`devices` (
  `iddevices` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `activePower` FLOAT NULL ,
  `apparentPower` FLOAT NULL ,
  `model` VARCHAR(45) NULL ,
  `manufacturer` VARCHAR(45) NULL ,
  `type` INT NULL ,
  `phasesNumber` INT NULL ,
  `description` VARCHAR(100) NULL ,
  `iduser` INT NULL ,
  PRIMARY KEY (`iddevices`) ,
  INDEX `fkiduserdevices` (`iduser` ASC) ,
  CONSTRAINT `fkiduserdevices`
    FOREIGN KEY (`iduser` )
    REFERENCES `iEnergyDatabase`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`consumption`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`consumption` (
  `idConsumption` INT NOT NULL AUTO_INCREMENT ,
  `dateTime` DATETIME NULL ,
  `type` INT NULL ,
  `value` FLOAT NULL ,
  `phaseId` INT NULL ,
  `iddevices` INT NULL ,
  PRIMARY KEY (`idConsumption`) ,
  INDEX `fkiddevicesconsumption` (`iddevices` ASC) ,
  CONSTRAINT `fkiddevicesconsumption`
    FOREIGN KEY (`iddevices` )
    REFERENCES `iEnergyDatabase`.`devices` (`iddevices` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`varData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`varData` (
  `idvarData` INT NOT NULL AUTO_INCREMENT ,
  `type` INT NULL ,
  `value` FLOAT NULL ,
  `phaseId` INT NULL ,
  `dateTime` DATETIME NULL ,
  `iddevices` INT NULL ,
  PRIMARY KEY (`idvarData`) ,
  INDEX `fkiddevicesvardata` (`iddevices` ASC) ,
  CONSTRAINT `fkiddevicesvardata`
    FOREIGN KEY (`iddevices` )
    REFERENCES `iEnergyDatabase`.`devices` (`iddevices` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`potential`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`potential` (
  `idpotential` INT NOT NULL AUTO_INCREMENT ,
  `type` INT NULL ,
  `value` FLOAT NULL ,
  `phaseId` INT NULL ,
  `dateTime` DATETIME NULL ,
  `iddevices` INT NULL ,
  PRIMARY KEY (`idpotential`) ,
  INDEX `fkiddevicespotential` (`iddevices` ASC) ,
  CONSTRAINT `fkiddevicespotential`
    FOREIGN KEY (`iddevices` )
    REFERENCES `iEnergyDatabase`.`devices` (`iddevices` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`current`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`current` (
  `idcurrent` INT NOT NULL AUTO_INCREMENT ,
  `type` INT NULL ,
  `value` FLOAT NULL ,
  `phaseId` INT NULL ,
  `dateTime` DATETIME NULL ,
  `iddevices` INT NULL ,
  PRIMARY KEY (`idcurrent`) ,
  INDEX `fkiddevicescurrent` (`iddevices` ASC) ,
  CONSTRAINT `fkiddevicescurrent`
    FOREIGN KEY (`iddevices` )
    REFERENCES `iEnergyDatabase`.`devices` (`iddevices` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`userData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`userData` (
  `iduserData` INT NOT NULL AUTO_INCREMENT ,
  `address` VARCHAR(45) NULL ,
  `zipcode` VARCHAR(45) NULL ,
  `state` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `country` VARCHAR(45) NULL ,
  `phone` VARCHAR(45) NULL ,
  `mobile` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `iduser` INT NULL ,
  PRIMARY KEY (`iduserData`) ,
  INDEX `fkiduseruserdata` (`iduser` ASC) ,
  CONSTRAINT `fkiduseruserdata`
    FOREIGN KEY (`iduser` )
    REFERENCES `iEnergyDatabase`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`logInfoMessages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`logInfoMessages` (
  `idlogInfoMessages` INT NOT NULL AUTO_INCREMENT ,
  `type` INT NULL ,
  `payload` VARCHAR(45) NULL ,
  `iddevices` INT NULL ,
  PRIMARY KEY (`idlogInfoMessages`) ,
  INDEX `fkiddevices` (`iddevices` ASC) ,
  CONSTRAINT `fkiddevices`
    FOREIGN KEY (`iddevices` )
    REFERENCES `iEnergyDatabase`.`devices` (`iddevices` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iEnergyDatabase`.`powerFactor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iEnergyDatabase`.`powerFactor` (
  `idpowerFactor` INT NOT NULL AUTO_INCREMENT ,
  `value` FLOAT NULL ,
  `phaseId` INT NULL ,
  `dateTime` DATETIME NULL ,
  `iddevices` INT NULL ,
  PRIMARY KEY (`idpowerFactor`) ,
  INDEX `fkiddevicespowerFactor` (`iddevices` ASC) ,
  CONSTRAINT `fkiddevicespowerFactor`
    FOREIGN KEY (`iddevices` )
    REFERENCES `iEnergyDatabase`.`devices` (`iddevices` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


;
CREATE USER ienergyuser;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
