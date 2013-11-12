SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `actividad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `actividad` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `logro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `logro` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `actividad_logro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `actividad_logro` (
  `actividad_id` INT(11) NOT NULL ,
  `logro_id` INT(11) NOT NULL ,
  PRIMARY KEY (`actividad_id`, `logro_id`) ,
  INDEX `fk_actividad_has_logro_logro1` (`logro_id` ASC) ,
  INDEX `fk_actividad_has_logro_actividad1` (`actividad_id` ASC) ,
  CONSTRAINT `fk_actividad_has_logro_actividad1`
    FOREIGN KEY (`actividad_id` )
    REFERENCES `actividad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_actividad_has_logro_logro1`
    FOREIGN KEY (`logro_id` )
    REFERENCES `logro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pais`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pais` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `departamento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `departamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_departamento_paises1` (`pais_id` ASC) ,
  CONSTRAINT `fk_departamento_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `municipio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `municipio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `departamento_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_municipio_departamento1` (`departamento_id` ASC) ,
  CONSTRAINT `fk_municipio_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 334
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cliente`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cliente` (
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
  INDEX `fk_clientes_paises1` (`pais_id` ASC) ,
  INDEX `fk_clientes_departamento1` (`departamento_id` ASC) ,
  INDEX `fk_clientes_municipio1` (`municipio_id` ASC) ,
  CONSTRAINT `fk_clientes_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_municipio1`
    FOREIGN KEY (`municipio_id` )
    REFERENCES `municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_paises1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `equipo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `equipo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `cantidad_existente` INT(11) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `alquiler`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `alquiler` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `equipo_id` INT(11) NOT NULL ,
  `cliente_id` INT(11) NOT NULL ,
  `renta` DATE NOT NULL ,
  `devolucion` DATE NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_alquiler_equipo1` (`equipo_id` ASC) ,
  INDEX `fk_alquiler_cliente1` (`cliente_id` ASC) ,
  CONSTRAINT `fk_alquiler_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alquiler_equipo1`
    FOREIGN KEY (`equipo_id` )
    REFERENCES `equipo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `categoria` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) ,
  INDEX `id` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cliente_logro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cliente_logro` (
  `cliente_id` INT(11) NOT NULL ,
  `logro_id` INT(11) NOT NULL ,
  PRIMARY KEY (`cliente_id`, `logro_id`) ,
  INDEX `fk_cliente_has_logro_logro1` (`logro_id` ASC) ,
  INDEX `fk_cliente_has_logro_cliente1` (`cliente_id` ASC) ,
  CONSTRAINT `fk_cliente_has_logro_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_has_logro_logro1`
    FOREIGN KEY (`logro_id` )
    REFERENCES `logro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `viaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `viaje` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `fecha_salida` DATE NOT NULL ,
  `hora_salida` TIME NOT NULL ,
  `fecha_regreso` DATE NOT NULL ,
  `hora_regreso` TIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `id` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cliente_viaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cliente_viaje` (
  `cliente_id` INT(11) NOT NULL ,
  `viaje_id` INT(11) NOT NULL ,
  PRIMARY KEY (`cliente_id`, `viaje_id`) ,
  INDEX `fk_cliente_has_viaje_viaje1` (`viaje_id` ASC) ,
  INDEX `fk_cliente_has_viaje_cliente1` (`cliente_id` ASC) ,
  CONSTRAINT `fk_cliente_has_viaje_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_has_viaje_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `destino`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `destino` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pais_id` INT(11) NOT NULL ,
  `departamento_id` INT(11) NOT NULL ,
  `municipio_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  `lat` VARCHAR(50) NULL DEFAULT NULL ,
  `long` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_destino_pais1` (`pais_id` ASC) ,
  INDEX `fk_destino_departamento1` (`departamento_id` ASC) ,
  INDEX `fk_destino_municipio1` (`municipio_id` ASC) ,
  CONSTRAINT `fk_destino_departamento1`
    FOREIGN KEY (`departamento_id` )
    REFERENCES `departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_municipio1`
    FOREIGN KEY (`municipio_id` )
    REFERENCES `municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_pais1`
    FOREIGN KEY (`pais_id` )
    REFERENCES `pais` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `guia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `guia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cliente_id` INT(11) NOT NULL ,
  `categoria_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_guia_cliente1` (`cliente_id` ASC) ,
  INDEX `fk_guia_categoria1` (`categoria_id` ASC) ,
  CONSTRAINT `fk_guia_categoria1`
    FOREIGN KEY (`categoria_id` )
    REFERENCES `categoria` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_guia_cliente1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `cliente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `guia_viaje`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `guia_viaje` (
  `guia_id` INT(11) NOT NULL ,
  `viaje_id` INT(11) NOT NULL ,
  PRIMARY KEY (`guia_id`, `viaje_id`) ,
  INDEX `fk_guia_has_viaje_viaje1` (`viaje_id` ASC) ,
  INDEX `fk_guia_has_viaje_guia1` (`guia_id` ASC) ,
  CONSTRAINT `fk_guia_has_viaje_guia1`
    FOREIGN KEY (`guia_id` )
    REFERENCES `guia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_guia_has_viaje_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rol` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `descripcion_UNIQUE` (`descripcion` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `rol_id` INT(11) NOT NULL ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `password` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuarios_rol1` (`rol_id` ASC) ,
  CONSTRAINT `fk_usuarios_rol1`
    FOREIGN KEY (`rol_id` )
    REFERENCES `rol` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `viaje_actividad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `viaje_actividad` (
  `viaje_id` INT(11) NOT NULL ,
  `actividad_id` INT(11) NOT NULL ,
  PRIMARY KEY (`viaje_id`, `actividad_id`) ,
  INDEX `fk_viaje_has_actividad_actividad1` (`actividad_id` ASC) ,
  INDEX `fk_viaje_has_actividad_viaje1` (`viaje_id` ASC) ,
  CONSTRAINT `fk_viaje_has_actividad_actividad1`
    FOREIGN KEY (`actividad_id` )
    REFERENCES `actividad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_viaje_has_actividad_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `viaje_destino`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `viaje_destino` (
  `viaje_id` INT(11) NOT NULL ,
  `destino_id` INT(11) NOT NULL ,
  PRIMARY KEY (`viaje_id`, `destino_id`) ,
  INDEX `fk_viaje_has_destino_destino1` (`destino_id` ASC) ,
  INDEX `fk_viaje_has_destino_viaje1` (`viaje_id` ASC) ,
  CONSTRAINT `fk_viaje_has_destino_destino1`
    FOREIGN KEY (`destino_id` )
    REFERENCES `destino` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_viaje_has_destino_viaje1`
    FOREIGN KEY (`viaje_id` )
    REFERENCES `viaje` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
