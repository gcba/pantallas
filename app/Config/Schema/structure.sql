CREATE DATABASE pantallas;
use pantallas;

CREATE TABLE `mensaje` (
	`mensaje_id` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(45) NOT NULL,
	`mensaje` text NOT NULL,
	`activo` tinyint(4) DEFAULT NULL,
	PRIMARY KEY (`mensaje_id`)
);

CREATE TABLE `alerta` (
	`alerta_id` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(50) NOT NULL,
	`subtitulo` varchar(100) DEFAULT NULL,
	`icono` varchar(45) NOT NULL,
	`fecha_desde` datetime DEFAULT NULL,
	`fecha_hasta` datetime DEFAULT NULL,
	`activo` int(4) DEFAULT NULL,
	`color` varchar(45) NOT NULL,
	PRIMARY KEY (`alerta_id`)
);

CREATE TABLE `tag` (
	`tag_id` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(45) NOT NULL,
	PRIMARY KEY (`tag_id`)
);

INSERT INTO `tag` (nombre) VALUES
('A designar');


CREATE TABLE `user` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`mail` varchar(45) NOT NULL,
	`user` varchar(45) NOT NULL,
	`password` varchar(45) NOT NULL,
	`role` varchar(45) NOT NULL,
	`last_login` datetime DEFAULT NULL,
	PRIMARY KEY (`user_id`)
);

CREATE TABLE `audits` (
	`id` varchar(36) NOT NULL,
	`event` varchar(255) NOT NULL,
	`model` varchar(255) NOT NULL,
	`entity_id` varchar(36) NOT NULL,
	`json_object` text NOT NULL,
	`description` text,
	`source_id` int(11) DEFAULT NULL,
	`source_mail` varchar(255) NOT NULL,
	`created` datetime NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_audits_1_idx` (`source_id`),
	CONSTRAINT `fk_audits_1` FOREIGN KEY (`source_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `audit_deltas` (
	`id` varchar(36) NOT NULL,
	`audit_id` varchar(36) NOT NULL,
	`property_name` varchar(255) NOT NULL,
	`old_value` text,
	`new_value` text,
	PRIMARY KEY (`id`),
	KEY `audit_id` (`audit_id`),
	CONSTRAINT `fk_audit_deltas_1` FOREIGN KEY (`audit_id`) REFERENCES `audits` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `origen` (
	`origen_id` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(45) NOT NULL,
	`slug` varchar(45) NOT NULL,
	`descripcion` text,
	`usa_cron` tinyint(4) DEFAULT NULL,
	`fecha_ultima_actualizacion` datetime DEFAULT NULL,
	`settings` text,
	`fecha_ultima_modificacion` datetime DEFAULT NULL,
	PRIMARY KEY (`origen_id`),
	UNIQUE KEY `slug_UNIQUE` (`slug`)
);

CREATE TABLE `contenido` (
	`contenido_id` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(45) NOT NULL,
	`descripcion` text,
	`origen_id` int(11) NOT NULL,
	`local_data` text,
	`settings` text,
	`fecha_ultima_modificacion` datetime DEFAULT NULL,
	PRIMARY KEY (`contenido_id`),
	KEY `fk_contenido_1_idx` (`origen_id`),
	CONSTRAINT `fk_contenido_1` FOREIGN KEY (`origen_id`) REFERENCES `origen` (`origen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `pantalla` (
	`pantalla_id` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(45) NOT NULL,
	`direccion` varchar(255) NOT NULL,
	`lat` double NOT NULL,
	`lng` double NOT NULL,
	`orientacion` varchar(45) NOT NULL,
	`comuna` int(11) NOT NULL,
	`barrio` varchar(45) NOT NULL,
	`ip_actual` varchar(45) DEFAULT NULL,
	`fecha_ultima_consulta` datetime DEFAULT NULL,
	`fecha_ultima_modificacion` datetime DEFAULT NULL,
	`envio_alerta` int(11) DEFAULT '0',
	PRIMARY KEY (`pantalla_id`)
);

CREATE TABLE `contenido_pantalla` (
	`contenido_id` int(11) NOT NULL,
	`pantalla_id` int(11) NOT NULL,
	PRIMARY KEY (`contenido_id`,`pantalla_id`),
	KEY `fk_contenido_pantalla_1_idx` (`contenido_id`),
	KEY `fk_contenido_pantalla_2_idx` (`pantalla_id`),
	CONSTRAINT `fk_contenido_pantalla_1` FOREIGN KEY (`contenido_id`) REFERENCES `contenido` (`contenido_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_contenido_pantalla_2` FOREIGN KEY (`pantalla_id`) REFERENCES `pantalla` (`pantalla_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `tag_pantalla` (
	`tag_id` int(11) NOT NULL,
	`pantalla_id` int(11) NOT NULL,
	PRIMARY KEY (`tag_id`,`pantalla_id`),
	KEY `fk_tag_pantalla_2_idx` (`pantalla_id`),
	KEY `fk_tag_pantalla_1_idx` (`tag_id`),
	CONSTRAINT `fk_tag_pantalla_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_tag_pantalla_2` FOREIGN KEY (`pantalla_id`) REFERENCES `pantalla` (`pantalla_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `tag_user` (
	`tag_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	PRIMARY KEY (`tag_id`,`user_id`),
	KEY `fk_tag_user_1_idx` (`user_id`),
	KEY `fk_tag_user_2_idx` (`tag_id`),
	CONSTRAINT `fk_tag_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_tag_user_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);