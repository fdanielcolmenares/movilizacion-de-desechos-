SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `caimta_sys` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `caimta_sys` ;

-- -----------------------------------------------------
-- Table `caimta_sys`.`Usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Usuario` (
  `idUsuario` INT(5) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(25) NOT NULL ,
  `apellido` VARCHAR(25) NOT NULL ,
  `correo` VARCHAR(90) NULL ,
  `estado` VARCHAR(1) NOT NULL COMMENT 'estado a->activo i->inactivo' ,
  PRIMARY KEY (`idUsuario`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Historico_conexion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Historico_conexion` (
  `idHistorico_conexion` INT(5) NOT NULL AUTO_INCREMENT ,
  `tipo` VARCHAR(1) NOT NULL COMMENT 'c->sesion iniciada\nd->sesion finalizada' ,
  `fecha` DATE NOT NULL ,
  `hora` VARCHAR(8) NOT NULL ,
  `idUsuario` INT(5) NOT NULL ,
  PRIMARY KEY (`idHistorico_conexion`) ,
  INDEX `fk_historico_conexion_Usuario_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_historico_conexion_Usuario`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `caimta_sys`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Empresa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Empresa` (
  `idEmpresa` INT(5) NOT NULL AUTO_INCREMENT ,
  `razon` VARCHAR(100) NOT NULL ,
  `rif` VARCHAR(20) NOT NULL ,
  `telefono` VARCHAR(15) NOT NULL ,
  `correo` VARCHAR(60) NOT NULL ,
  `direccion` VARCHAR(300) NOT NULL ,
  `tipo` VARCHAR(1) NOT NULL COMMENT '\n' ,
  `idUsuario` INT(5) NOT NULL ,
  PRIMARY KEY (`idEmpresa`) ,
  INDEX `fk_Empresa_Usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_Empresa_Usuario1`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `caimta_sys`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Solicitud`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Solicitud` (
  `idSolicitud` INT(5) NOT NULL AUTO_INCREMENT ,
  `fecha` DATE NOT NULL ,
  `hora` VARCHAR(8) NOT NULL ,
  `nGuia` VARCHAR(15) NULL ,
  `codigo` VARCHAR(10) NOT NULL ,
  `estado` VARCHAR(1) NOT NULL COMMENT '1 nueva\n2 procesado' ,
  `idEmpresa` INT(5) NOT NULL ,
  PRIMARY KEY (`idSolicitud`) ,
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) ,
  INDEX `fk_Solicitud_Empresa1_idx` (`idEmpresa` ASC) ,
  CONSTRAINT `fk_Solicitud_Empresa1`
    FOREIGN KEY (`idEmpresa` )
    REFERENCES `caimta_sys`.`Empresa` (`idEmpresa` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Estado_solicitud`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Estado_solicitud` (
  `idEstado_solicitud` INT(5) NOT NULL AUTO_INCREMENT ,
  `nota` VARCHAR(100) NULL ,
  `fecha` DATE NOT NULL ,
  `estado` VARCHAR(10) NOT NULL COMMENT 'APROVADO\nRECHAZADO\nPROCESADA' ,
  `idUsuario` INT(5) NOT NULL ,
  `idSolicitud` INT(5) NOT NULL ,
  PRIMARY KEY (`idEstado_solicitud`) ,
  INDEX `fk_Estado_solicitud_Solicitud1_idx` (`idSolicitud` ASC) ,
  INDEX `fk_Estado_solicitud_Usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_Estado_solicitud_Solicitud1`
    FOREIGN KEY (`idSolicitud` )
    REFERENCES `caimta_sys`.`Solicitud` (`idSolicitud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estado_solicitud_Usuario1`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `caimta_sys`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Deposito`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Deposito` (
  `idDeposito` INT(5) NOT NULL AUTO_INCREMENT ,
  `banco` VARCHAR(45) NOT NULL ,
  `monto` VARCHAR(45) NOT NULL ,
  `bauche` VARCHAR(45) NOT NULL ,
  `idEmpresa` INT(5) NOT NULL ,
  `idSolicitud` INT(5) NOT NULL ,
  `fecha` DATE NOT NULL ,
  `nDeposito` VARCHAR(15) NOT NULL ,
  PRIMARY KEY (`idDeposito`) ,
  INDEX `fk_Deposito_Empresa1_idx` (`idEmpresa` ASC) ,
  INDEX `fk_Deposito_Solicitud1_idx` (`idSolicitud` ASC) ,
  CONSTRAINT `fk_Deposito_Empresa1`
    FOREIGN KEY (`idEmpresa` )
    REFERENCES `caimta_sys`.`Empresa` (`idEmpresa` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Deposito_Solicitud1`
    FOREIGN KEY (`idSolicitud` )
    REFERENCES `caimta_sys`.`Solicitud` (`idSolicitud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Conductor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Conductor` (
  `idConductor` INT(5) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(25) NOT NULL ,
  `apellido` VARCHAR(25) NOT NULL ,
  `cedula` VARCHAR(15) NOT NULL ,
  `idSolicitud` INT(5) NOT NULL ,
  PRIMARY KEY (`idConductor`) ,
  INDEX `fk_Conductor_Solicitud1_idx` (`idSolicitud` ASC) ,
  CONSTRAINT `fk_Conductor_Solicitud1`
    FOREIGN KEY (`idSolicitud` )
    REFERENCES `caimta_sys`.`Solicitud` (`idSolicitud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Vehiculo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Vehiculo` (
  `idVehiculo` INT(5) NOT NULL AUTO_INCREMENT ,
  `tipo` VARCHAR(15) NOT NULL ,
  `modelo` VARCHAR(30) NOT NULL ,
  `color` VARCHAR(15) NOT NULL ,
  `pChuto` VARCHAR(12) NOT NULL ,
  `pBatea` VARCHAR(12) NOT NULL ,
  `ano` INT(5) NOT NULL ,
  `idSolicitud` INT(5) NOT NULL ,
  PRIMARY KEY (`idVehiculo`) ,
  INDEX `fk_Vehiculo_Solicitud1_idx` (`idSolicitud` ASC) ,
  CONSTRAINT `fk_Vehiculo_Solicitud1`
    FOREIGN KEY (`idSolicitud` )
    REFERENCES `caimta_sys`.`Solicitud` (`idSolicitud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Destinatario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Destinatario` (
  `idDestinatario` INT(5) NOT NULL AUTO_INCREMENT ,
  `rif` VARCHAR(15) NOT NULL ,
  `telefono` VARCHAR(15) NOT NULL ,
  `razon` VARCHAR(100) NOT NULL ,
  `direccion` VARCHAR(300) NOT NULL ,
  `finalidad` VARCHAR(45) NOT NULL ,
  `idSolicitud` INT(5) NOT NULL ,
  PRIMARY KEY (`idDestinatario`) ,
  INDEX `fk_Destinatario_Solicitud1_idx` (`idSolicitud` ASC) ,
  CONSTRAINT `fk_Destinatario_Solicitud1`
    FOREIGN KEY (`idSolicitud` )
    REFERENCES `caimta_sys`.`Solicitud` (`idSolicitud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Material`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Material` (
  `idMaterial` INT(5) NOT NULL AUTO_INCREMENT ,
  `tipo` VARCHAR(150) NOT NULL ,
  `peso` DOUBLE NOT NULL ,
  `idSolicitud` INT(5) NOT NULL ,
  PRIMARY KEY (`idMaterial`) ,
  INDEX `fk_Material_Solicitud1_idx` (`idSolicitud` ASC) ,
  CONSTRAINT `fk_Material_Solicitud1`
    FOREIGN KEY (`idSolicitud` )
    REFERENCES `caimta_sys`.`Solicitud` (`idSolicitud` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`historico_accion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`historico_accion` (
  `idhistorico_accion` INT(5) NOT NULL AUTO_INCREMENT ,
  `codigoAccion` INT(5) NOT NULL COMMENT '1 inserta\n2 modifica\n3 elimina' ,
  `fecha` DATE NOT NULL ,
  `codigo` INT(5) NOT NULL COMMENT 'codigo  clave del dato que inserto modifico o elimino en la bd\n' ,
  `tabla` VARCHAR(30) NOT NULL ,
  `idUsuario` INT(5) NOT NULL ,
  `nota` VARCHAR(200) NULL ,
  PRIMARY KEY (`idhistorico_accion`) ,
  INDEX `fk_historico_accion_Usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_historico_accion_Usuario1`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `caimta_sys`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `caimta_sys`.`Login`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `caimta_sys`.`Login` (
  `idLogin` INT(5) NOT NULL AUTO_INCREMENT ,
  `usuario` VARCHAR(20) NOT NULL ,
  `pass` VARCHAR(45) NOT NULL ,
  `tipo` VARCHAR(2) NOT NULL ,
  `idUsuario` INT(5) NULL ,
  `idEmpresa` INT(5) NULL ,
  PRIMARY KEY (`idLogin`) ,
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC) ,
  INDEX `fk_Login_Usuario1_idx` (`idUsuario` ASC) ,
  INDEX `fk_Login_Empresa1_idx` (`idEmpresa` ASC) ,
  CONSTRAINT `fk_Login_Usuario1`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `caimta_sys`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Login_Empresa1`
    FOREIGN KEY (`idEmpresa` )
    REFERENCES `caimta_sys`.`Empresa` (`idEmpresa` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `caimta_sys` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
