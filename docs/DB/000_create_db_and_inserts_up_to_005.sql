SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `kashem` ;
CREATE SCHEMA IF NOT EXISTS `kashem` DEFAULT CHARACTER SET utf8 ;
USE `kashem` ;

-- -----------------------------------------------------
-- Table `kashem`.`actividad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`actividad` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`actividad` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`actividad` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`logro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`logro` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`logro` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`logro` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`actividad_logro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`actividad_logro` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`actividad_logro` (
  `actividad_id` INT(11) NOT NULL ,
  `logro_id` INT(11) NOT NULL ,
  PRIMARY KEY (`actividad_id`, `logro_id`) ,
  CONSTRAINT `fk_actividad_has_logro_actividad1`
    FOREIGN KEY (`actividad_id` )
    REFERENCES `kashem`.`actividad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_actividad_has_logro_logro1`
    FOREIGN KEY (`logro_id` )
    REFERENCES `kashem`.`logro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_actividad_has_logro_logro1` ON `kashem`.`actividad_logro` (`logro_id` ASC) ;

CREATE INDEX `fk_actividad_has_logro_actividad1` ON `kashem`.`actividad_logro` (`actividad_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`pais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`pais` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`pais` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`pais` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`departamento` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`departamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_departamento_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_departamento_paises1` ON `kashem`.`departamento` (`pais_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`municipio` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`municipio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `departamento_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_municipio_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_municipio_departamento1` ON `kashem`.`municipio` (`departamento_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`cliente` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`cliente` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `departamento_id` INT(11) NOT NULL ,
  `municipio_id` INT(11) NOT NULL ,
  `primer_nombre` VARCHAR(50) NOT NULL ,
  `segundo_nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `primer_apellido` VARCHAR(50) NOT NULL ,
  `segundo_apellido` VARCHAR(50) NULL DEFAULT NULL ,
  `fecha_nacimiento` DATE NULL DEFAULT NULL ,
  `genero` VARCHAR(50) NULL DEFAULT NULL ,
  `dpi` VARCHAR(50) NULL DEFAULT NULL ,
  `telefono` VARCHAR(50) NULL DEFAULT NULL ,
  `direccion` VARCHAR(50) NULL DEFAULT NULL ,
  `correo_electronico` VARCHAR(50) NULL DEFAULT NULL ,
  `usuario_facebook` VARCHAR(50) NULL DEFAULT NULL ,
  `contacto_emergencia` VARCHAR(50) NULL DEFAULT NULL ,
  `telefono_emergencia` VARCHAR(50) NULL DEFAULT NULL ,
  `observacion_medica` TEXT NULL DEFAULT NULL ,
  `observacion_general` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_clientes_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_municipio1`
    FOREIGN KEY (`municipio_id` )
    REFERENCES `kashem`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_clientes_paises1` ON `kashem`.`cliente` (`pais_id` ASC) ;

CREATE INDEX `fk_clientes_departamento1` ON `kashem`.`cliente` (`departamento_id` ASC) ;

CREATE INDEX `fk_clientes_municipio1` ON `kashem`.`cliente` (`municipio_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`equipo` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`equipo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `cantidad_existente` INT(11) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`equipo` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`alquiler`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`alquiler` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`alquiler` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `equipo_id` INT(11) NOT NULL ,
  `cliente_id` INT(11) NOT NULL ,
  `renta` DATE NOT NULL ,
  `devolucion` DATE NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_alquiler_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alquiler_equipo1`
    FOREIGN KEY (`equipo_id` )
    REFERENCES `kashem`.`equipo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_alquiler_equipo1` ON `kashem`.`alquiler` (`equipo_id` ASC) ;

