La base de datos se llamará db_proyectos. Crea tres tablas en ella:



CREATE DATABASE IF NOT EXISTS `db_proyectos` 

USE `db_proyectos`;

CREATE TABLE IF NOT EXISTS `proyectos` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  `nombre` varchar(50) DEFAULT NULL,

  `descripcion` text DEFAULT NULL,

  `fecha_creacion` date DEFAULT NULL,

  PRIMARY KEY (`id`)

) 

CREATE TABLE IF NOT EXISTS `tareas` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  `proyecto_id` int(11) DEFAULT NULL,

  `nombre` varchar(50) DEFAULT NULL,

  `descripcion` text DEFAULT NULL,

  `estado` enum(‘Pendiente’,’En progreso’,’Completada’) DEFAULT NULL,

  `usuario` varchar(200) DEFAULT NULL,

  PRIMARY KEY (`id`),

  KEY `proyecto_id` (`proyecto_id`),

  CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`)

) 

CREATE TABLE IF NOT EXISTS `usuarios` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  `nombre` varchar(50) DEFAULT NULL,

  `correo` varchar(50) DEFAULT NULL,

  `contrasena` varchar(255) DEFAULT NULL,

  PRIMARY KEY (`id`)

)