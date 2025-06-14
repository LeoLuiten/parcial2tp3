-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2025 a las 08:04:23
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `consultora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `Id` int(11) NOT NULL,
  `Denominacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`Id`, `Denominacion`) VALUES
(1, 'Analisis Iniciado'),
(2, 'En Desarrollo'),
(3, 'Terminado'),
(4, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `Id` int(11) NOT NULL,
  `Denominacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Imagen` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`Id`, `Denominacion`, `Imagen`) VALUES
(1, 'Argentina', 'ARG.jpg'),
(2, 'Chile', 'CHI.jpg'),
(3, 'Uruguay', 'URU.jpg'),
(4, 'Braasil', 'BRA.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `Denominacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`Id`, `Denominacion`) VALUES
(1, 'Administrador'),
(2, 'Lider'),
(3, 'Analista Funcional'),
(4, 'Programador/a');

-- --------------------------------------------------------
-- NUEVAS TABLAS CREADAS SEGÚN ANÁLISIS DE PLANTILLAS HTML
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
-- (Analizada desde listado_usuarios.html)
--
CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Foto` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Id_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (`Id`, `Nombre`, `Apellido`, `Usuario`, `Password`, `Foto`, `Id_Rol`) VALUES
(1, 'Mara', 'Ferrero', 'mferrero', MD5('123456'), 'mferrero.jpg', 4),
(2, 'Marcos', 'Gutierrez', 'mgutierrez', MD5('123456'), 'mgutierrez.jpg', 2),
(3, 'William', 'Jhonson', 'wjhonson', MD5('123456'), 'wjhonson.jpg', 2),
(4, 'Sue', 'Palacios', 'spalacios', MD5('admin123'), 'spalacios.png', 1),
(5, 'Anna', 'Rodriguez', 'arodriguez', MD5('123456'), 'arodriguez.jpg', 2),
(6, 'Carla', 'Sanabria', 'csanabria', MD5('123456'), 'csanabria.jpg', 3);

--
-- Estructura de tabla para la tabla `empresas`
-- (Analizada desde carga_empresa.html y listado_empresas.html)
--
CREATE TABLE `empresas` (
  `Id` int(11) NOT NULL,
  `Denominacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Id_Pais` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NULL,
  `Fecha_Carga` date NOT NULL,
  `Id_Usuario_Carga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresas`
--
INSERT INTO `empresas` (`Id`, `Denominacion`, `Id_Pais`, `Observaciones`, `Fecha_Carga`, `Id_Usuario_Carga`) VALUES
(1, 'AVEC Automotores', 3, 'Cliente importante de Uruguay', '2025-05-11', 6),
(2, 'Mercado Libre Brasil', 4, 'Filial brasileña', '2025-05-12', 1),
(3, 'Pinturerias Tersuave', 1, 'Cadena de pinturerías', '2025-05-13', 2),
(4, 'La Serena Automotores', 2, 'Concesionario chileno', '2025-05-14', 1);

--
-- Estructura de tabla para la tabla `proyectos`
-- (Analizada desde carga_proyecto.html y listado_proyectos.html)
--
CREATE TABLE `proyectos` (
  `Id` int(11) NOT NULL,
  `Denominacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Id_Empresa` int(11) NOT NULL,
  `Id_Lider` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NULL,
  `Prioridad` tinyint(1) NOT NULL DEFAULT 0,
  `Id_Estado` int(11) NOT NULL DEFAULT 1,
  `Fecha_Carga` date NOT NULL,
  `Id_Usuario_Carga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proyectos`
--
INSERT INTO `proyectos` (`Id`, `Denominacion`, `Id_Empresa`, `Id_Lider`, `Observaciones`, `Prioridad`, `Id_Estado`, `Fecha_Carga`, `Id_Usuario_Carga`) VALUES
(1, 'ECommerce Renovación', 1, 5, 'Modernización completa del sitio web', 1, 3, '2025-02-01', 4),
(2, 'Generación APIs + Documentación', 2, 2, 'APIs REST para integración móvil', 0, 2, '2025-02-10', 4),
(3, 'Adecuaciones en estructuras de Productos', 3, 3, 'Reestructuración de base de datos', 0, 1, '2025-03-15', 4),
(4, 'Cambios en seguridad al ingreso', 2, 2, 'Implementación de 2FA', 1, 1, '2025-03-18', 4),
(5, 'Gestión de Facturación Web', 4, 3, 'Sistema de facturación online', 0, 4, '2025-04-25', 4);

-- --------------------------------------------------------
-- ÍNDICES Y AUTO_INCREMENT
-- --------------------------------------------------------

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Usuario` (`Usuario`),
  ADD KEY `Id_Rol` (`Id_Rol`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Pais` (`Id_Pais`),
  ADD KEY `Id_Usuario_Carga` (`Id_Usuario_Carga`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Empresa` (`Id_Empresa`),
  ADD KEY `Id_Lider` (`Id_Lider`),
  ADD KEY `Id_Estado` (`Id_Estado`),
  ADD KEY `Id_Usuario_Carga` (`Id_Usuario_Carga`);

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `empresas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `proyectos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Id_Rol`) REFERENCES `roles` (`Id`);

ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`Id_Pais`) REFERENCES `paises` (`Id`),
  ADD CONSTRAINT `empresas_ibfk_2` FOREIGN KEY (`Id_Usuario_Carga`) REFERENCES `usuarios` (`Id`);

ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`Id_Empresa`) REFERENCES `empresas` (`Id`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`Id_Lider`) REFERENCES `usuarios` (`Id`),
  ADD CONSTRAINT `proyectos_ibfk_3` FOREIGN KEY (`Id_Estado`) REFERENCES `estados` (`Id`),
  ADD CONSTRAINT `proyectos_ibfk_4` FOREIGN KEY (`Id_Usuario_Carga`) REFERENCES `usuarios` (`Id`);

COMMIT;