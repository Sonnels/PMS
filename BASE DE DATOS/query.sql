CREATE TABLE huesped_adicional (
    idHuespedAdicional INT PRIMARY KEY AUTO_INCREMENT,
    IdReserva INT NOT NULL,
    IdCliente INT NOT NULL,
    FOREIGN KEY (IdReserva) REFERENCES reserva (IdReserva),
    FOREIGN KEY (IdCliente) REFERENCES cliente (IdCliente)
);