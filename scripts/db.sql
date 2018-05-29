drop database if exists iani;
create database if not exists iani;

use iani;

create table persona
(id int unsigned auto_increment,
nombre varchar (100) not null,
apellido varchar(100) not null,
dni varchar (50) not null,
email varchar (200),
cuil int,
razon_social varchar (200) not null,
inquilino_de int,
primary key (id),
constraint persona foreign key (inquilino_de) references persona (id));

create table usuario
(id int unsigned auto_increment,
user varchar (50) not null,
pass password not null,
estado varchar (50) not null,
id_persona int not null,
primary key (id),
constraint persona foreign key (id_persona) references persona (id));

create table rol
(id int unsigned auto_increment,
id_usuario int not null,
primary key (id),
constraint usuario foreign key (id_usuario) references usuario (id));

create table rolUsuario
(id int unsigned auto_increment,
rol_config int not null,
descripcion varchar (200),
primary key (id),
constraint rol foreign key (id_rol) references rol (id));


create table comuna
(id int unsigned auto_increment,
descripcion varchar (200),
primary key (id));

create table barrio
(id int unsigned auto_increment,
id_comuna int not null,
codigo_postal varchar (15) not null,
descripcion varchar (200),
primary key (id),
constraint comuna foreign key (id_comuna) references comuna (id));

create table consorcio
(id int unsigned auto_increment,
nombre varchar (200) not null,
cuit int not null,
calle varchar (100) not null,
altura int not null,
telefono int,
email varchar (200),
coordenada int,
id_barrio int  not null,
primary key (id),
constraint barrio foreign key (id_barrio) references barrio (id));

create table unidad
(id int unsigned auto_increment,
prc_participacion int not null,
piso int not null,
departamento varchar (2) not null,
nro_unidad int not null,
id_consorcio int not null,
id_usuario int not null,
primary key (id),
constraint consorcio foreign key (id_consorcio) references consorcio (id),
constraint usuario foreign key (id_usuario) references usuario (id));

create table propietarioConsejo
(id int unsigned auto_increment,
id_usuario int not null,
id_consorcio int not null,
primary key (id),
constraint consorcio foreign key (id_consorcio) references consorcio (id),
constraint usuario foreign key (id_usuario) references usuario (id));

create table cuentaCorriente
(id int unsigned auto_increment,
saldo int not null,
saldo_favor int not null,
id_unidad int,
primary key (id),
constraint unidad foreign key (id_unidad) references unidad (id));

create table formaPago
(id int unsigned auto_increment,
descripcion varchar (200),
cotizacion int not null,
tipo varchar (100) not null,
primary key (id));

create table pagoExpensa
(id int unsigned auto_increment,
importe int not null,
fecha date not null,
hora datetime not null,
id_ctacte int not null,
id_usaurio int not null,
id_forma_pago int not null,
primary key (id),
constraint ctacte foreign key (id_ctacte) references cuentaCorriente (id),
constraint usuario foreign key (id_usuario) references usuario (id),
constraint formaPago foreign key (id_forma_pago) references formaPago (id));

create table gastoMensual
(id int unsigned auto_increment,
periodo varchar (50) not null,
fecha date not null,
total int not null,
importe_mantenimiento int,
importe_luz int,
importe_agua int,
id_consorcio int not null,
primary key (id),
constraint consorcio foreign key (id_consorcio) references consorcio(id));

create table expensa
(id int unsigned auto_increment,
cuota_expensa int not null,
cuota_extraordinaria int not null,
cuota_mora int,
cuota_mes int not null,
cuota_vencimiento int not null,
cuota_estado int not null,
id_ctacte int not null,
id_gasto_mensual int not null,
primary key (id),
constraint ctacte foreign key (id_ctacte) references cuentaCorriente (id),
constraint gastoMensual foreign key (id_gasto_mensual) references gastoMensual (id));

create table rubroProveedor
(id int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id));

create table proveedor
(id int unsigned auto_increment,
razon_social varchar (200) not null,
telefono int not null,
email varchar (200) not null,
calle varchar (200) not null,
altura int not null,
id_barrio int not null,
id_rubro_proveedor int not null,
primary key (id),
constraint barrio foreign key (id_barrio) references barrio (id),
constraint rubro_proveedor foreign key (id_rubro_proveedor) references rubroProvedor (id));

create table rubroGasto
(id int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id));

create table motivoGasto
(id int unsigned auto_increment,
descripcion varchar (200) not null,
id_rubro_gasto int not null,
primary key (id),
constraint rubro_gasto foreign key (id_rubro_gasto) references rubroGasto (id));

create table pagoGasto
(id int unsigned auto_increment,
nro_orden_pago int not null,
id_gasto int not null,
primary key (id),
constraint orden_pago foreign key (id_gasto) references gasto (id));

create table motivoReclamo
(id int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id));

create table reclamo
(id int unsigned auto_increment,
nro_reclamo int not null,
titulo varchar (500) not null,
mensaje varchar (10000) not null,
fecha date not null,
hora datetime not null,
id_propietario int not null,
id_motivo int not null,
primary key (id),
constraint propietario foreign key (id_propietario) references propietario (id),
constraint motivo foreign key (id_motivo) references motivo (id));

create table gasto
(id int unsigned auto_increment,
nro_comprobante int not null,
fecha date not null,
descripcion varchar (200) not null,
importe int not null,
id_gasto_motivo int not null,
id_proveedor int not null,
id_gasto_mensual int not null,
id_reclamo int not null,
id_operador int not null,
primary key (id),
constraint gasto_motivo foreign key (id_gasto_motivo) references motivoGasto (id),
constraint proveedor foreign key (id_proveedor) references proveedor (id),
constraint gasto_mensual foreign key (id_gasto_mensual) references gastoMensual (id),
constraint reclamo foreign key (id_reclamo) references reclamo (id),
constraint operador foreign key (id_operador) references usuario (id));