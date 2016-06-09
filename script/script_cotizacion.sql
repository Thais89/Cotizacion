CREATE TABLE paquete (
  codigo INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nombre VARCHAR(100)  NULL  ,
  cantidad INTEGER UNSIGNED  NULL  ,
  monto FLOAT  NULL  ,
  descuento FLOAT  NULL    ,
PRIMARY KEY(codigo));



CREATE TABLE tipo_producto (
  idtipo_producto INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  descripcion VARCHAR(200)  NULL    ,
PRIMARY KEY(idtipo_producto));



CREATE TABLE usuario (
  idusuario INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nombre VARCHAR(100)  NULL  ,
  apellido VARCHAR(100)  NULL  ,
  usuario VARCHAR(50)  NULL  ,
  contrasena VARCHAR(200)  NULL  ,
  rol INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(idusuario));



CREATE TABLE producto (
  codigo INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  fk_tipo_producto INTEGER UNSIGNED  NOT NULL  ,
  nombre VARCHAR(100)  NULL  ,
  cantidad INTEGER UNSIGNED  NULL  ,
  precio FLOAT  NULL  ,
  impuesto FLOAT  NULL    ,
PRIMARY KEY(codigo)  ,
INDEX producto_FKIndex1(fk_tipo_producto),
  FOREIGN KEY(fk_tipo_producto)
    REFERENCES tipo_producto(idtipo_producto)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE cotizacion (
  idcotizacion INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  fk_usuario INTEGER UNSIGNED  NOT NULL  ,
  nombre VARCHAR(100)  NULL  ,
  apellido VARCHAR(100)  NULL  ,
  ruc VARCHAR(30)  NULL  ,
  direccion VARCHAR(200)  NULL  ,
  fecha DATE  NULL  ,
  total FLOAT  NULL  ,
  descuento FLOAT  NULL    ,
PRIMARY KEY(idcotizacion)  ,
INDEX cotizacion_FKIndex1(fk_usuario),
  FOREIGN KEY(fk_usuario)
    REFERENCES usuario(idusuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE cotizacion_has_paquete (
  fkCotizacion INTEGER UNSIGNED  NOT NULL  ,
  fkPaquete INTEGER UNSIGNED  NOT NULL  ,
  cantidad INTEGER UNSIGNED  NULL  ,
  subtotal FLOAT  NULL  ,
  descuento FLOAT  NULL  ,
  total FLOAT  NULL    ,
PRIMARY KEY(fkCotizacion, fkPaquete)  ,
INDEX cotizacion_has_paquete_FKIndex1(fkCotizacion)  ,
INDEX cotizacion_has_paquete_FKIndex2(fkPaquete),
  FOREIGN KEY(fkCotizacion)
    REFERENCES cotizacion(idcotizacion)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(fkPaquete)
    REFERENCES paquete(codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE producto_has_paquete (
  producto_codigo INTEGER UNSIGNED  NOT NULL  ,
  paquete_codigo INTEGER UNSIGNED  NOT NULL  ,
  cantidad INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(producto_codigo, paquete_codigo)  ,
INDEX producto_has_paquete_FKIndex1(producto_codigo)  ,
INDEX producto_has_paquete_FKIndex2(paquete_codigo),
  FOREIGN KEY(producto_codigo)
    REFERENCES producto(codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(paquete_codigo)
    REFERENCES paquete(codigo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);




