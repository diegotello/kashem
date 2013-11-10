INSERT INTO `kashem`.`rol`
(`id`,`descripcion`) VALUES (1,'admin');
INSERT INTO `kashem`.`usuario`
(`id`,`rol_id`,`nombre`,`password`)
VALUES (1,1,'admin','admin');