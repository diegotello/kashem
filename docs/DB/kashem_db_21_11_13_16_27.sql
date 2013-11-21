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
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`logro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`logro` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`logro` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`actividad_logro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`actividad_logro` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`actividad_logro` (
  `actividad_id` INT(11) NOT NULL ,
  `logro_id` INT(11) NOT NULL ,
  PRIMARY KEY (`actividad_id`, `logro_id`) ,
  INDEX `fk_actividad_has_logro_logro1` (`logro_id` ASC) ,
  INDEX `fk_actividad_has_logro_actividad1` (`actividad_id` ASC) ,
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


-- -----------------------------------------------------
-- Table `kashem`.`pais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`pais` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`pais` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`departamento` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`departamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_departamento_paises1` (`pais_id` ASC) ,
  CONSTRAINT `fk_departamento_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `kashem`.`pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`municipio` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`municipio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `departamento_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_municipio_departamento1` (`departamento_id` ASC) ,
  CONSTRAINT `fk_municipio_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `kashem`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 334
DEFAULT CHARACTER SET = utf8;


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
  `dpi` VARCHAR(50) NOT NULL ,
  `telefono` VARCHAR(50) NULL DEFAULT NULL ,
  `direccion` VARCHAR(50) NULL DEFAULT NULL ,
  `correo_electronico` VARCHAR(50) NULL DEFAULT NULL ,
  `usuario_facebook` VARCHAR(50) NULL DEFAULT NULL ,
  `contacto_emergencia` VARCHAR(50) NULL DEFAULT NULL ,
  `telefono_emergencia` VARCHAR(50) NULL DEFAULT NULL ,
  `observacion_medica` TEXT NULL DEFAULT NULL ,
  `observacion_general` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `dpi_UNIQUE` (`dpi` ASC) ,
  INDEX `fk_clientes_paises1` (`pais_id` ASC) ,
  INDEX `fk_clientes_departamento1` (`departamento_id` ASC) ,
  INDEX `fk_clientes_municipio1` (`municipio_id` ASC) ,
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
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`alquiler`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`alquiler` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`alquiler` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cliente_id` INT(11) NOT NULL ,
  `renta` DATE NOT NULL ,
  `devolucion` DATE NOT NULL ,
  `deposito` DECIMAL(6,2) NULL DEFAULT NULL ,
  `comentario` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `cliente_id` (`cliente_id` ASC) ,
  CONSTRAINT `cliente_id`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`equipo` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`equipo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `identificador` VARCHAR(50) NOT NULL ,
  `disponible` TINYINT(1) NOT NULL DEFAULT '1' ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `identificador_UNIQUE` (`identificador` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`alquiler_equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`alquiler_equipo` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`alquiler_equipo` (
  `alquiler_id` INT(11) NOT NULL ,
  `equipo_id` INT(11) NOT NULL ,
  PRIMARY KEY (`alquiler_id`, `equipo_id`) ,
  INDEX `alquiler_equipo_alquiler_fk` (`alquiler_id` ASC) ,
  INDEX `alquiler_equipo_equipo_fk` (`equipo_id` ASC) ,
  CONSTRAINT `alquiler_equipo_alquiler_fk`
    FOREIGN KEY (`alquiler_id` )
    REFERENCES `kashem`.`alquiler` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `alquiler_equipo_equipo_fk`
    FOREIGN KEY (`equipo_id` )
    REFERENCES `kashem`.`equipo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`categoria` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`categoria` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) ,
  INDEX `id` (`id` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`cliente_logro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`cliente_logro` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`cliente_logro` (
  `cliente_id` INT(11) NOT NULL ,
  `logro_id` INT(11) NOT NULL ,
  PRIMARY KEY (`cliente_id`, `logro_id`) ,
  INDEX `fk_cliente_has_logro_logro1` (`logro_id` ASC) ,
  INDEX `fk_cliente_has_logro_cliente1` (`cliente_id` ASC) ,
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


-- -----------------------------------------------------
-- Table `kashem`.`viaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`viaje` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`viaje` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `fecha_salida` DATE NOT NULL ,
  `hora_salida` TIME NOT NULL ,
  `fecha_regreso` DATE NOT NULL ,
  `hora_regreso` TIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `id` (`id` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`cliente_viaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`cliente_viaje` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`cliente_viaje` (
  `cliente_id` INT(11) NOT NULL ,
  `viaje_id` INT(11) NOT NULL ,
  PRIMARY KEY (`cliente_id`, `viaje_id`) ,
  INDEX `fk_cliente_has_viaje_viaje1` (`viaje_id` ASC) ,
  INDEX `fk_cliente_has_viaje_cliente1` (`cliente_id` ASC) ,
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


-- -----------------------------------------------------
-- Table `kashem`.`tipo_pago`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`tipo_pago` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`tipo_pago` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`cuenta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`cuenta` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`cuenta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cliente_id` INT(11) NOT NULL ,
  `alquiler_id` INT(11) NULL DEFAULT NULL ,
  `viaje_id` INT(11) NULL DEFAULT NULL ,
  `tipo_de_pago_id` INT(11) NOT NULL ,
  `tipo` VARCHAR(50) NOT NULL COMMENT 'puede ser \"viaje\" o \"alquiler\"' ,
  `estado` VARCHAR(50) NOT NULL COMMENT 'puede ser \"pendiente\" o \"cancelado\"' ,
  `monto` DECIMAL(6,2) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `cuenta_cliente_fk` (`cliente_id` ASC) ,
  INDEX `cuenta_viaje_fk` (`viaje_id` ASC) ,
  INDEX `cuenta_alquiler_fk` (`alquiler_id` ASC) ,
  INDEX `cuenta_tipo_de_pago_fk` (`tipo_de_pago_id` ASC) ,
  INDEX `cuenta_tipo_de_cuenta_fk` (`tipo` ASC) ,
  CONSTRAINT `cuenta_alquiler_fk`
    FOREIGN KEY (`alquiler_id` )
    REFERENCES `kashem`.`alquiler` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cuenta_cliente_fk`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `kashem`.`cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cuenta_tipo_de_pago_fk`
    FOREIGN KEY (`tipo_de_pago_id` )
    REFERENCES `kashem`.`tipo_pago` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cuenta_viaje_fk`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `kashem`.`viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`destino`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`destino` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`destino` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `departamento_id` INT(11) NOT NULL ,
  `municipio_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  `lat` VARCHAR(50) NULL DEFAULT NULL ,
  `long` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) ,
  INDEX `fk_destino_pais1` (`pais_id` ASC) ,
  INDEX `fk_destino_departamento1` (`departamento_id` ASC) ,
  INDEX `fk_destino_municipio1` (`municipio_id` ASC) ,
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
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`guia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`guia` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`guia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cliente_id` INT(11) NOT NULL ,
  `categoria_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_guia_cliente1` (`cliente_id` ASC) ,
  INDEX `fk_guia_categoria1` (`categoria_id` ASC) ,
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
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`guia_viaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`guia_viaje` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`guia_viaje` (
  `guia_id` INT(11) NOT NULL ,
  `viaje_id` INT(11) NOT NULL ,
  PRIMARY KEY (`guia_id`, `viaje_id`) ,
  INDEX `fk_guia_has_viaje_viaje1` (`viaje_id` ASC) ,
  INDEX `fk_guia_has_viaje_guia1` (`guia_id` ASC) ,
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


-- -----------------------------------------------------
-- Table `kashem`.`rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`rol` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`rol` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `descripcion_UNIQUE` (`descripcion` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `rol_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) ,
  INDEX `fk_usuarios_rol1` (`rol_id` ASC) ,
  CONSTRAINT `fk_usuarios_rol1`
    FOREIGN KEY (`rol_id` )
    REFERENCES `kashem`.`rol` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kashem`.`viaje_actividad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`viaje_actividad` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`viaje_actividad` (
  `viaje_id` INT(11) NOT NULL ,
  `actividad_id` INT(11) NOT NULL ,
  PRIMARY KEY (`viaje_id`, `actividad_id`) ,
  INDEX `fk_viaje_has_actividad_actividad1` (`actividad_id` ASC) ,
  INDEX `fk_viaje_has_actividad_viaje1` (`viaje_id` ASC) ,
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


-- -----------------------------------------------------
-- Table `kashem`.`viaje_destino`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kashem`.`viaje_destino` ;

CREATE  TABLE IF NOT EXISTS `kashem`.`viaje_destino` (
  `viaje_id` INT(11) NOT NULL ,
  `destino_id` INT(11) NOT NULL ,
  PRIMARY KEY (`viaje_id`, `destino_id`) ,
  INDEX `fk_viaje_has_destino_destino1` (`destino_id` ASC) ,
  INDEX `fk_viaje_has_destino_viaje1` (`viaje_id` ASC) ,
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



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