CREATE INDEX `fk_alquiler_cliente1` ON `kashem`.`alquiler` (`cliente_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`categoria` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`categoria` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`categoria` (`nombre` ASC) ;

CREATE INDEX `id` ON `kashem`.`categoria` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`cliente_logro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`cliente_logro` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`cliente_logro` (
  `cliente_id` INT(11) NOT NULL ,
  `logro_id` INT(11) NOT NULL ,
  PRIMARY KEY (`cliente_id`, `logro_id`) ,
  CONSTRAINT `fk_cliente_has_logro_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_has_logro_logro1`
    FOREIGN KEY (`logro_id` )
    REFERENCES `kashem`.`logro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_cliente_has_logro_logro1` ON `kashem`.`cliente_logro` (`logro_id` ASC) ;

CREATE INDEX `fk_cliente_has_logro_cliente1` ON `kashem`.`cliente_logro` (`cliente_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`viaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`viaje` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`viaje` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `fecha_salida` DATE NOT NULL ,
  `hora_salida` TIME NOT NULL ,
  `fecha_regreso` DATE NOT NULL ,
  `hora_regreso` TIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `id` ON `kashem`.`viaje` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`cliente_viaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`cliente_viaje` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`cliente_viaje` (
  `cliente_id` INT(11) NOT NULL ,
  `viaje_id` INT(11) NOT NULL ,
  PRIMARY KEY (`cliente_id`, `viaje_id`) ,
  CONSTRAINT `fk_cliente_has_viaje_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_has_viaje_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_cliente_has_viaje_viaje1` ON `kashem`.`cliente_viaje` (`viaje_id` ASC) ;

CREATE INDEX `fk_cliente_has_viaje_cliente1` ON `kashem`.`cliente_viaje` (`cliente_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`destino`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`destino` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`destino` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `departamento_id` INT(11) NOT NULL ,
  `municipio_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  `lat` VARCHAR(50) NULL DEFAULT NULL ,
  `long` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_destino_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_municipio1`
    FOREIGN KEY (`municipio_id` )
    REFERENCES `kashem`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_pais1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_destino_pais1` ON `kashem`.`destino` (`pais_id` ASC) ;

CREATE INDEX `fk_destino_departamento1` ON `kashem`.`destino` (`departamento_id` ASC) ;

CREATE INDEX `fk_destino_municipio1` ON `kashem`.`destino` (`municipio_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`guia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`guia` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`guia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cliente_id` INT(11) NOT NULL ,
  `categoria_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_guia_categoria1`
    FOREIGN KEY (`categoria_id` )
    REFERENCES `kashem`.`categoria` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_guia_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_guia_cliente1` ON `kashem`.`guia` (`cliente_id` ASC) ;

CREATE INDEX `fk_guia_categoria1` ON `kashem`.`guia` (`categoria_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`guia_viaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`guia_viaje` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`guia_viaje` (
  `guia_id` INT(11) NOT NULL ,
  `viaje_id` INT(11) NOT NULL ,
  PRIMARY KEY (`guia_id`, `viaje_id`) ,
  CONSTRAINT `fk_guia_has_viaje_guia1`
    FOREIGN KEY (`guia_id` )
    REFERENCES `kashem`.`guia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_guia_has_viaje_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_guia_has_viaje_viaje1` ON `kashem`.`guia_viaje` (`viaje_id` ASC) ;

CREATE INDEX `fk_guia_has_viaje_guia1` ON `kashem`.`guia_viaje` (`guia_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`rol` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`rol` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `descripcion_UNIQUE` ON `kashem`.`rol` (`descripcion` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `rol_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `password` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_usuarios_rol1`
    FOREIGN KEY (`rol_id` )
    REFERENCES `kashem`.`rol` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_usuarios_rol1` ON `kashem`.`usuario` (`rol_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`viaje_actividad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`viaje_actividad` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`viaje_actividad` (
  `viaje_id` INT(11) NOT NULL ,
  `actividad_id` INT(11) NOT NULL ,
  PRIMARY KEY (`viaje_id`, `actividad_id`) ,
  CONSTRAINT `fk_viaje_has_actividad_actividad1`
    FOREIGN KEY (`actividad_id` )
    REFERENCES `kashem`.`actividad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_viaje_has_actividad_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_viaje_has_actividad_actividad1` ON `kashem`.`viaje_actividad` (`actividad_id` ASC) ;

CREATE INDEX `fk_viaje_has_actividad_viaje1` ON `kashem`.`viaje_actividad` (`viaje_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`viaje_destino`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`viaje_destino` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`viaje_destino` (
  `viaje_id` INT(11) NOT NULL ,
  `destino_id` INT(11) NOT NULL ,
  PRIMARY KEY (`viaje_id`, `destino_id`) ,
  CONSTRAINT `fk_viaje_has_destino_destino1`
    FOREIGN KEY (`destino_id` )
    REFERENCES `kashem`.`destino` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_viaje_has_destino_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_viaje_has_destino_destino1` ON `kashem`.`viaje_destino` (`destino_id` ASC) ;

CREATE INDEX `fk_viaje_has_destino_viaje1` ON `kashem`.`viaje_destino` (`viaje_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
INSERT INTO `kashem`.`rol`
(`id`,`descripcion`) VALUES (1,'admin');
INSERT INTO `kashem`.`usuario`
(`id`,`rol_id`,`nombre`,`password`)
VALUES (1,1,'admin','admin');
INSERT INTO `kashem`.`pais`
(`id`,`nombre`)
VALUES(1,'guatemala');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (1,1,'alta verapaz');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (2,1,'baja verapaz');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (3,1,'chimaltenango');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (4,1,'chiquimula');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (5,1,'el progreso');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (6,1,'escuintla');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (7,1,'guatemala');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (8,1,'huehuetenango');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (9,1,'izabal');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (10,1,'jalapa');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (11,1,'jutiapa');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (12,1,'peten');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (13,1,'quetzaltenango');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (14,1,'quiche');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (15,1,'retalhuleu');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (16,1,'sacatepequez');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (17,1,'san marcos');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (18,1,'santa rosa');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (19,1,'solola');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (20,1,'suchitepequez');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (21,1,'totonicapan');
INSERT INTO `departamento`(`id`,`pais_id`,`nombre`) VALUES (22,1,'zacapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'fray bartolome de las casas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'coban');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'chahal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'san pedro carcha');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'cahabon');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'lanquin');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'senahu');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'panzos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'san cristobal verapaz');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'san juan chamelco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'santa cruz verapaz');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'tucuru');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'tamahu');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'tactic');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'santa catarina la tinta');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'raxruja');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (1,'chisec');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'cubulco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'purulha');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'san miguel chicaj');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'rabinal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'salama');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'san jeronimo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'el chol');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (2,'granados');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'tecpan guatemala');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'san martin jilotepeque');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'san jose poaquil');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'santa apolonia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'comalapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'chimaltenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'zaragoza');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'el tejar');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'patzun');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'santa cruz balanya');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'patzicia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'san andres itzapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'parramos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'pochuta');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'acatenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (3,'yepocapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'camotan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'jocotan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'chiquimula');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'esquipulas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'san juan la ermita');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'san jose la arada');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'olopa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'san jacinto');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'quetzaltepeque');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'ipala');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (4,'concepcion las minas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'san agustin acasaguastlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'morazan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'san cristobal acasguastlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'el jicaro');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'guastatoya');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'sanarate');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'san antonio la paz');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (5,'sansare');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'escuintla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'siquinala');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'palin');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'santa lucia cotzulmalguapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'san vicente pacaya');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'tiquisate');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'nueva concepcion');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'guanagazapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'la democracia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'masagua');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'la gomera');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'san jose');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (6,'iztapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'chuarrancho');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'san raymundo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'san juan sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'san jose del golfo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'san pedro ayampuc');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'chinautla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'palencia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'san pedro sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'guatemala');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'mixco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'san jose pinula');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'santa catarina pinula');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'villa nueva');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'villa canales');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'fraijanes');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'petapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (7,'amatitlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'barillas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san mateo ixtatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'nenton');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san sebastian coatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'santa eulalia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'jacaltenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'santa ana huista');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san miguel acatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san rafael la independencia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san antonio huista');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'soloma');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'la democracia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san juan ixcoy');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'chiantla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'la libertad');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'cuilco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'aguacatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san juan atitan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san idelfonso ixtahuacan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san sebastian huehuetenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'colotenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san rafael petzal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'tectitan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san gaspar ixchil');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'santa barbara');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'huehuetenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'malacatancito');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'union cantinil');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'concepcion huista');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'santiago chimaltenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'san pedro necta');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (8,'todos santos cuchumatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (9,'puerto barrios');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (9,'livingston');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (9,'el estor');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (9,'morales');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (9,'los amates');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'san pedro pinula');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'jalapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'san luis jilotepeque');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'mataquescuintla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'san manuel chaparron');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'monjas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (10,'san carlos alzatate');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'agua blanca');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'santa catarina mita');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'el progreso');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'jutiapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'asuncion mita');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'quesada');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'san jose acatempa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'yupiltepeque');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'jalpatagua');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'atescatempa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'comapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'el adelanto');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'zapotitlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'jerez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'conguaco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'moyuta');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (11,'pasaco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'melchor de mencos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'flores');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'san jose');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'san andres');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'la libertad');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'san benito');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'santa ana');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'dolores');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'san francisco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'sayaxche');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'poptun');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (12,'san luis');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'san carlos sija');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'cabrican');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'huitan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'sibilia');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'palestina de los altos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'cajola');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'san francisco la union');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'san juan ostuncalco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'san miguel siguila');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'olintepeque');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'la esperanza');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'salcaja');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'quetzaltenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'san mateo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'concepcion chiquirichapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'cantel');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'san martin sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'colomba');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'almolonga');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'zunil');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'el palmar');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'coatepeque');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'flores costa cuca');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (13,'genova');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'ixcan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'nebaj');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'chajul');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'uspantan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'chicaman');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'san juan cotzal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'cunen');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'san andres sajcabaja');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'sacapulas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'canilla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'san pedro jocopilas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'san bartolome jocotenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'zacualpa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'san antonio ilotenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'santa cruz del quiche');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'joyabaj');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'chinique');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'chiche');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'patzite');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'chichicastenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (14,'pachalum');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'nuevo san carlos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'san felipe retalhuleu');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'el asintal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'san andres villa seca');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'san martin zapotitlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'santa cruz mulua');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'san sebastian');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'retalhuleu');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (15,'champerico');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'sumpango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'santo domingo xenacoj');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'santiago sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'pastores');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'san lucas sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'san bartolome milpas altas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'antigua guatemala');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'jocotenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'santa lucia milpas altas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'santa catarina barahona');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'san antonio aguas calientes');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'san miguel dueñas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'magdalena milpas altas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'ciudad vieja');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'santa maria de jesus');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (16,'alotenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'tacana');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'concepcion tutuapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san miguel ixtahuacan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san jose ojetenam');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'sipacapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'tejutla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'comitancillo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'ixchiguan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'sibinal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'tajumulco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'rio blanco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san marcos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san lorenzo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san pablo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'malacatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san pedro sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san antonio sacatepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san rafael pie de la cuesta');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'esquipulas palo gordo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'el rodeo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'san cristobal cucho');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'el tumbador');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'nuevo progreso');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'catarina');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'la reforma');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'el quetzal');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'pajapita');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'ayutla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (17,'ocos');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'santa rosa de lima');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'san rafael las flores');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'casillas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'nueva santa rosa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'santa cruz naranjo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'barberena');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'cuilapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'pueblo nuevo viñas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'oratorio');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'santa maria ixhuatan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'taxisco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'chiquimulilla');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'guazacapan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (18,'san juan tecuaco');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'solola');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'nahuala');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santa catarina ixtahuacan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santa lucia utatlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san andres semetabaj');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'concepcion');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san jose chacaya');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'panajachel');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santa cruz la laguna');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san marcos la laguna');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san pablo la laguna');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santa clara la laguna');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santa catarina palapo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santa maria visitacion');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san juan la laguna');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san antonio palapo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san pedro la laguna');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'santiago atitlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (19,'san lucas toliman');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'pueblo nuevo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san francisco zapotitlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'zunilito');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'chicacao');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'santo tomas la union');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san pablo jocopila');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'cuyotenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'samayac');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'mazatenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'santa barbara');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san antonio suchitepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'patulul');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san bernandino');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san miguel panan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san gabriel');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'santo domingo suchitepequez');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san lorenzo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san jose el idolo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'rio bravo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (20,'san juan bautista');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'momostenango');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'santa lucia la reforma');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'san bartolo aguas calientes');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'santa maria chiquimula');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'san francisco el alto');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'san cristobal totonicapan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'totonicapan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (21,'san andres xecul');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'gualan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'rio hondo');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'teculutan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'zacapa');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'usumatlan');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'estanzuela');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'la union');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'huite');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'cabañas');
INSERT INTO `municipio`(`departamento_id`,`nombre`) VALUES (22,'san diego');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('montañismo');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('senderismo');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('alta montaña');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('excursionismo');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('escalada');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('rappel');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('espeleologia');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('rafting');
INSERT INTO `kashem`.`actividad`
(`nombre`) VALUES('ciclismo mtb');