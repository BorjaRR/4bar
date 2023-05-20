CREATE DATABASE 4bar;

CREATE TABLE restaurantes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    NIF VARCHAR(9) UNIQUE NOT NULL,
    telefono VARCHAR(9) NOT NULL,
    email VARCHAR(70) UNIQUE NOT NULL,
    pass VARCHAR (50) NOT NULL,
    direccion VARCHAR(200),
    cp MEDIUMINT(5),
    contacto VARCHAR(50),
    validado BOOLEAN NOT NULL,
    num_conf INT(4) NOT NULL  
);

CREATE TABLE mesas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    num_mesa INT NOT NULL,
    comensales INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    finalizado BOOLEAN NOT NULL DEFAULT 0,
    id_restaurante INT NOT NULL,
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

CREATE TABLE cuentas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    platos LONGTEXT,
    precio DOUBLE,
    comensales INT NOT NULL,
    id_mesa INT NOT NULL,
    FOREIGN KEY (id_mesa) REFERENCES mesas(id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE reservas( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    comensales INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    telefono INT(9) NOT NULL,
    id_restaurante INT NOT NULL, 
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE platos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    precio DOUBLE NOT NULL,
    id_restaurante INT NOT NULL, 
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE cierres(
    id INT PRIMARY KEY AUTO_INCREMENT,
    plato VARCHAR(50) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    precio DOUBLE NOT NULL,
    cantidad INT NOT NULL,
    id_restaurante INT NOT NULL, 
    FOREIGN KEY (id_restaurante) REFERENCES restaurantes(id)
);

CREATE TABLE facturas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    num_factura INT NOT NULL,
    fecha DATE NOT NULL,
    empresa VARCHAR(50) NOT NULL,
    nif VARCHAR(9) NOT NULL,
    contacto VARCHAR(20) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    ciudad VARCHAR(40) NOT NULL,
    provincia VARCHAR(20) NOT NULL,
    cp INT(5) NOT NULL, 
    telefono VARCHAR(9) NOT NULL,
    observaciones VARCHAR(400),
    precio DOUBLE NOT NULL,
    id_cuenta INT NOT NULL, 
    FOREIGN KEY (id_cuenta) REFERENCES cuentas(id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `restaurantes` (`id`, `nombre`, `NIF`, `telefono`, `email`, `pass`, `direccion`, `cp`, `contacto`, `validado`, `num_conf`) VALUES
(1, 'Ares The Ferret', '31244234G', '914376547', 'arestheferret@gmail.com', '123', 'C/Falsa 123', 24387, 'Borja', 1, 9999);

INSERT INTO `platos` (`id`, `nombre`, `categoria`, `precio`, `id_restaurante`) VALUES
(3, 'Sopa', 'principales', 10, 1),
(4, 'tiramisu', 'postres', 6, 1),
(5, 'Copa de vino', 'bebidas', 3, 1),
(6, 'Ensaladilla', 'entrantes', 12, 1),
(7, 'Oreja a la plancha', 'entrantes', 9, 1),
(8, 'Tarta de queso', 'postres', 6, 1),
(9, 'Copa Alvariño', 'bebidas', 4, 1),
(10, 'Carrilleras', 'principales', 25, 1),
(11, 'Cachuela', 'entrantes', 4, 1),
(12, 'Arroz con leche', 'postres', 5, 1);


INSERT INTO `reservas` (`id`, `nombre`, `comensales`, `fecha`, `hora`, `id_restaurante`) VALUES
(1, 'Borja', 3, '2021-11-12', '21:00:00', 1);

INSERT INTO `facturas` (`id`, `num_factura`, `fecha`, `empresa`, `nif`, `contacto`, `direccion`, `ciudad`, `provincia`, `cp`, `telefono`, `observaciones`, `precio`, `id_cuenta`) VALUES
(1, 1, '2021-11-14', 'Kreatika SA', '12345678O', 'Borja', 'Calle Beatriz de Bobadilla', 'Madrid', 'Madrid', 25032, '633282828', 'Prueba de factura n. 1', 0, 3);
