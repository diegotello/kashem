SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `kashem` ;
CREATE SCHEMA IF NOT EXISTS `kashem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `kashem` ;

-- -----------------------------------------------------
-- Table `kashem`.`actividad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`actividad` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`actividad` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE INDEX `id` ON `kashem`.`categoria` (`id` ASC) ;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`categoria` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`pais`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`pais` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`pais` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`departamento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`departamento` (
  `id` INT NOT NULL ,
  `pais_id` INT NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_departamento_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_departamento_paises1` ON `kashem`.`departamento` (`pais_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`municipio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`municipio` (
  `id` INT NOT NULL ,
  `departamento_id` INT NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_municipio_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_municipio_departamento1` ON `kashem`.`municipio` (`departamento_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`cliente`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`cliente` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pais_id` INT NOT NULL ,
  `departamento_id` INT NOT NULL ,
  `municipio_id` INT NOT NULL ,
  `primer_nombre` VARCHAR(50) NOT NULL ,
  `segundo_nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `primer_apellido` VARCHAR(50) NOT NULL ,
  `segundo_apellido` VARCHAR(50) NULL ,
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
  CONSTRAINT `fk_clientes_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_municipio1`
    FOREIGN KEY (`municipio_id` )
    REFERENCES `kashem`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_clientes_paises1` ON `kashem`.`cliente` (`pais_id` ASC) ;

CREATE INDEX `fk_clientes_departamento1` ON `kashem`.`cliente` (`departamento_id` ASC) ;

CREATE INDEX `fk_clientes_municipio1` ON `kashem`.`cliente` (`municipio_id` ASC) ;

CREATE UNIQUE INDEX `dpi_UNIQUE` ON `kashem`.`cliente` (`dpi` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`destino`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`destino` (
  `id` INT NOT NULL ,
  `pais_id` INT NOT NULL ,
  `departamento_id` INT NOT NULL ,
  `municipio_id` INT NOT NULL ,
  `nombre` VARCHAR(50) NULL ,
  `descripcion` TEXT NULL ,
  `lat` VARCHAR(50) NULL ,
  `long` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_destino_pais1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_municipio1`
    FOREIGN KEY (`municipio_id` )
    REFERENCES `kashem`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_destino_pais1` ON `kashem`.`destino` (`pais_id` ASC) ;

CREATE INDEX `fk_destino_departamento1` ON `kashem`.`destino` (`departamento_id` ASC) ;

CREATE INDEX `fk_destino_municipio1` ON `kashem`.`destino` (`municipio_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`guia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`guia` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `cliente_id` INT NOT NULL ,
  `categoria_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_guia_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_guia_categoria1`
    FOREIGN KEY (`categoria_id` )
    REFERENCES `kashem`.`categoria` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_guia_cliente1` ON `kashem`.`guia` (`cliente_id` ASC) ;

CREATE INDEX `fk_guia_categoria1` ON `kashem`.`guia` (`categoria_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`logro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`logro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`logro` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`rol` (
  `id` INT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `descripcion_UNIQUE` ON `kashem`.`rol` (`descripcion` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`usuario` (
  `id` INT(11) NOT NULL ,
  `rol_id` INT NOT NULL ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `password` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_usuarios_rol1`
    FOREIGN KEY (`rol_id` )
    REFERENCES `kashem`.`rol` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_usuarios_rol1` ON `kashem`.`usuario` (`rol_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`viaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`viaje` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fecha_salida` DATE NOT NULL ,
  `hora_salida` TIME NOT NULL ,
  `fecha_regreso` DATE NOT NULL ,
  `hora_regreso` TIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE INDEX `id` ON `kashem`.`viaje` (`id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`viaje_destino`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`viaje_destino` (
  `viaje_id` INT NOT NULL ,
  `destino_id` INT NOT NULL ,
  PRIMARY KEY (`viaje_id`, `destino_id`) ,
  CONSTRAINT `fk_viaje_has_destino_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_viaje_has_destino_destino1`
    FOREIGN KEY (`destino_id` )
    REFERENCES `kashem`.`destino` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_viaje_has_destino_destino1` ON `kashem`.`viaje_destino` (`destino_id` ASC) ;

CREATE INDEX `fk_viaje_has_destino_viaje1` ON `kashem`.`viaje_destino` (`viaje_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`viaje_actividad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`viaje_actividad` (
  `viaje_id` INT NOT NULL ,
  `actividad_id` INT NOT NULL ,
  PRIMARY KEY (`viaje_id`, `actividad_id`) ,
  CONSTRAINT `fk_viaje_has_actividad_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_viaje_has_actividad_actividad1`
    FOREIGN KEY (`actividad_id` )
    REFERENCES `kashem`.`actividad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_viaje_has_actividad_actividad1` ON `kashem`.`viaje_actividad` (`actividad_id` ASC) ;

CREATE INDEX `fk_viaje_has_actividad_viaje1` ON `kashem`.`viaje_actividad` (`viaje_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`cliente_logro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`cliente_logro` (
  `cliente_id` INT NOT NULL ,
  `logro_id` INT NOT NULL ,
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
ENGINE = InnoDB;

CREATE INDEX `fk_cliente_has_logro_logro1` ON `kashem`.`cliente_logro` (`logro_id` ASC) ;

CREATE INDEX `fk_cliente_has_logro_cliente1` ON `kashem`.`cliente_logro` (`cliente_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`actividad_logro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`actividad_logro` (
  `actividad_id` INT NOT NULL ,
  `logro_id` INT NOT NULL ,
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
ENGINE = InnoDB;

CREATE INDEX `fk_actividad_has_logro_logro1` ON `kashem`.`actividad_logro` (`logro_id` ASC) ;

CREATE INDEX `fk_actividad_has_logro_actividad1` ON `kashem`.`actividad_logro` (`actividad_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`cliente_viaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`cliente_viaje` (
  `cliente_id` INT NOT NULL ,
  `viaje_id` INT NOT NULL ,
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
ENGINE = InnoDB;

CREATE INDEX `fk_cliente_has_viaje_viaje1` ON `kashem`.`cliente_viaje` (`viaje_id` ASC) ;

CREATE INDEX `fk_cliente_has_viaje_cliente1` ON `kashem`.`cliente_viaje` (`cliente_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`guia_viaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`guia_viaje` (
  `guia_id` INT NOT NULL ,
  `viaje_id` INT NOT NULL ,
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
ENGINE = InnoDB;

CREATE INDEX `fk_guia_has_viaje_viaje1` ON `kashem`.`guia_viaje` (`viaje_id` ASC) ;

CREATE INDEX `fk_guia_has_viaje_guia1` ON `kashem`.`guia_viaje` (`guia_id` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`equipo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`equipo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `cantidad_existente` INT NOT NULL ,
  `descripcion` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `nombre_UNIQUE` ON `kashem`.`equipo` (`nombre` ASC) ;


-- -----------------------------------------------------
-- Table `kashem`.`alquiler`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kashem`.`alquiler` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `equipo_id` INT NOT NULL ,
  `cliente_id` INT NOT NULL ,
  `renta` DATE NOT NULL ,
  `devolucion` DATE NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_alquiler_equipo1`
    FOREIGN KEY (`equipo_id` )
    REFERENCES `kashem`.`equipo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alquiler_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_alquiler_equipo1` ON `kashem`.`alquiler` (`equipo_id` ASC) ;

CREATE INDEX `fk_alquiler_cliente1` ON `kashem`.`alquiler` (`cliente_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
