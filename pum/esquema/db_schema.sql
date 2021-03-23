-- DROP DATABASE IF EXISTS crm_emprendedor;
-- CREATE DATABASE IF NOT EXISTS crm_emprendedor;
-- USE crm_emprendedor;

CREATE TABLE personas(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(100) NOT NULL,
	apellido VARCHAR(100) NOT NULL,
	nacimiento date,
	correo VARCHAR(255) NOT NULL,
	telefono VARCHAR(20) NOT NULL,
	PRIMARY KEY (id)
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;

CREATE TABLE empresas(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	RUC BIGINT NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	rubro VARCHAR(100) NOT NULL,
	direccion MEDIUMTEXT NOT NULL,
	PRIMARY KEY(id)
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;

CREATE TABLE mensajes(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	titulo MEDIUMTEXT NOT NULL,
	descripcion MEDIUMTEXT,
	fecha datetime NOT NULL,
	id_persona BIGINT NOT NULL,
	id_empresa BIGINT NOT NULL,
	PRIMARY KEY (id)
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;

CREATE TABLE status_documentos(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	status VARCHAR(255),
	PRIMARY KEY (id)
) engine = INNODB DEFAULT CHARACTER SET = UTF8;

CREATE TABLE atencion (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_persona BIGINT UNSIGNED NOT NULL,
	status VARCHAR(100),
	pedido VARCHAR(255) NOT NULL,
	fecha datetime NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_persona) REFERENCES personas (id) ON DELETE CASCADE
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;


CREATE TABLE usuarios (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	tipoUsuario VARCHAR(50) NOT NULL,
	usuarioIngreso VARCHAR(50) NOT NULL,
	palabraClave VARCHAR(50) NOT NULL,
	estadoUsuario VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
) ENGINE = INNODB DEFAULT CHARACTER SET=UTF8;


CREATE TABLE personal(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_persona BIGINT UNSIGNED NOT NULL,
	id_usuario BIGINT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_persona) REFERENCES personas (id) ON DELETE CASCADE,
	FOREIGN KEY (id_usuario) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;


CREATE TABLE proveedores(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_empresa BIGINT UNSIGNED NOT NULL,
	id_usuario BIGINT UNSIGNED NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (id_empresa) REFERENCES empresas (id) ON DELETE CASCADE,
	FOREIGN KEY (id_usuario) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;

CREATE TABLE documentosProveedor(
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_proveedor BIGINT UNSIGNED NOT NULL,
	id_status BIGINT UNSIGNED NOT NULL,
	id_mensaje BIGINT UNSIGNED NOT NULL,
	nombreArchivo VARCHAR(255) NOT NULL,
	fecha datetime NOT NULL,
	visulizaciones VARCHAR(255) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_proveedor) REFERENCES proveedores (id_empresa) ON DELETE CASCADE,
	FOREIGN KEY (id_status) REFERENCES status_documentos (id) ON DELETE CASCADE,
	FOREIGN KEY (id_mensaje) REFERENCES mensajes (id) ON DELETE CASCADE
) ENGINE = INNODB DEFAULT CHARACTER SET = UTF8;

INSERT INTO status_documentos(id,status) 
VALUES
(1,"Alto"),(2,"Medio"),(3,"Bajo");

INSERT INTO personas(id, nombre, apellido, nacimiento, correo, telefono)
VALUES
(1,'Administrador',' ','2020-03-16','hola@elrinconemprendedor.com','123456789');
INSERT INTO usuarios(id, tipoUsuario, usuarioIngreso, palabraClave, estadoUsuario)
VALUES
(1,"Administrador",'admin','40bd001563085fc35165329ea1ff5c5ecbdbbeef',"1");
INSERT INTO personal(id, id_persona, id_usuario)
VALUES
(1,1,1);