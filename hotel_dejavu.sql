-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2025 a las 17:29:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel_dejavu`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `documento` int(12) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contraseña` varchar(20) NOT NULL,
  `horario` datetime(6) NOT NULL,
  `cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `telefono`, `documento`, `correo`, `contraseña`, `horario`, `cargo`) VALUES
(1, 'Santiago', 'niño', '5551234567', 12345678, 'santyrod2004@gmail.com', 'admin123', '2024-12-10 08:00:00.000000', 1),
(2, 'Ana', 'Perez', '5559876543', 87654321, 'ana.perez@hotel.com', 'recep123', '2024-12-10 09:00:00.000000', 2),
(3, 'Luis', 'Martinez', '5552345678', 45678912, 'luis.martinez@hotel.com', 'maint123', '2024-12-10 10:00:00.000000', 3),
(4, 'Maria', 'Lopez', '5553456789', 56789123, 'maria.lopez@hotel.com', 'aseo123', '2024-12-10 11:00:00.000000', 4),
(6, 'Juan', 'Garzon', '360889682', 109987754, 'juanestebangarzon12@gmail.com', 'Juanes1212345', '2025-02-15 13:00:00.000000', 1),
(7, 'socrates', 'martinez', '3425625254242', 2147483647, 'socra@gmail.com', 'socra12345', '2025-02-13 05:50:00.000000', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id_habitacion` int(11) NOT NULL,
  `numero_habitacion` int(3) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `numero_personas` int(2) NOT NULL,
  `id_reserva` int(11) DEFAULT NULL,
  `id_huesped` int(11) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacioneshuespedes`
--

CREATE TABLE `habitacioneshuespedes` (
  `id_huesped` int(11) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `id_habitacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huespedes`
--

CREATE TABLE `huespedes` (
  `id_huesped` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `documento` int(12) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `nacionalidad` varchar(25) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contraseña` varchar(20) NOT NULL,
  `tipo_huesped` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `huespedes`
--

