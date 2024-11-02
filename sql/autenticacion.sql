-- phpMyAdmin SQL Dump
-- version 2.8.1
-- http://www.phpmyadmin.net
-- 
-- 
-- Base de datos: `autenticacion`
-- 
-- Crear la tabla 'usuario'
CREATE TABLE usuario (
    idusuario BIGINT(20) NOT NULL AUTO_INCREMENT,
    usnombre VARCHAR(50) NOT NULL,
    uspass VARCHAR(255) NOT NULL, -- Se cambió a VARCHAR para permitir contraseñas cifradas
    usmail VARCHAR(50) NOT NULL,
    usdeshabilitado TIMESTAMP NULL,
    PRIMARY KEY (idusuario)
);

-- Crear la tabla 'rol'
CREATE TABLE rol (
    idrol BIGINT(20) NOT NULL AUTO_INCREMENT,
    rodescripcion VARCHAR(50) NOT NULL,
    PRIMARY KEY (idrol)
);

-- Crear la tabla 'usuariorol'
CREATE TABLE usuariorol (
    idusuario BIGINT(20) NOT NULL,
    idrol BIGINT(20) NOT NULL,
    PRIMARY KEY (idusuario, idrol),
    FOREIGN KEY (idusuario) REFERENCES usuario(idusuario),
    FOREIGN KEY (idrol) REFERENCES rol(idrol)
);

-- Insertar los roles en la tabla 'rol'
INSERT INTO rol (rodescripcion) VALUES ('cliente'), ('administrador');

-- Insertar un usuario 'cliente'
INSERT INTO usuario (usnombre, uspass, usmail) 
VALUES ('cliente1', 'cliente123', 'cliente1@example.com');

-- Insertar un usuario 'administrador'
INSERT INTO usuario (usnombre, uspass, usmail) 
VALUES ('admin1', 'admin123', 'admin1@example.com');

-- Asignar el rol 'cliente' al primer usuario (idusuario = 1)
INSERT INTO usuariorol (idusuario, idrol) VALUES (1, 1);

-- Asignar el rol 'administrador' al segundo usuario (idusuario = 2)
INSERT INTO usuariorol (idusuario, idrol) VALUES (2, 2);
