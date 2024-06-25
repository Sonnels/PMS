-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2023 a las 22:43:23
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `syshotel_40`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apartar`
--

CREATE TABLE `apartar` (
  `idApartar` int(11) NOT NULL,
  `Num_Hab` int(11) NOT NULL,
  `fecIn` datetime NOT NULL,
  `horIn` time NOT NULL,
  `fecOut` datetime NOT NULL,
  `horOut` time NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `codCaja` int(11) NOT NULL,
  `horaApertura` time NOT NULL,
  `fechaApertura` date NOT NULL,
  `montoApertura` decimal(18,2) NOT NULL,
  `horaCierre` time DEFAULT NULL,
  `fechaCierre` date DEFAULT NULL,
  `montoCierre` decimal(18,2) DEFAULT NULL,
  `codUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`codCaja`, `horaApertura`, `fechaApertura`, `montoApertura`, `horaCierre`, `fechaCierre`, `montoCierre`, `codUsuario`) VALUES
(2, '17:19:25', '2023-09-08', '0.00', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoria` int(11) NOT NULL,
  `Denominacion` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`IdCategoria`, `Denominacion`) VALUES
(1, 'Servicio'),
(11, 'Bebidas'),
(12, 'Desechables'),
(13, 'Cigarros'),
(14, 'Preservativos'),
(15, 'Productos Varios'),
(16, 'Botanas'),
(17, 'Cerveza'),
(18, 'Alimentos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IdCliente` int(11) NOT NULL,
  `Nombre` varchar(40) NOT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `Celular` varchar(15) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `TipDocumento` varchar(20) NOT NULL,
  `NumDocumento` varchar(15) DEFAULT NULL,
  `Direccion` varchar(40) DEFAULT NULL,
  `nroMatricula` varchar(50) DEFAULT NULL,
  `captura` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo`
--

CREATE TABLE `consumo` (
  `IdConsumo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `precioVenta` decimal(18,2) DEFAULT NULL,
  `Total` decimal(18,2) NOT NULL,
  `Estado` varchar(20) NOT NULL,
  `FechConsumo` date NOT NULL,
  `horaConsumo` time DEFAULT NULL,
  `IdProducto` int(11) NOT NULL,
  `FechaPago` datetime DEFAULT NULL,
  `metodoPago` varchar(50) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `IdReserva` int(11) NOT NULL,
  `codCaja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_hotel`
--

CREATE TABLE `datos_hotel` (
  `IdHotel` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `simboloMoneda` varchar(3) NOT NULL,
  `logo` varchar(80) NOT NULL,
  `ruc` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_hotel`
--

INSERT INTO `datos_hotel` (`IdHotel`, `nombre`, `direccion`, `telefono`, `simboloMoneda`, `logo`, `ruc`) VALUES
(1, 'WILI', 'ANDAHUAYLAS', '+51949046174', 'S/', 'cwil.png', '10703785256');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `valorUMedida` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioCompra` decimal(18,2) NOT NULL,
  `precioVenta` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_servicio`
--

CREATE TABLE `detalle_servicio` (
  `idDetalle_servicio` int(11) NOT NULL,
  `fdServicio` date DEFAULT NULL,
  `precioDS` decimal(18,2) DEFAULT NULL,
  `cantidadDS` int(11) DEFAULT NULL,
  `metPagDse` varchar(35) COLLATE latin1_spanish_ci DEFAULT NULL,
  `estServicio` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  `codCaja` int(11) DEFAULT NULL,
  `idServicio` int(11) NOT NULL,
  `IdReserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `codDetalle_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioVenta` decimal(18,2) NOT NULL,
  `descuento` decimal(18,2) DEFAULT NULL,
  `codVenta` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_limpieza`
--

CREATE TABLE `det_limpieza` (
  `idDetLim` int(11) NOT NULL,
  `fechaDetLim` date NOT NULL,
  `horaDetLim` time NOT NULL,
  `idPer` int(11) NOT NULL,
  `idLim` int(11) NOT NULL,
  `Num_Hab` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_caja`
--

CREATE TABLE `egreso_caja` (
  `codEgreso` int(11) NOT NULL,
  `horaEgreso` time NOT NULL,
  `fechaEgreso` date NOT NULL,
  `tipo` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `entregadoA` varchar(90) COLLATE latin1_spanish_ci DEFAULT NULL,
  `motivo` varchar(90) COLLATE latin1_spanish_ci DEFAULT NULL,
  `importe` decimal(18,2) NOT NULL,
  `estado` varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `codCaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `Num_Hab` int(11) NOT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `Estado` varchar(30) NOT NULL,
  `Precio` decimal(18,2) NOT NULL,
  `fecMan` datetime DEFAULT NULL,
  `resMan` varchar(91) DEFAULT NULL,
  `motMan` text DEFAULT NULL,
  `idDetLim` int(11) DEFAULT NULL,
  `IdTipoHabitacion` int(11) NOT NULL,
  `IdNivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huesped_adicional`
--

CREATE TABLE `huesped_adicional` (
  `idHuespedAdicional` int(11) NOT NULL,
  `IdReserva` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_caja`
--

CREATE TABLE `ingreso_caja` (
  `codIngreso` int(11) NOT NULL,
  `horaIngreso` time NOT NULL,
  `fechaIngreso` date NOT NULL,
  `recibidoDe` varchar(90) COLLATE latin1_spanish_ci DEFAULT NULL,
  `motivo` varchar(90) COLLATE latin1_spanish_ci DEFAULT NULL,
  `importe` decimal(18,2) NOT NULL,
  `estado` varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  `metodoPago` varchar(30) COLLATE latin1_spanish_ci DEFAULT NULL,
  `IdReserva` int(11) DEFAULT NULL,
  `codUsuario` int(11) NOT NULL,
  `codCaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `IdNivel` int(11) NOT NULL,
  `Denominacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`IdNivel`, `Denominacion`) VALUES
(1, 'Piso Uno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `IdPago` int(11) NOT NULL,
  `TipoComprobante` varchar(20) DEFAULT NULL,
  `NumComprobante` varchar(12) DEFAULT NULL,
  `Igv` decimal(18,2) DEFAULT NULL,
  `Pago2` decimal(18,2) DEFAULT NULL,
  `TotalPago` decimal(18,2) NOT NULL,
  `FechaEmision` date DEFAULT NULL,
  `horaSalida_o` time DEFAULT NULL,
  `departure_date` datetime NOT NULL,
  `FechaPago` datetime NOT NULL,
  `Estado` varchar(20) DEFAULT NULL,
  `Penalidad` decimal(18,2) DEFAULT NULL,
  `IdReserva` int(11) NOT NULL,
  `codCaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPagos` int(11) NOT NULL,
  `fecPag` datetime NOT NULL,
  `motPag` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `metPag` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `desPag` decimal(18,2) NOT NULL,
  `monPag` decimal(18,2) NOT NULL,
  `IdReserva` int(11) NOT NULL,
  `codCaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `idPer` int(11) NOT NULL,
  `nomPer` varchar(181) COLLATE latin1_spanish_ci NOT NULL,
  `telPer` varchar(25) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idPer`, `nomPer`, `telPer`) VALUES
(1, 'PERSONAL DE LIMPIEZA', '3317104358');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL,
  `NombProducto` varchar(40) NOT NULL,
  `Imagen` varchar(200) DEFAULT NULL,
  `Precio` decimal(18,2) DEFAULT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `IdCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto`, `NombProducto`, `Imagen`, `Precio`, `Descripcion`, `stock`, `IdCategoria`) VALUES
(87, 'Wifi', NULL, '10.00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idpro` int(11) NOT NULL,
  `nomPro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idpro`, `nomPro`, `phone`) VALUES
(1, 'SIN ESPECIFICAR', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renovacion`
--

CREATE TABLE `renovacion` (
  `idRenovacion` int(11) NOT NULL,
  `fRenovacion` datetime NOT NULL,
  `fIniRen` datetime NOT NULL,
  `fFinRen` datetime NOT NULL,
  `tarRen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `canRen` int(11) NOT NULL,
  `metPagRen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descuentoRen` decimal(18,2) NOT NULL,
  `cosRen` decimal(18,2) NOT NULL,
  `IdReserva` int(11) NOT NULL,
  `codCaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `IdReserva` int(11) NOT NULL,
  `FechReserva` date DEFAULT NULL,
  `FechEntrada` date DEFAULT NULL,
  `HoraEntrada` time DEFAULT NULL,
  `FechSalida` date NOT NULL,
  `entry_date` datetime NOT NULL,
  `CostoAlojamiento` decimal(18,2) NOT NULL,
  `descuento` decimal(18,2) DEFAULT NULL,
  `Observacion` varchar(200) DEFAULT NULL,
  `Estado` varchar(20) NOT NULL,
  `horaSalida` time DEFAULT NULL,
  `toalla` varchar(30) DEFAULT NULL,
  `servicio` varchar(80) DEFAULT NULL,
  `cantMes` int(11) DEFAULT NULL,
  `metodoPago` varchar(50) DEFAULT NULL,
  `regPago` tinyint(1) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `Num_Hab` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resp_alquiler`
--

CREATE TABLE `resp_alquiler` (
  `idResAlq` int(11) NOT NULL,
  `IdReserva` int(11) NOT NULL,
  `fechEntrada` date NOT NULL,
  `horaEntrada` time NOT NULL,
  `fechSalida` date NOT NULL,
  `horaSalida` time NOT NULL,
  `costoAlojamiento` decimal(18,2) DEFAULT NULL,
  `numHab` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `motElim` text COLLATE latin1_spanish_ci NOT NULL,
  `fechElim` date NOT NULL,
  `horaElim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL,
  `nombreS` varchar(191) COLLATE latin1_spanish_ci NOT NULL,
  `precioS` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`idServicio`, `nombreS`, `precioS`) VALUES
(7, 'Prueba Servicio 1', '50.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohabitacion`
--

CREATE TABLE `tipohabitacion` (
  `IdTipoHabitacion` int(11) NOT NULL,
  `Denominacion` varchar(50) NOT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `precioHora` decimal(18,2) DEFAULT NULL,
  `precioHora6` decimal(18,2) DEFAULT NULL,
  `precioHora8` decimal(18,2) DEFAULT NULL,
  `precioNoche` decimal(18,2) DEFAULT NULL,
  `precioMes` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `idTipDoc` int(11) NOT NULL,
  `nomTipDoc` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `longitud` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`idTipDoc`, `nomTipDoc`, `longitud`) VALUES
(3, 'PASAPORTE', 15),
(4, 'DNI', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_limpieza`
--

CREATE TABLE `tipo_limpieza` (
  `idLim` int(11) NOT NULL,
  `nomLim` varchar(181) COLLATE latin1_spanish_ci NOT NULL,
  `tieLim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_limpieza`
--

INSERT INTO `tipo_limpieza` (`idLim`, `nomLim`, `tieLim`) VALUES
(1, 'PROFUNDA', 40),
(2, 'RAPIDA', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `idUnidadMedida` int(11) NOT NULL,
  `nombreUM` varchar(191) COLLATE latin1_spanish_ci NOT NULL,
  `valorUM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`idUnidadMedida`, `nombreUM`, `valorUM`) VALUES
(1, 'Docena', 12),
(2, 'Unidad', 1),
(3, 'Decena', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `NumDocumento` varchar(15) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Celular` varchar(15) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `NumDocumento`, `Nombre`, `Apellido`, `password`, `Estado`, `Celular`, `email`, `tipo`) VALUES
(1, '12345679', 'WILFREDO VARGAS CARDENAS', '', '$2y$10$6p4.XVUzgbQCsq5iiO5D8.1T0E5bpeDMWVbN8UhnWNsSwlE/d6L0C', 'ACTIVO', '949046173', 'admin@gmail.com', 'ADMINISTRADOR'),
(6, '56958584', 'NOMBRE DE LA RECEPCIONISTA', NULL, '$2y$10$bQqv1HB4cyCQ9/5L5eSovuBIkgFszOA9xluRSa0u5jL3PjCLe7Tra', 'ACTIVO', NULL, 'recepcionista@gmail.com', 'RECEPCIONISTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `codVenta` int(11) NOT NULL,
  `fechaVenta` date NOT NULL,
  `horaVenta` time NOT NULL,
  `totalVenta` decimal(18,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `metodoPago` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IdCliente` int(11) NOT NULL,
  `codCaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apartar`
--
ALTER TABLE `apartar`
  ADD PRIMARY KEY (`idApartar`),
  ADD KEY `Num_Hab` (`Num_Hab`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`codCaja`),
  ADD KEY `codUsuario` (`codUsuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdCliente`);

--
-- Indices de la tabla `consumo`
--
ALTER TABLE `consumo`
  ADD PRIMARY KEY (`IdConsumo`),
  ADD KEY `fk_1` (`IdProducto`),
  ADD KEY `IdReserva` (`IdReserva`);

--
-- Indices de la tabla `datos_hotel`
--
ALTER TABLE `datos_hotel`
  ADD PRIMARY KEY (`IdHotel`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `idingreso` (`idingreso`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD PRIMARY KEY (`idDetalle_servicio`),
  ADD KEY `idServicio` (`idServicio`),
  ADD KEY `IdReserva` (`IdReserva`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`codDetalle_venta`),
  ADD KEY `codVenta` (`codVenta`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `det_limpieza`
--
ALTER TABLE `det_limpieza`
  ADD PRIMARY KEY (`idDetLim`),
  ADD KEY `idPer` (`idPer`),
  ADD KEY `idLim` (`idLim`),
  ADD KEY `Num_Hab` (`Num_Hab`);

--
-- Indices de la tabla `egreso_caja`
--
ALTER TABLE `egreso_caja`
  ADD PRIMARY KEY (`codEgreso`),
  ADD KEY `codUsuario` (`codUsuario`),
  ADD KEY `codCaja` (`codCaja`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`Num_Hab`),
  ADD KEY `fk_3` (`IdTipoHabitacion`),
  ADD KEY `fk_4` (`IdNivel`);

--
-- Indices de la tabla `huesped_adicional`
--
ALTER TABLE `huesped_adicional`
  ADD PRIMARY KEY (`idHuespedAdicional`),
  ADD KEY `IdReserva` (`IdReserva`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `idpro` (`idpro`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `ingreso_caja`
--
ALTER TABLE `ingreso_caja`
  ADD PRIMARY KEY (`codIngreso`),
  ADD KEY `codUsuario` (`codUsuario`),
  ADD KEY `codCaja` (`codCaja`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`IdNivel`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`IdPago`),
  ADD KEY `IdReserva` (`IdReserva`),
  ADD KEY `codCaja` (`codCaja`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPagos`),
  ADD KEY `IdReserva` (`IdReserva`),
  ADD KEY `codCaja` (`codCaja`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idPer`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `fk_6` (`IdCategoria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idpro`);

--
-- Indices de la tabla `renovacion`
--
ALTER TABLE `renovacion`
  ADD PRIMARY KEY (`idRenovacion`),
  ADD KEY `IdReserva` (`IdReserva`),
  ADD KEY `codCaja` (`codCaja`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`IdReserva`),
  ADD KEY `fk_7` (`IdCliente`),
  ADD KEY `fk_8` (`Num_Hab`),
  ADD KEY `fk_9` (`IdUsuario`);

--
-- Indices de la tabla `resp_alquiler`
--
ALTER TABLE `resp_alquiler`
  ADD PRIMARY KEY (`idResAlq`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`idServicio`);

--
-- Indices de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  ADD PRIMARY KEY (`IdTipoHabitacion`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`idTipDoc`);

--
-- Indices de la tabla `tipo_limpieza`
--
ALTER TABLE `tipo_limpieza`
  ADD PRIMARY KEY (`idLim`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`idUnidadMedida`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`codVenta`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `codCaja` (`codCaja`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apartar`
--
ALTER TABLE `apartar`
  MODIFY `idApartar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `codCaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `consumo`
--
ALTER TABLE `consumo`
  MODIFY `IdConsumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_hotel`
--
ALTER TABLE `datos_hotel`
  MODIFY `IdHotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  MODIFY `idDetalle_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `codDetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `det_limpieza`
--
ALTER TABLE `det_limpieza`
  MODIFY `idDetLim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `egreso_caja`
--
ALTER TABLE `egreso_caja`
  MODIFY `codEgreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `huesped_adicional`
--
ALTER TABLE `huesped_adicional`
  MODIFY `idHuespedAdicional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ingreso_caja`
--
ALTER TABLE `ingreso_caja`
  MODIFY `codIngreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `IdNivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `IdPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPagos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idPer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `renovacion`
--
ALTER TABLE `renovacion`
  MODIFY `idRenovacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `IdReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `resp_alquiler`
--
ALTER TABLE `resp_alquiler`
  MODIFY `idResAlq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  MODIFY `IdTipoHabitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `idTipDoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_limpieza`
--
ALTER TABLE `tipo_limpieza`
  MODIFY `idLim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `idUnidadMedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `codVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apartar`
--
ALTER TABLE `apartar`
  ADD CONSTRAINT `apartar_ibfk_1` FOREIGN KEY (`Num_Hab`) REFERENCES `habitacion` (`Num_Hab`),
  ADD CONSTRAINT `apartar_ibfk_2` FOREIGN KEY (`IdCliente`) REFERENCES `cliente` (`IdCliente`),
  ADD CONSTRAINT `apartar_ibfk_3` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `consumo`
--
ALTER TABLE `consumo`
  ADD CONSTRAINT `consumo_ibfk_2` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`),
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`);

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `detalle_ingreso_ibfk_1` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`),
  ADD CONSTRAINT `detalle_ingreso_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`);

--
-- Filtros para la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD CONSTRAINT `detalle_servicio_ibfk_1` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`),
  ADD CONSTRAINT `detalle_servicio_ibfk_2` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`codVenta`) REFERENCES `venta` (`codVenta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`);

--
-- Filtros para la tabla `det_limpieza`
--
ALTER TABLE `det_limpieza`
  ADD CONSTRAINT `det_limpieza_ibfk_1` FOREIGN KEY (`idPer`) REFERENCES `personal` (`idPer`),
  ADD CONSTRAINT `det_limpieza_ibfk_2` FOREIGN KEY (`idLim`) REFERENCES `tipo_limpieza` (`idLim`),
  ADD CONSTRAINT `det_limpieza_ibfk_3` FOREIGN KEY (`Num_Hab`) REFERENCES `habitacion` (`Num_Hab`);

--
-- Filtros para la tabla `egreso_caja`
--
ALTER TABLE `egreso_caja`
  ADD CONSTRAINT `egreso_caja_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `egreso_caja_ibfk_2` FOREIGN KEY (`codCaja`) REFERENCES `caja` (`codCaja`);

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `fk_3` FOREIGN KEY (`IdTipoHabitacion`) REFERENCES `tipohabitacion` (`IdTipoHabitacion`),
  ADD CONSTRAINT `fk_4` FOREIGN KEY (`IdNivel`) REFERENCES `nivel` (`IdNivel`);

--
-- Filtros para la tabla `huesped_adicional`
--
ALTER TABLE `huesped_adicional`
  ADD CONSTRAINT `huesped_adicional_ibfk_1` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`),
  ADD CONSTRAINT `huesped_adicional_ibfk_2` FOREIGN KEY (`IdCliente`) REFERENCES `cliente` (`IdCliente`);

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `ingreso_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `proveedor` (`idpro`),
  ADD CONSTRAINT `ingreso_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `ingreso_caja`
--
ALTER TABLE `ingreso_caja`
  ADD CONSTRAINT `ingreso_caja_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `ingreso_caja_ibfk_2` FOREIGN KEY (`codCaja`) REFERENCES `caja` (`codCaja`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`codCaja`) REFERENCES `caja` (`codCaja`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`codCaja`) REFERENCES `caja` (`codCaja`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_6` FOREIGN KEY (`IdCategoria`) REFERENCES `categoria` (`IdCategoria`);

--
-- Filtros para la tabla `renovacion`
--
ALTER TABLE `renovacion`
  ADD CONSTRAINT `renovacion_ibfk_1` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`),
  ADD CONSTRAINT `renovacion_ibfk_2` FOREIGN KEY (`codCaja`) REFERENCES `caja` (`codCaja`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_7` FOREIGN KEY (`IdCliente`) REFERENCES `cliente` (`IdCliente`),
  ADD CONSTRAINT `fk_8` FOREIGN KEY (`Num_Hab`) REFERENCES `habitacion` (`Num_Hab`),
  ADD CONSTRAINT `fk_9` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `resp_alquiler`
--
ALTER TABLE `resp_alquiler`
  ADD CONSTRAINT `resp_alquiler_ibfk_1` FOREIGN KEY (`IdCliente`) REFERENCES `cliente` (`IdCliente`),
  ADD CONSTRAINT `resp_alquiler_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`IdCliente`) REFERENCES `cliente` (`IdCliente`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`codCaja`) REFERENCES `caja` (`codCaja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