INSERT INTO `huespedes` (`id_huesped`, `nombre`, `apellido`, `documento`, `telefono`, `nacionalidad`, `correo`, `contraseña`, `tipo_huesped`) VALUES
(22, 'juan', 'perez', 2147483647, '234545467', 'boliviano', 'juan@gmail.com', 'zqjLoqenknxl', NULL),
(24, 'nicolas', 'niño', 2147483647, '36465476576', 'español', 'nico@gmail.com', '0pzNo6enknxl', NULL),
(25, 'susana', 'caro', 2147483647, '32455643654', 'colombiana', 'susy1505@gmail.com', '16jdraenknxl', NULL),
(26, 'valeria ', 'Rodriguez', 53054927, '3203992936', 'Colombiano', 'valeryrod2019@gmail.com', '2pTWmejul3tgrQ==', NULL),
(27, 'Diana', 'perez', 104345235, '3566557543', 'estadounidense', 'Dina@gmail.com', 'diana12345', NULL),
(33, 'guillermo', 'echavarria', 2147483647, '305483964', 'chileno', 'guille@gmail.com', '0ZTYqOjW13lipw==', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` varchar(15) NOT NULL,
  `numero_huespedes` int(2) NOT NULL,
  `tipo_habitacion` varchar(30) NOT NULL,
  `id_huesped` int(11) DEFAULT NULL,
  `roles_huespedes_id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaservicio`
--

CREATE TABLE `reservaservicio` (
  `costo_total` decimal(10,2) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `id_reserva` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reset_tokens`
--

CREATE TABLE `reset_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expiry_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reset_tokens`
--

INSERT INTO `reset_tokens` (`id`, `email`, `token`, `expiry_time`) VALUES
(1, 'valeryrod2019@gmail.com', '773cb934cc8c6a4064354f13c82211cfc89c7e21bb4b6cfe4079b2cef317b01c', '2025-02-20 07:07:13'),
(2, 'juan@gmail.com', 'fe9ac625a7141988f159b41813a0ab910ad139e1eaa972481238ad522e450875', '2025-02-20 06:46:11'),
(5, 'Dina@gmail.com', 'f8d950e160fd2a779d44386c765d0c26c93c93889a9ecc9173cbd9340b103aa7', '2025-02-20 07:08:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Recepcionista'),
(3, 'Mantenimiento'),
(4, 'Aseo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_huespedes`
--

CREATE TABLE `roles_huespedes` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_huespedes`
--

INSERT INTO `roles_huespedes` (`id_rol`, `nombre_rol`) VALUES
(1, 'casual'),
(2, 'reserva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombreServicio` varchar(45) NOT NULL,
  `tipoServicio` varchar(45) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `costo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` enum('pendiente','completada') NOT NULL DEFAULT 'pendiente',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_completada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tarea`, `id_empleado`, `descripcion`, `estado`, `fecha_creacion`, `fecha_completada`) VALUES
(3, 4, 'hacer aseo en la habitacion 402', 'pendiente', '2025-02-17 15:44:10', NULL),
(4, 4, 'limpiar recepcion', 'completada', '2025-02-17 15:44:19', '2025-02-17 15:44:21'),
(5, 4, 'limpiar cocina', 'pendiente', '2025-02-17 15:44:44', NULL),
(6, 7, 'llevar insumos a bodega', 'completada', '2025-02-17 15:46:14', '2025-02-17 15:46:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `fk_cargo` (`cargo`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id_habitacion`),
  ADD KEY `id_reserva` (`id_reserva`),
  ADD KEY `id_huesped` (`id_huesped`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `FK_id_servicio` (`id_servicio`);

--
-- Indices de la tabla `habitacioneshuespedes`
--
ALTER TABLE `habitacioneshuespedes`
  ADD KEY `id_huesped` (`id_huesped`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `huespedes`
--
ALTER TABLE `huespedes`
  ADD PRIMARY KEY (`id_huesped`),
  ADD KEY `tipo_huesped` (`tipo_huesped`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_huesped` (`id_huesped`),
  ADD KEY `roles_huespedes_id_rol` (`roles_huespedes_id_rol`);

--
-- Indices de la tabla `reservaservicio`
--
ALTER TABLE `reservaservicio`
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_reserva` (`id_reserva`);

--
-- Indices de la tabla `reset_tokens`
--
ALTER TABLE `reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `roles_huespedes`
--
ALTER TABLE `roles_huespedes`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `fk_tarea_empleado` (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `huespedes`
--
ALTER TABLE `huespedes`
  MODIFY `id_huesped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reset_tokens`
--
ALTER TABLE `reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles_huespedes`
--
ALTER TABLE `roles_huespedes`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_cargo` FOREIGN KEY (`cargo`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `FK_id_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `habitaciones_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`),
  ADD CONSTRAINT `habitaciones_ibfk_2` FOREIGN KEY (`id_huesped`) REFERENCES `huespedes` (`id_huesped`),
  ADD CONSTRAINT `habitaciones_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `roles_huespedes` (`id_rol`);

--
-- Filtros para la tabla `habitacioneshuespedes`
--
ALTER TABLE `habitacioneshuespedes`
  ADD CONSTRAINT `habitacioneshuespedes_ibfk_1` FOREIGN KEY (`id_huesped`) REFERENCES `huespedes` (`id_huesped`),
  ADD CONSTRAINT `habitacioneshuespedes_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles_huespedes` (`id_rol`),
  ADD CONSTRAINT `habitacioneshuespedes_ibfk_3` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id_habitacion`);

--
-- Filtros para la tabla `huespedes`
--
ALTER TABLE `huespedes`
  ADD CONSTRAINT `huespedes_ibfk_1` FOREIGN KEY (`tipo_huesped`) REFERENCES `roles_huespedes` (`id_rol`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_huesped`) REFERENCES `huespedes` (`id_huesped`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`roles_huespedes_id_rol`) REFERENCES `roles_huespedes` (`id_rol`);

--
-- Filtros para la tabla `reservaservicio`
--
ALTER TABLE `reservaservicio`
  ADD CONSTRAINT `reservaservicio_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `reservaservicio_ibfk_2` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`);

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `fk_tarea_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
